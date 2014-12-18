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
        echo Asset::css(array('bootstrap.css'));
        echo Asset::js(array('openstack_helper.js'));
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo Asset::get_file('bootflat.css', 'plugins', 'bootflat.github.io/bootflat/css') ?>"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo Asset::get_file('bootstrap-typeahead.js', 'plugins', 'bootstrap-ajax-typeahead/js');?>"></script>
        <script src="<?php echo Asset::get_file('underscore-min.js', 'plugins', 'underscore');?>"></script>
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
            .navbar-custom{
                position: fixed;
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 0px;
                z-index: 2000;
            }
            .navbar-custom .nav li a{
                display:block;
                color:#50c1e9
            }

            .navbar-custom .nav li a:focus,.navbar-custom .nav li a:hover{
                color:#50c1e9
            }

            .navbar-custom .nav li a.current,.navbar-custom .nav li a:active{
                border-bottom:3px solid #50c1e9
            }

            .navbar-custom .navbar-toggle{
                position:relative;
                background-color:#50c1e9;
                border-color:#50c1e9
            }

            .navbar-custom .navbar-toggle:focus,.navbar-custom .navbar-toggle:hover{
                background-color:#50c1e9
            }

            .navbar-custom .navbar-toggle .icon-bar{
                background-color:rgba(255,255,255,.9)
            }
            .navbar-custom .navbar-brand{
                color:#50c1e9;
            }

            .navbar-custom .navbar-brand:active,.navbar-custom .navbar-brand:hover{
                opacity:1;
                color:#50c1e9;
                filter:alpha(opacity=100)
            }

            .navbar-default .navbar-collapse{
                border-color:#e7e7e7
            }

            @media (max-width:992px){
                .navbar-custom .navbar-brand{
                    width:63px;
                    overflow:hidden
                }

            }

            @media (max-width:767px){
                .navbar-custom{
                    position:relative;
                    top:0
                }

                .navbar-custom .navbar-nav>li>a:focus,.navbar-custom .navbar-nav>li>a:hover{
                    color:#fff;
                    background-color:#50c1e9
                }

            }

        </style>
    </head>
    <body>