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
            user_list_tmpl: _.template($('#user_list_tmpl').html()),
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
                    });
                }
            }
        });
        mt4.event_register();
        mt4.fetch_user_list();

    });
</script>