<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/18
 * Time: 15:39
 */
?>

<div class="container">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <!-- Main -->
            <div class="row">
                <div class="page-header">
                    <h1>3B水曜1限 <small>森岡拓也</small></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">

                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="lead">userlist</p>
                            <div class="pull-right">
                                <button class="btn btn-default">あっど</button>
                                <button class="btn btn-default">りむーぶ</button>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control search" placeholder="学籍番号">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="col-xs-1">
                                            <input type="checkbox" id="user_b2020">
                                        </td>
                                        <td class="col-xs-5">
                                            <label class="control-label" for="user_b2020">b2020</label>
                                        </td>
                                        <td class="col-xs-6">
                                            <label class="control-label" for="user_b2020">みかん</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1">
                                            <input type="checkbox" id="user_b2020">
                                        </td>
                                        <td class="col-xs-5">
                                            <label class="control-label" for="user_b2020">b2020</label>
                                        </td>
                                        <td class="col-xs-6">
                                            <label class="control-label" for="user_b2020">みかん</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1">
                                            <input type="checkbox" id="user_b2020">
                                        </td>
                                        <td class="col-xs-5">
                                            <label class="control-label" for="user_b2020">b2020</label>
                                        </td>
                                        <td class="col-xs-6">
                                            <label class="control-label" for="user_b2020">みかん</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1">
                                            <input type="checkbox" id="user_b2020">
                                        </td>
                                        <td class="col-xs-5">
                                            <label class="control-label" for="user_b2020">b2020</label>
                                        </td>
                                        <td class="col-xs-6">
                                            <label class="control-label" for="user_b2020">みかん</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1">
                                            <input type="checkbox" id="user_b2020">
                                        </td>
                                        <td class="col-xs-5">
                                            <label class="control-label" for="user_b2020">b2020</label>
                                        </td>
                                        <td class="col-xs-6">
                                            <label class="control-label" for="user_b2020">みかん</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var typeaheadSource = [{ id: 1, name: 'John'}, { id: 2, name: 'Alex'}, { id: 3, name: 'Terry'}];

        $('input.search').typeahead({
            source: typeaheadSource
        });


    });
</script>