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
        margin-bottom:5px;
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
        font-size: 3.5em;
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
        /*height: 200px;*/
        /*margin-top:10px;*/
        /*margin-bottom:10px;*/
        /*background: #bce8f1;*/
    }
    #information .progress{
        margin-top:140px;
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
    .kami-chart {
        width: 100%;
        height: 180px; }
    .kami-chart .tip {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 60%;
        text-align: center;
        display: block;
        margin-left: -30%;
        height: 15%;
        margin-top: -7%;
        font-size: 1.5em;
        color: #666; }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="col-xs-12" id="information">
                    <div class="row">
                        <div class="col-xs-4">
                            <div id="instance_num" class="kami-chart col-xs-12"></div>
                            <div class="col-xs-12 text-center">CPUの使用数</div>
                        </div>
                        <div class="col-xs-4">
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="16.99" aria-valuemin="0" aria-valuemax="100" style="width: 16.99%;">
                                    Used 17%
                                </div>
                                <div class="progress-bar" style="width: 83.01%">
                                    <span>free 83%</span>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                メモリ使用率
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <h5>Nova Compute Hosts</h5>
                            <ul>
                                <li> mt4</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="navigation">
                    <div class="row text-center">
                        <div class="col-xs-1 col-xs-offset-10">
                            <button class="btn btn-default">起動</button>
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger">停止</button>
                        </div>
<!--                        <div class="col-xs-1">-->
<!--                            <button class="btn btn-info">詳細</button>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center" id="course_list">
                    <p>データはありまてん</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="course_list_tmpl">
    <div class="row course_row" data-course_id="<%=course_id%>">
        <div class="col-xs-12 text-center">
            <div class="row">
                <div class="course">
                    <p><%=course_name%> (<%=teacher_name%>)</p>
                </div>
            </div>
            <div class="instance_list">

            </div>
        </div>
    </div>
</script>
<script type="text/template" id="instance_tmpl">
    <div class="col-xs-2" data-user_id="<%=user_id%>" data-course_id="<%=course_id%>" data-server_id="<%if(server_id != 'NULL'){print(server_id);}%>">
        <div class="instance_box">
            <div>
                <span class="status text-center glyphicon <%if(server_id == 'NULL'){print('glyphicon-minus');}else{print('glyphicon-refresh');}%>">
                </span>
                <span class="info"><%if(server_id == 'NULL'){print('未生成');}else{print('xxx.xxx.xxx.xxx');}%></span>

                <div class="bar"><%= name %> (<%=student_id%>)</div>
            </div>
        </div>
    </div>
</script>
<script src="<?php echo Asset::get_file('linq.min.js', 'plugins', 'kamichart/js');?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart','gauge'] }]}"></script>
<script src="<?php echo Asset::get_file('script.js', 'plugins', 'kamichart/js');?>"></script>
<script type="text/javascript">
    $(function(){
        var mt4 = {
            course_list_tmpl: _.template($('#course_list_tmpl').html()),
            instance_tmpl: _.template($('#instance_tmpl').html()),
            course_list: $('#course_list'),
            event_register: function(){
                var self = this;
//                setInterval(function(){
//                    self.all_instance_status_check();
//                }, 5000);
                $('#instance_num').kamiChart(["Used/1/#f55","Free/8/transparent"]);
            },
            fetch_all_insntace_list: function(){
                var self = this;
                $.ajax({
                    url: '/api/instance/course_list.json',
                    type: 'get'
                }).done(function(data){
                    var instance_list = data;
                    if(instance_list.length == 0){
                        return;
                    }
                    var deferrs = [];
                    _(data).each(function(course_data){
                        var course_view = $(self.course_list_tmpl(course_data));
                        self.course_list.empty();
                        self.course_list.append(course_view);
                        var defer = $.ajax({
                            url: '/api/instance/course_user_list.json',
                            type: 'get',
                            data: {
                                course_id: course_data.course_id
                            }
                        }).done(function(data){
                            var instance_list_view = $('.instance_list', course_view);
                            _(data).each(function(instance_data){
                                var instance_view = $(self.instance_tmpl(instance_data));
                                instance_view.click(function(){
                                    if($('.instance_box', this).is('.select')){
                                        $('.instance_box', this).removeClass('select');
                                    }else{
                                        $('.instance_box', this).addClass("select");
                                    }
                                });
                                instance_view.dblclick(function(){
                                    location.href = '/admin/instance/'+instance_data.course_id+'/'+instance_data.user_id;
                                });
                                instance_list_view.append(instance_view);
                            });
                        });
                        deferrs.push(defer);
                        $.when.apply(window, deferrs).always(function(){
                            self.all_instance_status_check();
                        });
                    });
                });
            },
            all_instance_status_check: function(){
                var self = this;
                var list = _($('.course_row[data-course_id]')).map(function(course_view){
                    return _($('[data-server_id*="-"]', course_view)).map(function(instance_view){
                        return $(instance_view).data('server_id');
                    });
                });
                list = list.filter(function(arr){
                    return arr.length > 0;
                });
                list.forEach(function(instance_list){
                    instance_list.forEach(function(server_id){
                        self.instance_list_check1(server_id);
                    });
                });
            },
            instance_list_check1: function(server_id){
                return openstack_helper.check_instance(server_id).done(function(data){
                    var instance_view = $('[data-server_id="'+server_id+'"]');
                    if(data.server != null){
                        var name = data.server.name;
                        var addresses = data.server.addresses;
                        var vm_status = data.server['OS-EXT-STS:vm_state'];
                        var power_state = data.server['OS-EXT-STS:power_state'];
                        //はめ込み
                        var status = $('.status', instance_view).removeClass('glyphicon-minus glyphicon-refresh glyphicon-play glyphicon-stop');
                        if(vm_status == 'active'){
                            status.addClass('glyphicon-play');
                        }else{
                            status.text(vm_status);
                        }
                    }else if(data.itemNotFound != null){
                        instance_view.addClass('error');
                    }
                });
            },
            instance_list_check: function(list){
                var index = -1;
                var tmp_list = list;
                return function(){
                    index++;
                    if(tmp_list.length == index){
                        index = 0;
                    }
                    var server_id = tmp_list[index];
                    var send_data = {
                            component:  'nova',
                            path:       '/servers/'+server_id,
                            method:     'get',
                            data:       ""
                        };
                    return $.ajax({
                        url: '/openstack/send_request.json',
                        type: 'post',
                        dataType:'json',
                        data: JSON.stringify(send_data)
                    }).done(function(data){
                        console.log(data);
                        var instance_view = $('[data-server_id="'+server_id+'"]');
                        if(data.server != null){
                            var name = data.server.name;
                            var addresses = data.server.addresses;
                            var vm_status = data.server['OS-EXT-STS:vm_state'];
                            var power_state = data.server['OS-EXT-STS:power_state'];
                            //はめ込み
                            var status = $('.status', instance_view).removeClass('glyphicon-minus glyphicon-refresh glyphicon-play glyphicon-stop');
                            if(vm_status == 'active'){
                                status.addClass('glyphicon-play');
                            }else{
                                status.text(vm_status);
                            }
                        }else if(data.itemNotFound != null){
                            instance_view.addClass('error');
                        }
                    });
                }
            },
            start: function(){
                var self = this;
                self.event_register();
                self.fetch_all_insntace_list();
            }
        };

//        window.create_instance = create_instance;
        mt4.start();
        window.mt4 = mt4;
    });
</script>
</body>
</html>