<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/18
 * Time: 15:22
 */

require 'header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="page-header">
                    <h1>授業一覧 <small>じゅぎょー！</small></h1>
                    <div class="pull-right">
                        <button class="btn btn-primary">新規</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table">
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
<div data-spy="affix" data-offset-top="60" data-offset-bottom="200">
    ...
</div>