<?php
use Fuel\Core\Controller_Rest;
use Fuel\Core\Input;
use Model\Course;

/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/18
 * Time: 2:39
 */

class Controller_Api_Instance extends Controller_Rest{
    public function get_course_list()
    {
        return $this->response(Course::get_have_instance_course_list());
    }

    public function get_course_user_list()
    {
        $course_id = Input::get('course_id');
        return $this->response(Course::find_course_user_list($course_id));
    }

    public function get_instance_list()
    {
        $course_id = Input::get('course_id');
        return $this->response(Course::get_instance_list($course_id));
    }

    public function get_user_instance_list()
    {
        $user_id = Input::get('user_id');
        return $this->response(Course::find_user_instance_list($user_id));
    }
} 