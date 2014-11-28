<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/18
 * Time: 15:23
 */

?>
    <!DOCTYPE html>
    <html>
    <head lang="ja">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        echo Asset::css(array('bootstrap.css', 'bootstrap-theme.css'));
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo Asset::get_file('bootstrap-typeahead.js', 'plugins', 'bootstrap-ajax-typeahead/js');?>"></script>
        <title>index</title>
        <style type="text/css">
            body{
                padding-top:50px;
            }
            #information{
                height:200px;
                /*margin-top:10px;*/
                /*margin-bottom:10px;*/
                background:#bce8f1;
            }
            #navigation{
                padding-top:10px;
                padding-bottom:10px;
                background:#d58512;
            }
            #instancelist{
                /*margin-top:10px;*/
            }
        </style>
    </head>
    <body>