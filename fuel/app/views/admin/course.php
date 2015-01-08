<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/18
 * Time: 15:22
 */
?>

<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="page-header">
                    <h1>授業一覧 <small>登録された授業一覧です</small></h1>
                    <div class="pull-right">
                        <button id="create_course_btn" class="btn btn-primary">新規</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table id="course_list" class="table">
                        <thead>
                            <tr>
                                <th class="col-xs-4">名前</th>
                                <th class="col-xs-2">教員</th>
                                <th class="col-xs-2">教室</th>
                                <th class="col-xs-2">ステータス</th>
                                <th class="col-xs-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="course/detail.php?id=1">3B水曜1限</a></td>
                                <td>森岡拓也</td>
                                <td>5A</td>
                                <td>有効</td>
                                <td><button class="btn btn-danger">編集</button></td>
                            </tr>
                            <tr>
                                <td>3B水曜1限</td>
                                <td>森岡拓也</td>
                                <td>5A</td>
                                <td>有効</td>
                                <td><button class="btn btn-danger">編集</button></td>
                            </tr>
                            <tr>
                                <td>3B水曜1限</td>
                                <td>森岡拓也</td>
                                <td>5A</td>
                                <td>有効</td>
                                <td><button class="btn btn-danger">編集</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    //echo is_array($room_list);

?>
<!-- Modal -->
<div class="modal fade" id="create_course_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">新規授業作成</h4>
            </div>
            <form>
                <div class="modal-body">
                    <p class="help-text">新規の授業を作成します</p>
                    <div class="form-group">
                        <label for="course-name" class="control-label">授業名</label>
                        <input type="text" class="form-control" id="course-name" name="course_name">
                    </div>
                    <div class="form-group">
                        <label for="teacher-id" class="control-label">教員</label>
                        <select id="teacher-id" class="form-control" name="teacher_id">
                            <?php
                                foreach($teacher_list as $teacher):
                            ?>
                                <option value="<?php echo $teacher['user_id']; ?>"><?php echo $teacher['name'] ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room-name">教室</label>
                        <select class="form-control" name="room_id" id="room-name">
                            <?php
                                foreach($room_list as $room):
                            ?>
                            <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">作成</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/temaplte" id="course_row_tmpl">
    <tr>
        <td><a href="course/<%=course_id%>"><%=course_name%></a></td>
        <td><%=teacher_name%></td>
        <td><%=room_name%></td>
        <td><%=enabled%></td>
        <td><a href="course/<%=course_id%>"><button class="btn btn-danger">編集</button></a></td>
    </tr>
</script>
<script type="text/javascript">
    $(function(){
        "use strict";
        var view = {
            course_list: $('#course_list'),
            course_row_tmpl: _.template($('#course_row_tmpl').html()),
            create_course_modal: $('#create_course_modal'),
            fetch   : function(){
                var self = this;
                var tbody = $('tbody', self.course_list);
                tbody.empty();
                $.ajax({
                    url: '/api/course/fetch.json'
                }).done(function(data){
                    if(data.status != -1){
                        _(data).each(function(row){
                            tbody.append(self.course_row_tmpl(row));
                        });
                    }
                });
            },
            init    : function(){
                var self = this;
                $('#create_course_btn').click(function(){
                    self.create_course_modal.modal('show');
                });
                self.create_course_modal.submit(function(e){
                    e.preventDefault();
                    var course_name_form    = $('[name="course_name"]', self.create_course_modal);
                    var course_teacher_form = $('[name="teacher_id"]', self.create_course_modal);
                    var course_room_form    = $('[name="room_id"]', self.create_course_modal);
                    var data = {};
                    data.name       = course_name_form.val();
                    data.teacher_id = course_teacher_form.val();
                    data.room_id    = course_room_form.val();
                    $.ajax({
                        url: '/api/course/create.json',
                        type:'post',
                        dataType: 'json',
                        data: JSON.stringify(data)
                    }).done(function(data){
                        if(data.status == 1){
                            self.create_course_modal.modal('hide');
                            course_name_form.val("");
                            self.fetch();
                        }else{
                            alert("error");
                        }
                    });

                });
            },
            run     : function(){
                var self = this;
                self.fetch();
                self.init();
            }
        };

        view.run();
    });
</script>