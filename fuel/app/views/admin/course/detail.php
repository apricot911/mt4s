<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/18
 * Time: 15:39
 */
?>
<style type="text/css">
    .typeahead-list{
        list-style-type: none;
    }
    .typeahead-list li.active{
        background-color: #ebebeb;
    }
    .typeahead-result .name {
        margin: 0 10px;
    }
    .typeahead-result .student_id{

    }


</style>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="page-header">
                    <h1><?php echo ($course['course_name']); ?> <small><?php echo $course['teacher_name']; ?></small></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-6"><p class="lead">インスタンスリスト</p></div>
                        <div class="col-xs-3">
                            <div class="btn btn-primary" id="create_instance_list">一括生成</div>
                        </div>
                        <div class="col-xs-3">
                            <div class="btn btn-danger" id="delete_instance">削除</div>
                        </div>
                    </div>
                    <div class="row">
                        <table id="instance_list" class="table">
                            <thead>
                                <tr>
                                    <td><input type="checkbox" class="all_check"></td>
                                    <td>学籍番号</td>
                                    <td>名前</td>
                                    <td>ステータス</td>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="text-center" colspan="4">NO DATA</td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="lead pull-left">参加生徒一覧</p>
                            <div class="pull-right">
                                <button class="btn btn-danger" id="delete_student">削除</button>
                            </div>
                            <div class="form-group">
                                <div class="typeahead-container">
                                    <div class="typeahead-field">
                                        <span class="typeahead-query">
                                            <input class="form-control" id="french_v1-query" name="french_v1[query]" type="search" placeholder="学籍番号" autocomplete="off">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="user_list" class="table">
                                <tbody>
<!--                                    <tr>-->
<!--                                        <td class="col-xs-1">-->
<!--                                            <input type="checkbox" id="user_b2020">-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-5">-->
<!--                                            <label class="control-label" for="user_b2020">b2020</label>-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-6">-->
<!--                                            <label class="control-label" for="user_b2020">みかん</label>-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td class="col-xs-1">-->
<!--                                            <input type="checkbox" id="user_b2020">-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-5">-->
<!--                                            <label class="control-label" for="user_b2020">b2020</label>-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-6">-->
<!--                                            <label class="control-label" for="user_b2020">みかん</label>-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td class="col-xs-1">-->
<!--                                            <input type="checkbox" id="user_b2020">-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-5">-->
<!--                                            <label class="control-label" for="user_b2020">b2020</label>-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-6">-->
<!--                                            <label class="control-label" for="user_b2020">みかん</label>-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td class="col-xs-1">-->
<!--                                            <input type="checkbox" id="user_b2020">-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-5">-->
<!--                                            <label class="control-label" for="user_b2020">b2020</label>-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-6">-->
<!--                                            <label class="control-label" for="user_b2020">みかん</label>-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                    <tr>-->
<!--                                        <td class="col-xs-1">-->
<!--                                            <input type="checkbox" id="user_b2020">-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-5">-->
<!--                                            <label class="control-label" for="user_b2020">b2020</label>-->
<!--                                        </td>-->
<!--                                        <td class="col-xs-6">-->
<!--                                            <label class="control-label" for="user_b2020">みかん</label>-->
<!--                                        </td>-->
<!--                                    </tr>-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="instance_list_tmpl">
    <tr data-user_id="<%=user_id%>" data-server_id="<%=server_id%>">
        <td><input type="checkbox" value="<%=user_id%>" data-student_id="<%=student_id%>"></td>
        <td><%=student_id%></td>
        <td><%=name%></td>
        <td><%if(server_id == 'NULL'){print('未生成');}else{print(server_id);}%></td>
    </tr>
</script>
<script type="text/template" id="user_list_tmpl">
    <tr data-student_id="<%=student_id%>">
        <td class="col-xs-1">
            <input type="checkbox" id="user_<%=student_id%>" value="<%=student_id%>">
        </td>
        <td class="col-xs-5">
            <label class="control-label" for="user_<%=student_id%>"><%=student_id%></label>
        </td>
        <td class="col-xs-6">
            <label class="control-label" for="user_<%=student_id%>"><%=name%></label>
        </td>
    </tr>
