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

    public function get_find_student_group()
    {
        $prefix = Input::get("prefix");
        $result = User::find_student_group($prefix);
        return $this->response($result);
    }

    public function post_create()
    {
        $user_name = Input::json('user_name');
        $student_id = Input::json('student_id');
        $is_teacher = Input::json('is_teacher');
        list($user_id, $status) = User::add_user($user_name, $student_id, $is_teacher);
        return $this->response(array(
            'user_id'=> $user_id,
            'status' => $status
        ));
    }


    public function delete_delete(){
        $delete_users = Input::json('user_list');
        $result = User::delete_user($delete_users);
        $this->response(array(
            'status' => $result
        ));
    }

} 