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
            "(c.room_id = r.id)"
        );
        $result = $query->execute();
        return $result;
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
} 