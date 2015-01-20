/***
 * 2015-01-19 by kamijin
 *
 * -- use --
 * <div id="chart" style="width: 200px; height: 200px;"></div>
 * $("#chart").kamiChart(["Run/60/#F66","Stop/40/#6F6"]);
 *
 * -- parm --
 * [
 *   "LabelName/Value/Color",
 *   "LabelName/Value/Color"
 * ]
 *
 */

/// <reference path="jquery.d.ts" />
/// <reference path="linq.d.ts" />
/// <reference path="linq.jquery.d.ts" />
/// <reference path="google.visualization.d.ts" />

class data {
    label: string;
    value: number;
    color: string;
}

interface JQuery{
    kamiChart(arg: Array<string>): JQuery;
}
(function($) {
    $.fn.kamiChart = function(arg: Array<string>){
        // arg: ["Run/60/#F66","Stop/40/#6F6"]
        var list = Enumerable.from(arg)
            .select(s => {
                var sp = Enumerable.from(s.split("/"));
                var data = <data>{
                    label: sp.elementAtOrDefault(0, ""),
                    value: parseInt(sp.elementAtOrDefault(1, "0")),
                    color: sp.elementAtOrDefault(2, "#AAA")
                };
                return data;
            });

        var d = list.select(s => [s.label, s.value]).toArray();
        var data = google.visualization.arrayToDataTable(
            [['Label', <any>'Value'],].concat(d)
        );

        var c = list.select((v,i)=> {return {key: i, val: v}}).toObject(s => s.key, s => s.val);

        var options = <google.visualization.PieChartOptions>{
            pieHole: 0.5,
            pieSliceTextStyle: {
                color: 'white'
            },
            slices: c,
            pieSliceText: 'label',
            legend: 'none',
            chartArea:{
                left: '5%',
                top: '5%',
                width: '90%',
                height: '90%'
            },
            animation:{
                duration: 1000,
                easing: 'out'
            }
        };

        google.setOnLoadCallback(() => {
            var chart = new google.visualization.PieChart($(this).get(0));
            chart.draw(data, options);

            $("<span></span>")
                .addClass("tip")
                .append(
                    $("<span></span>")
                        .addClass("tiptip")
                        .text("" + list.select(s=>s.value).elementAtOrDefault(0, 0) + "/" + list.sum(s=>s.value))
                )
                .appendTo($(this));
        });
        return this;
    };
})(jQuery);
