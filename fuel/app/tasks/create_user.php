<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 11:49
 */

namespace Fuel\Tasks;


use Fuel\Core\DB;

class Create_User {
    public function run($speech = null)
    {
        //create test user;
        DB::delete('users')->execute();
        $query = DB::insert('users');
        for($i = 0; $i < 10; $i++){
            for($j = 0; $j<10; $j++){
                $query->values(array(
                    strval($i . '-' . $j), 'テスト'. $j.$i, 'b'.$j.'00'.$i, 0
                ));
            }
        }
        $query->execute();

        DB::update('users')->set(array('is_teacher' => '1'))->where('user_id', '=', '0-1')->execute();

        DB::delete('courses')->execute();
        $query = DB::insert('courses');
        $query->columns(array('name', 'teacher_id', 'room_id'));
        $course_name = array("2-A たけし", "3-B たけし", "1-C たけし", "1-B たけし");

        foreach($course_name as $i => $val){
            $query->values(array(
                $val, "0-1", '5A'
            ));
        }
        $query->execute();

        return "done";
    }


} 