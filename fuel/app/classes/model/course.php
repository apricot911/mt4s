<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 16:58
 */

namespace Model;


use Fuel\Core\DB;
use Fuel\Core\Model;


class Course extends Model
{
    public static function get_course_list()
    {
        $query = DB::query(
            "SELECT c.course_id AS course_id, c.name AS course_name, u.name AS teacher_name, r.name AS room_name, ".
            "c.enabled AS enabled FROM courses c JOIN users u ON ".
            "(c.teacher_id = u.user_id AND u.is_teacher = 1 AND c.enabled = 1) JOIN rooms r ON ".
            "(c.room_id = r.id) ORDER BY c.course_id DESC"
        );
        $result = $query->execute();
        return $result;
    }

    public static function get_instance_list($course_id)
    {
        $sql = "SELECT u.user_id, u.student_id, u.name, jc.course_id, IFNULL(jc.server_id, 'NULL') AS server_id FROM " .
            "users u JOIN join_course jc ON (u.user_id = jc.user_id AND jc.course_id = :course_id) ORDER BY u.student_id";
        $query = DB::query($sql);
        $query->parameters(array(
            'course_id' => &$course_id
        ));
        return $query->execute();
    }

    public static function get_have_instance_course_list()
    {
        $query = DB::query(
            "SELECT c.course_id AS course_id, c.name AS course_name, u.name AS teacher_name, r.name AS room_name, ".
            "c.enabled AS enabled FROM courses c JOIN users u ON ".
            "(c.teacher_id = u.user_id AND u.is_teacher = 1 AND c.enabled = 1) JOIN rooms r ON ".
            "(c.room_id = r.id) WHERE (SELECT COUNT(*) AS count FROM join_course jc WHERE jc.course_id = c.course_id AND server_id IS NOT NULL) > 0 ORDER BY c.course_id DESC"
        );
        $result = $query->execute();
        return $result;
    }

    public static function get_course_user_list()
    {
        $query = DB::query(
            "SELECT u.user_id, u.name, u.student_id, jc.course_id, c.name AS course_name, t.name AS teacher_name, IFNULL(jc.server_id, 'NULL') AS server_id ".
            "FROM users u JOIN join_course jc ON (u.user_id = jc.user_id) ".
            "JOIN courses c ON (jc.course_id = c.course_id) JOIN (SELECT user_id, name FROM users WHERE is_teacher = 1) t ON(c.teacher_id = t.user_id)".
            "ORDER BY jc.course_id DESC, jc.server_id DESC"
        );
        $result = $query->execute();
        return $result->as_array();
    }

    public static function find_user_instance_list($user_id)
    {
        $sql = "SELECT u.user_id, u.name, c.name AS course_name, jc.server_id FROM " .
            "users u JOIN join_course jc ON(u.user_id = jc.user_id) JOIN courses c ON (jc.course_id = c.course_id) " .
            "WHERE u.user_id = :user_id AND jc.server_id IS NOT NULL";
        $query = DB::query($sql);
        $query->parameters(array(
            'user_id'       =>  &$user_id
        ));
        return $query->execute();
    }

    /**
     * コースに所属しているユーザリスト
     * @param $course_id
     * @return mixed
     */
    public static function find_course_user_list($course_id)
    {
        $sql = "SELECT u.user_id, u.name, u.student_id, jc.server_id, jc.course_id " .
            "FROM users u JOIN join_course jc ON (u.user_id = jc.user_id AND jc.course_id = :course_id AND jc.server_id IS NOT NULL) " .
            "ORDER BY jc.server_id DESC, u.user_id DESC";
        $query = DB::query($sql);
        $query->parameters(array(
            'course_id' => &$course_id
        ));
        return $query->execute();
    }

    /**
     * コースの追加
     * @param $course_name
     * @param $teacher_id
     * @param $room_id
     */
    public static function add_course($course_name, $teacher_id, $room_id)
    {
        $query = DB::query("INSERT INTO courses (name, teacher_id, room_id) VALUES (:name, :teacher_id, :room_id)");
        $query->parameters(array(
            'name'          => &$course_name,
            'teacher_id'    => &$teacher_id,
            'room_id'       => &$room_id
        ));

        return $query->execute();
    }

    public static function delete_course($course_id)
    {
        $query = DB::update('courses');
        $query->set(array(
            'enabled'   => 0
        ));
        $query->where('course_id', '=', $course_id);
        return $query->execute();
    }

    public static function update_course($course_id, $course_name, $teacher_id, $room_id)
    {
        $query = DB::update('courses');
        $query->set(array(
            'name'          =>  &$course_name,
            'teacher_id'    =>  &$teacher_id,
            'room_id'       =>  &$room_id
        ));
        $query->where('course_id', '=', $course_id);
        return $query->execute();
    }

    public static function get_course($id)
    {
        $query = DB::query(
            'SELECT c.name AS course_name, u.name AS teacher_name, c.course_id '.
            'FROM courses c JOIN users u ON (c.teacher_id = u.user_id AND u.is_teacher = 1 AND c.course_id = :course_id)');
        $query->parameters(array(
            'course_id' => $id
        ));
        $result = $query->execute();
        if(is_array($result->as_array())){
            return $result->as_array()[0];
        }else{
            return null;
        }
    }

    public static function add_user_to_course($course_id, $user_id)
    {
        $query = DB::insert('join_course');
        $query->columns(array('course_id', 'user_id'));

        return $query->values(array($course_id, $user_id))->execute();
    }

    /**
     * サーバを登録する
     */
    public static function add_server($user_id, $course_id, $server_id)
    {
        $query = DB::query('UPDATE join_course SET server_id = :server_id WHERE user_id = :user_id AND course_id = :course_id');
        $query->parameters(
            array(
                'server_id' => $server_id,
                'user_id'   => $user_id,
                'course_id' => $course_id
            )
        );
        return $query->execute();
    }
} 