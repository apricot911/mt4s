<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 3:06
 */

?>

<html>
<head lang="ja">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo Asset::css(array('bootstrap.css'));
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo Asset::get_file('bootflat.css', 'plugins', 'bootflat.github.io/bootflat/css') ?>"/>
    <title>Login</title>
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: rgba(79, 193, 233, 0.3);
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading{
            color: #3BAFDA;
            margin-bottom: 10px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="/" method="post" class="form-signin">
            <h2 class="form-signin-heading text-center">MT4 System.</h2>
            <label for="student-id" class="sr-only">学籍番号</label>
            <input type="text" id="student-id" name="student_id" class="form-control" placeholder="学籍番号" required autofocus>
            <label for="inputPassword" class="sr-only">パスワード</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="パスワード" required>
            <?php
                var_dump(\Fuel\Core\Session::get());
                if(isset($error)):
            ?>
            <p class="text-danger"><?php echo $error ?></p>
            <?php
                endif;
            ?>
            <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
        </form>
    </div>
</body>
</html>