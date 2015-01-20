<style>
    .instance{
        margin-bottom:1em;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                <div class="page-header">
                    <h2>ユーザ、インスタンス管理画面 <br><small>こちらで各授業のインスタンスを制御します</small></h2>
                </div>
            </div>
            <div class="row" id="instance_list">

            </div>
        </div>
    </div>
</div>

<script type="text/template" id="instance_list_tmpl">
    <div class="col-xs-12 instance">
        <div class="col-xs-6">
            <div class="row">
                <div class="col-xs-6">
                    <%=server_id%>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn btn-primary">起動</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn btn-danger">停止</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="row">
                <div class="col-xs-12">
                    <%=course_name%>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    IPアドレス:xxx.xxx.xxx.xxx
                </div>
            </div>
        </div>
    </div>
    <hr/>
</script>
<script type="text/javascript">
    $(function(){
        "use strict";
        var mt4 = {
            user_id: '<?php echo $user_id;?>',
            instance_list: $('#instance_list'),
            instance_list_tmpl : _.template($('#instance_list_tmpl').html()),
            register_event: function(){

            },
            fetch_instance_list: function(){
                var self = this;
                $.ajax({
                    url: '/api/instance/user_instance_list.json',
                    type: 'get',
                    data: {user_id: self.user_id}
                }).done(function(data){
                    if(data.length != 0){
                        self.instance_list.empty();
                        _(data).each(function(d){
                            var row = $(self.instance_list_tmpl(d));
                            self.instance_list.append(row);
                        });
                    }
                });
            },
            start: function(){
                var self = this;
                self.register_event();
                self.fetch_instance_list();
            }
        };
        mt4.start();
    });
</script>