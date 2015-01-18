<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 14:35
 */


use Auth\Auth;
use Fuel\Core\Input;
use Fuel\Core\Controller_Rest;
use Fuel\Core\Response;
use Model\Course;
use Model\User;

class Controller_Api_Course extends Controller_Rest
{

    public function before(){
        parent::before();
        if(!Auth::check()){
            return Response::redirect('/');
        }
    }

    public function get_fetch()
    {
        $course_list = Course::get_course_list()->as_array();
        return $this->response($course_list);
    }

    /**
     * コースの作成
     * @return array|object
     */
    public function post_create()
    {
        $course_name    = Input::json('name');
        $teacher_id     = Input::json('teacher_id');
        $room_id        = Input::json('room_id');
        if(is_null($course_name) || is_null($teacher_id) || is_null($room_id))
        {
            return self::bad_response();
        }
        list($course_id, $result) = Course::add_course($course_name, $teacher_id, $room_id);
        return array(
            'status'    => $result,
            'course_id' => $course_id
        );
    }

    /**
     * コースの削除
     * @return object
     */
    public function delete_delete()
    {
        $course_id = Input::json('course_id');
        if(is_null($course_id))
        {
            return self::bad_response();
        }
        $result = Course::delete_course($course_id);
        return self::ok($result);
    }

    /**
     * コースの更新
     * @return object|string
     */
    public function put_update()
    {
        $course_id      = Input::json('course_id');
        $course_name    = Input::json('course_name');
        $teacher_id     = Input::json('teacher_id');
        $room_id        = Input::json('room_id');
        if(is_null($course_id) || is_null($course_name) || is_null($teacher_id) || is_null($room_id))
        {
            return self::bad_response();
        }
        $result = Course::update_course($course_id, $course_name, $teacher_id, $room_id);
        return self::ok($result);
    }


    public function get_user_list()
    {
        $course_id = Input::get("course_id");
        $user_list = User::find_join_course_user_list($course_id);
        return $this->response($user_list);
    }

    public function get_server_list()
    {
        $course_id = Input::get("course_id");
        $server_list = User::find_join_course_server_list($course_id);
        return $this->response($server_list);
    }

    //add user
    public function post_course()
    {
        $course_id  = Input::json('course_id');
        $user_id    = Input::json('user_id');
        return $this->response(Course::add_user_to_course($course_id, $user_id));
    }

    //update course
    public function put_course()
    {

    }

    //delete user in course
    public function delete_course_user()
    {
        $course_id  = Input::json('course_id', null);
        $student_ids   = Input::json('student_ids');
        if($course_id == null){
            self::bad_response();
        }
        $this->response(User::delete_join_course_user($course_id, $student_ids));

    }

    public function post_add_server()
    {
        $course_id  = Input::json('course_id');
        $user_id    = Input::json('user_id');
        $server_id  = Input::json('server_id');
        if(empty($course_id) || empty($user_id))
        {
            self::bad_response();
        }

        return $this->response(Course::add_server($user_id, $course_id, $server_id));
    }

    private function ok($status)
    {
        $this->response(array('status'  => &$status));
    }

    private function bad_response()
    {
        return $this->response(array(
            'status'    => -1
        ));
    }
} 