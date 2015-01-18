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
            <div class="row">
                <div class="page-header">
                    <h3>ユーザ設定 <small>ユーザ情報を修正します。</small></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <form action="/admin/config" method="post" class="form-horizontal" name="config" autocomplete="off">
                        <div class="form-group">
                            <label for="" class="control-label col-xs-4">名前</label>
                            <div class="col-xs-8">
                                <input name="user_name" type="text" class="form-control" value="<?php echo $user_name; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-xs-4">学籍番号</label>
                            <div class="col-xs-8">
                                <input name="student_id" type="text" class="form-control" value="<?php echo $student_id; ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-xs-4">パスワード</label>
                            <div class="col-xs-8">
                                <input name="password" type="password" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">修正</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>