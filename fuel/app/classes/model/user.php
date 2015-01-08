<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 23:41
 */

namespace Model;

use Fuel\Core\Model;
use Fuel\Core\DB;

class User extends  Model
{
    public static function get_all_teacher()
    {
        $query = DB::select('user_id', 'name')->from('users')->where('is_teacher', '=', '1');
        return $query->execute();
    }

    public static function find_student_id($student_id){
        $query = DB::query('SELECT user_id, name, student_id FROM users WHERE student_id LIKE :student_id');
        $query->parameters(array(
            'student_id' => $student_id.'%'
        ));
        $result = $query->execute()->as_array();

        if(count($result) == 0){
            $result = array('student_id' => -1);
        }
        return $result;
    }

    public static function find_join_course_user_list($course_id)
    {
        $sql = "SELECT u.user_id, u.name, u.student_id FROM users u JOIN join_course jc ON (u.user_id = jc.user_id) WHERE course_id = :course_id ";
        $query = DB::query($sql);
        $query->parameters(array(
            'course_id' => &$course_id
        ));
        $result = $query->execute()->as_array();
//        if(count($result) == 0){
//            $result = array('status' => -1);
//        }
        return $result;
    }

    public static function find_join_course_server_list($course_id)
    {
        $sql = "SELECT u.user_id, u.name, u.student_id, jc.server_id FROM users u JOIN join_course jc ON (u.user_id = jc.user_id) WHERE course_id = :course_id";
        $query = DB::query($sql);
        $query->parameters(array(
            'course_id' => &$course_id
        ));
        $result = $query->execute()->as_array();
//        if(count($result) == 0){
//            $result = array('status' => -1);
//        }
        return $result;
    }
} 