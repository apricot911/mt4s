<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 5:15
 */
ini_set('display_errors', -1);

session_destroy();
session_start();

phpinfo();