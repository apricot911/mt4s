<style type="text/css">
    #console{
        height:500px;
        background:#dcdcdc;
    }
    #instance_information{
        height:200px;
        background:#b92c28;
    }
</style>
<script src="/plugins/Chart.js/Chart.js"></script>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="col-xs-12" id="information">
                    <div class="row text-center">
                        <div class="col-xs-3">
                            <p class="lead">Load Average</p>
                            <span>10, 10, 10</span>
                        </div>
                        <div class="col-xs-3">
                            <p class="lead">RAM</p>
                            <canvas id="chart-area" width="150" height="150"/>
                        </div>
                        <div class="col-xs-3">
                            <p class="lead">Disk</p>
                        </div>
                        <div class="col-xs-3">
                            <p class="lead">IP</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="help-block">Manage</p>
                            <div class="row">
                                <div class="col-xs-8">
                                    <button class="btn btn-warning">reconfig</button>
                                </div>
                                <div class="col-xs-2">
                                    <button class="btn btn-primary">起動</button>
                                </div>
                                <div class="col-xs-2">
                                    <button class="btn btn-danger">停止</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p>config box</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div id="console">
                        <p>console</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="instance_information">
                        <p>information</p>
                        <p class="lead">&bcy; unko</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
    ...
</div>
<script>

    var pieData = [
        {
            value: 300,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Red"
        },
        {
            value: 50,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Green"
        },
        {
            value: 100,
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Yellow"
        },
        {
            value: 40,
            color: "#949FB1",
            highlight: "#A8B3C5",
            label: "Grey"
        },
        {
            value: 120,
            color: "#4D5360",
            highlight: "#616774",
            label: "Dark Grey"
        }

    ];

    window.onload = function(){
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx).Doughnut(pieData, {
            segmentShowStroke: true,
            animationEasing : "easeOutBounce",
            scaleShowLabels: true,
        });
    };



</script>
</body>
</html>