<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/07
 * Time: 12:18
 */

?>
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                <div class="page-header">
                    <h1>生徒一覧 <small>登録された学生一覧です</small></h1>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            <div class="row">
                                <div class="col-xs-8">
                                    <form class="form" action="">
                                        <div class="form-group">
                                            <p class="help-block">ここから生徒の登録が出来ます</p>
                                            <input type="file" name="csv">
                                        </div>
                                        <div class="form-group">
                                            <button type="text" class="btn btn-default">CSV Upload</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <div class="form-group">
                                        <button id="create_user_btn" class="btn btn-primary">新規</button>
                                        <button id="delete_user_btn" class="btn btn-danger">削除</button>
                                    </div>
                                    <div class="form-group">
                                        <select id="student_prefix_select" class="form-control">
                                            <?php
                                                foreach($student_prefix as $value){
                                                    $prefix = $value['prefix'];
                                                    echo "<option value='${prefix}'>${prefix}00</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table id="user_list_table" class="table table-hover">
                    <thead>
                        <tr>
                            <td></td>
                            <td>名前</td>
                            <td>学籍番号</td>
                            <td>教師</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="create_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新規学生登録</h4>
            </div>
            <form class="form">
                <div class="modal-body">
                    <p class="help-text">新規の授業を作成します</p>
                    <div class="form-group">
                        <label for="user-name" class="control-label">名前</label>
                        <input type="text" class="form-control" id="user-name" name="user_name">
                    </div>
                    <div class="form-group">
                        <label for="student-id" class="control-label">学籍番号</label>
                        <input type="text" id="student-id" class="form-control" name="student_id">
                        <p class="help-block">これがログイン用のIDになります</p>
                    </div>
                    <div class="form-group">
                        <label for="is-teacher">教師として設定する</label>
                        <input type="checkbox" id="is-teacher" name="is_teacher" value="1">
                        <p class="help-block">管理ユーザの権限</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">作成</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/template" id="user_list_row_tmpl">
    <tr data-student_id="<%=student_id%>">
        <td><input type="checkbox" name="student" value="<%=user_id%>"></td>
        <td><%=name%></td>
        <td><%=student_id%></td>
        <td><%
            if(is_teacher == 1){
                print("Yes");
            }else{
                print("No");
            }
        %></td>
    </tr>
</script>

<script type="text/javascript">
    $(function(){
        "use strict";
        var mt4 = {
            student_prefix_select: $('#student_prefix_select'),
            user_list_table: $('#user_list_table'),
            user_list_row_tmpl: _.template($('#user_list_row_tmpl').html()),
            create_user_modal: $('#create_user_modal'),
            eventRegister: function(){
                var self = this;
                self.student_prefix_select.change(function(){
                    var prefix = $(this).val();
                    self.fetchUserList(prefix);
                });
                $('#create_user_btn').click(function(){
                    self.createUser();
                });
                $('#delete_user_btn').click(function(){
                    self.deleteUser();
                });
                $('#create_user_modal form').submit(function(e){
                    var form = $(this);
                    e.preventDefault();

                    var user_name = $('#user-name', form).val() || null;
                    var student_id = $('#student-id', form).val() || null;
                    var is_teacher = $('#is-teacher', form).val() || 0;

                    var data = {
                        user_name: user_name,
                        student_id: student_id,
                        is_teacher: is_teacher
                    };
                    $.ajax({
                        url: '/api/user/create.json',
                        type: 'POST',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify(data)
                    }).done(function(){
                        $('#user-name', form).val("");
                        $('#student-id', form).val("");
                        $('#is-teacher', form).prop('checked', false);

                        self.create_user_modal.modal('hide');
                        self.fetchUserList(student_id.substr(0,3));
                    });

                });
            },
            fetchUserList: function($prefix){
                var self = this;
                $.ajax({
                    url: '/api/user/find_student_group.json',
                    dataType: 'json',
                    data: {"prefix": $prefix}
                }).done(function(data){
                    if(data != null){
                        var tbody = $('tbody', self.user_list_table);
                        tbody.empty();
                        _(data).each(function(d){
                            var row = $(self.user_list_row_tmpl(d));
                            row.click(function(){
                                var checkbox = $('input[type="checkbox"]', this);
                                checkbox.prop('checked', !checkbox.prop('checked'));
                            });
                            tbody.append(row);
                        });
                    }
                });
            },
            createUser: function(){
                var self = this;
                self.create_user_modal.modal('show');
            },
            deleteUser: function(){
                var delete_user_list_dom = $('#user_list_table input[type="checkbox"]:checked');
                var delete_user_list = _(delete_user_list_dom).map(function(dom){
                    return $(dom).val();
                });
                if(delete_user_list.length == 0){
                    return;
                }
                var data = {
                    user_list: delete_user_list
                };
                $.ajax({
                    url: '/api/user/delete.json',
                    type: 'delete',
                    dataType: 'json',
                    ContentType: 'application/json',
                    data: JSON.stringify(data)
                }).done(function(data){
                    if(data.status >= 1){
                        _(delete_user_list_dom).each(function(dom){
                            $(dom).parents('tr').remove();
                        });
                    }
                });
            },
            start: function(){
                var self = this;
                self.eventRegister();
                self.student_prefix_select.change();
            }
        };
        mt4.start();
    });
</script>