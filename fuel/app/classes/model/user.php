<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 23:41
 */

namespace Model;

use Auth\Auth;
use Fuel\Core\Model;
use Fuel\Core\DB;

class User extends  Model
{
    public static function get_user($user_id)
    {
        $query = DB::query('SELECT * FROM users WHERE user_id = :user_id');
        $query->parameters(array('user_id' => $user_id));
        return $query->execute()->as_array()[0];
    }

    public static function get_all_teacher()
    {
        $query = DB::select('user_id', 'name')->from('users')->where('is_teacher', '=', '1');
        return $query->execute();
    }

    public static function add_user($name, $student_id, $is_teacher, $password = 'Oic0667722233')
    {
        $query = DB::insert('users')
            ->columns(array('name', 'password','student_id', 'is_teacher'))
            ->values(array(
            'name'          => &$name,
            'password'      => Auth::instance()->hash_password($password),
            'student_id'    => &$student_id,
            'is_teacher'    => &$is_teacher
        ))->execute();
        return $query;
    }

    public static function update_user($data_array, $user_id)
    {
        $query = DB::update('users');
        if(isset($data_array['password']))
        {
            $data_array['password'] = Auth::instance()->hash_password($data_array['password']);
        }
        foreach($data_array as $key => $val)
        {
            $query->value($key, $val);
        }
        $query->where('user_id', '=', $user_id);
        return $query->execute();
    }


    /**
     * ユーザの削除
     * @param $user_list = array()
     * @return 削除した件数
     */
    public static function delete_user($user_list)
    {
        $query = DB::delete('users')->where('user_id', 'in', $user_list);
        return $query->execute();
    }

    /**
     * 授業に参加したユーザを削除する
     * @param $course_id
     * @param $student_ids
     * @return object
     */
    public static function delete_join_course_user($course_id, $student_ids)
    {
        $sql = "DELETE FROM join_course WHERE course_id = :course_id AND user_id IN (SELECT user_id FROM users WHERE student_id IN :student_ids)";
        $query = DB::query($sql);
        $query->parameters(array(
            'course_id' => $course_id,
            'student_ids'   => $student_ids
        ));
        return $query->execute();
    }


    /**
     * 学籍番号でグループ化したリストを取得する
     * @param $prefix [b2],[b1]
     */
    public static function find_student_group($prefix)
    {
        $sql = "SELECT * FROM users WHERE substr(student_id, 1, 3) = :student_prefix";
        $query = DB::query($sql);
        $query->parameters(array(
            'student_prefix' => $prefix
        ));
        return $query->execute()->as_array();
    }

    /**
     *  学籍番号のprefixグループリストを取得する
     */
    public static function get_student_prefix_group()
    {
        $sql = "SELECT substr(student_id, 1, 3) AS prefix FROM users GROUP BY substr(student_id, 1, 3)";
        $query = DB::query($sql);
        return $query->execute()->as_array();
    }

    public static function find_student_id($student_id = "")
    {
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
        $sql = "SELECT u.user_id, u.name, u.student_id FROM users u JOIN join_course jc ON (u.user_id = jc.user_id) WHERE course_id = :course_id ORDER BY u.student_id";
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
        $sql = "SELECT u.user_id, u.name, u.student_id, jc.server_id FROM users u JOIN join_course jc ON (u.user_id = jc.user_id) WHERE course_id = :course_id ORDER BY u.student_id";
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