</script>
<script type="text/javascript">

    $(function(){
        "use strict";
        var mt4 = {
            course_id: <?php echo $course['course_id'] ?>,
            user_list_table: $('#user_list'),
            delete_student_btn: $('#delete_student'),
            instance_list_table: $('#instance_list'),
            user_list_tmpl: _.template($('#user_list_tmpl').html()),
            instance_list_tmpl: _.template($('#instance_list_tmpl').html()),
            event_register: function(){
                var self = this;
                self.delete_student_btn.click(function(){
                    var id_list = _($('#user_list input[type="checkbox"]:checked')).map(function(d){
                        return $(d).val();
                    });
                    if(id_list.length > 0){
                        self.delete_user(self.course_id, id_list);
                    }
                });
                $('.all_check').change(function(){
                    var checkbox = $(this);
                    var is_check = checkbox.prop('checked');
                    var table = checkbox.parents('table');
                    $('tbody input[type="checkbox"]', table).prop('checked',is_check);
                });

                $('#create_instance_list').click(function(){
                    self.create_instance();
                });
            },
            fetch_user_list: function(){
                var self = this;
                var tbody = $('tbody', self.user_list_table);
                tbody.empty();
                $.ajax({
                    type: 'get',
                    url: '/api/course/user_list.json',
                    data: {course_id : self.course_id}
                }).done(function(data){
                    _(data).each(function(d){
                        tbody.append($(self.user_list_tmpl(d)));
                    });
                });
            },
            fetch_insntace_list: function(){
                var self = this;
                $('.all_check').prop('checked', false);
                var tbody = $('tbody', self.instance_list_table);
                $.ajax({
                    type: 'get',
                    url: '/api/instance/instance_list.json',
                    data: {course_id: self.course_id}
                }).done(function(data){
                    if(data.length != 0){
                        tbody.empty();
                        _(data).each(function(d){
                            tbody.append($(self.instance_list_tmpl(d)));
                        });
                    }
                });
            },
            create_instance: function(){
                var self = this;
                var deferrs = [];
                _($('tbody input[type="checkbox"]:checked', self.instance_list_table)).each(function(d){
                    var user_id = $(d).val();
                    var student_id = $(d).data('student_id');
                    if($(d).parents('tr').data('server_id') == "NULL"){
                        var name = student_id + '_' + user_id + '_' + new Date().getTime();
                        var defer = openstack_helper.create_instance(name, user_id, self.course_id);
                        deferrs.push(defer);
                    }
                });
                $.when.apply(window,deferrs).always(function(){
                    setTimeout(function(){self.fetch_insntace_list();}, 500);
                });
            },
            delete_user: function(course_id, student_ids){
                var data = {
                    course_id: course_id,
                    student_ids: student_ids
                };
                $.ajax({
                    url: '/api/course/course_user.json',
                    type: 'delete',
                    data: JSON.stringify(data)
                }).done(function(data){
                    if(data > 0){
                        _(student_ids).each(function(id){
                            var tr = $('#user_list tr[data-student_id="'+id+'"]');
                            tr.hide('slow',function(){
                               tr.remove();
                            });
                        });
                    }
                });
            },
            start: function(){
                var self = this;
                self.event_register();
                self.fetch_user_list();
                self.fetch_insntace_list();
            }
        };

        $.typeahead({
//            input: 'input.search',
            input: '#french_v1-query',
            minLength: 1,
            maxItem: 5,
            order: 'asc',
            dynamic: true,
            display: 'student_id',
            template: '<span class="row">' +
                '<span class="student_id">{{student_id}}</span>' +
                '<span class="name">({{name}})</span>' +
                '</span>' +
                '</span>',
            source: {
                users: {
                    url: {
                        type: 'GET',
                        url : '/api/user/find.json',
                        data: {student_id: '{{query}}', course_id: mt4.course_id}
                    }
                }
            },
            callback: {
                onClick: function(node, a, obj, e){
                    obj.course_id = mt4.course_id;
                    $.ajax({
                        type: 'POST',
                        url: '/api/course/course.json',
                        dataType: 'json',
                        data: JSON.stringify(obj)
                    }).done(function(){
                        $(node).val("");
                        mt4.fetch_user_list();
                        mt4.fetch_insntace_list();
                    });
                }
            }
        });
        mt4.start();
    });
</script>