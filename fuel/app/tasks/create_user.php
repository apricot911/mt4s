<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 11:49
 */

namespace Fuel\Tasks;


use Fuel\Core\DB;
use Model\User;

class Create_User {
    public function run($speech = null)
    {
        //create test user;
        DB::delete('users')->execute();
        DB::query("ALTER TABLE users AUTO_INCREMENT = 1")->execute();
        for($i = 0; $i < 4000; $i++){
            $id = str_pad($i, 4, "0" , STR_PAD_LEFT);
            User::add_user('テストユーザ' . $id, 'b'. $id , 0);
        }

        DB::update('users')->set(array('is_teacher' => '1'))->where('user_id', '=', '10')->execute();

        DB::delete('courses')->execute();
        DB::query("ALTER TABLE courses AUTO_INCREMENT = 1")->execute();
        $query = DB::insert('courses');
        $query->columns(array('name', 'teacher_id', 'room_id'));
        $course_name = array("2-A たけし", "3-B たけし", "1-C たけし", "1-B たけし");

        foreach($course_name as $i => $val){
            $query->values(array(
                $val, 10, '5A'
            ));
        }
        $query->execute();

        return "done";
    }


} 