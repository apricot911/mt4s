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
                        <div class="col-xs-1 col-xs-offset-9">
                            <button class="btn btn-default">起動</button>
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-danger">停止</button>
                        </div>
                        <div class="col-xs-1">
                            <button class="btn btn-info">詳細</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center" id="course_list">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="course_list_tmpl">
    <div class="row" data-course_id="<%=course_id%>">
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
    <div class="col-xs-2" data-server_id="<%if(server_id != 'NULL'){print(server_id);}%>">
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
<script type="text/javascript">
    $(function(){
        var mt4 = {
            course_list_tmpl: _.template($('#course_list_tmpl').html()),
            instance_tmpl: _.template($('#instance_tmpl').html()),
            course_list: $('#course_list'),
            event_register: function(){
                $('.instance_box').click(function(){

                });
            },
            fetch_all_insntace_list: function(){
                var self = this;
                $.ajax({
                    url: '/api/instance/course_list.json',
                    type: 'get'
                }).done(function(data){
                    var instance_list = data;
                    _(data).each(function(course_data){
                        var course_view = $(self.course_list_tmpl(course_data));
                        self.course_list.append(course_view);
                        $.ajax({
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
                                instance_list_view.append(instance_view);
                            });
                        });
                    });
                });
            },
            all_instance_status_check: function(){
                var self = this;
                var list = _($('[data-course_id]')).map(function(course_view){
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

        function create_instance(name, user_id, course_id){
            var imageRef    = "02803367-771e-4c39-9a13-bbffb530f65f";
            var flavorRef   = "2b128dfd-349f-4027-900f-8a2cea977828";
            var data = {
                server: {
                    name: name,
                    imageRef: imageRef,
                    flavorRef: flavorRef,
                    max_count: 1,
                    min_count: 1,
                    networks: [
                        {uuid: '780a30bd-9638-46ab-b349-055301973fc9'}
                    ],
                    security_groups:[
                        {name: 'default'}
                    ]
                }
            };
            var sendData =  {
                component: "nova",
                path: "/servers",
                method: "post",
                data: data
            };

            $.ajax({
                url: '/openstack/send_request.json',
                type: 'post',
                dataType: 'json',
                data: JSON.stringify(sendData)

            }).done(function(data){
                console.log(data);
                //save
                if(data.server != null){//成功
                    var data = {
                        user_id: user_id,
                        course_id: course_id,
                        server_id: data.server.id
                    };
                    $.ajax({
                        url: '/api/course/add_server.json',
                        type: 'post',
                        data: JSON.stringify(data)
                    }).done(function(data){
                        if(data == 1){
                            //ok
                        }
                    });
                }else{
                    //error
                }
            });
        }
        window.create_instance = create_instance;
        mt4.start();
        window.mt4 = mt4;
    });
</script>
</body>
</html>