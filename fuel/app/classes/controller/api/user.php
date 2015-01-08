<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/08
 * Time: 23:29
 */

use Fuel\Core\Controller_Rest;
use Model\User;
use Fuel\Core\Input;

class Controller_Api_User extends Controller_Rest
{

    public function get_find()
    {
        $student_id = Input::get("student_id");
        $user_list = User::find_student_id($student_id);
        return $this->response($user_list);
    }

} 