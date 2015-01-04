<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 14:35
 */


use Fuel\Core\Input;
use Fuel\Core\Controller_Rest;
use Model\Course;

class Controller_Api_Course extends Controller_Rest{

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