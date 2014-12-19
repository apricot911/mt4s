<style type="text/css">
    body {
        padding-top: 50px;
    }

    .instance_box {
        margin-top: 5px;
        height: 90%;
        background: #5bc0de;
        text-align: center;
        cursor: pointer;
        border-radius: 2px;
    }

    .instance_box a {
        text-decoration: none;
    }

    .instance_box.select {
        box-shadow: 0px 0px 2px 1px #0000CC;
    }

    .instance_box .status {
        padding-top: 15px;
        padding-bottom: 20px;
        font-size: 5em;
        color: #FFF;
    }

    .instance_box .info {
        display: block;
        color: white;
        text-align: right;
        padding-right: 5px;
    }

    .instance_box .bar {
        padding-top: 0.5em;
        padding-bottom: 0.3em;
        background: #66afe9;
        color: #FFF;
        font-size: 1.2em;
        border-top: 1px solid #FFF;
    }

    #information {
        height: 200px;
        /*margin-top:10px;*/
        /*margin-bottom:10px;*/
        background: #bce8f1;
    }

    #navigation {
        padding-top: 10px;
        padding-bottom: 10px;
        /*background:#d58512;*/
    }

    #navigation .btn {
        border-radius: 1px;
    }

    .course {
        border-left: 20px solid #0000CC;;
        padding-top: 0.5em;
        padding-bottom: 0.5em;
        background-color: #f3f3f3;
        font-size: 1.2em;
        font-weight: 700;
    }

    .course p {
        margin: 0;
    }

    .chart {
        /*position: relative;*/
        display: inline-block;
        /*width: 11;*/
        /*height: 110px;*/
        margin-top: 50px;
        margin-bottom: 50px;
        text-align: center;
    }

    .chart canvas {
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="col-xs-12" id="information">

                    info
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="navigation">
                    <div class="row text-center">
                        <div class="col-xs-1">
                            <button class="btn btn-default">起動</button>
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger">停止</button>
                        </div>
                        <div class="col-xs-1 col-xs-offset-7">
                            <button class="btn btn-primary">新規</button>
                        </div>
                        <div class="col-xs-2">
                            <button class="btn btn-danger">削除</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center" id="instancelist">
                    <div class="row">
                        <div class="course">
                            <p>3年B組　にゃんだふる</p>
                        </div>
                    </div>
                    <div class="row" id="instance_list">
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="instance_box">
                                <div>
                                    <span class="status text-center glyphicon glyphicon-stop"></span>
                                    <span class="info">192.168.0.120</span>

                                    <div class="bar">B2020 森本</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
    ...
</div>
<script id="instance_tmpl" type="text/template">
    <div class="col-xs-3">
        <div class="instance_box">
            <div>
                <span class="status text-center glyphicon glyphicon-<%= status %>"></span>
                <span class="info"><%= ipaddress%></span>

                <div class="bar"><%= instancename %></div>
            </div>
        </div>
    </div>
</script>
<script type="text/javascript">
//    $('.chart').easyPieChart({
//        easing: 'easeOutBounce',
//        onStep: function(from, to, percent) {
//            $(this.el).find('.percent').text(Math.round(percent));
//        }
//    });



    $(function(){
        //fetch servers
        $.ajax({
            url: '/openstack/send_request.json',
            type: 'post',
            data: '{"component": "nova", "path": "/servers", "method": "get"}'
        }).done(function(data){
            if(data != null){
                var list = $('#instance_list');
                list.empty();
                data['servers'].forEach(function(e){
                    var name = e.name;
                    var template = _.template($('#instance_tmpl').html());
                    var instance = $(template({status: 'play', ipaddress: '10', instancename: name}));

                    list.append(instance);
                });
                $('.instance_box').click(function(){
                    if($(this).is('.select')){
                        $(this).removeClass('select');
                    }else{
                        $(this).addClass("select");
                    }
                });
            }
        });

        $('.instance_box').click(function(){
            if($(this).is('.select')){
                $(this).removeClass('select');
            }else{
                $(this).addClass("select");
            }
        });
    });
</script>
</body>
</html>