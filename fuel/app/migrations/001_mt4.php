<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/02
 * Time: 17:56
 */

namespace Fuel\migrations;


use Fuel\Core\DBUtil;

class mt4
{
    function up()
    {
        DBUtil::create_table('users', array(
                'user_id'   => array('type' => 'int',     'constraint' => 11,   'auto_increment' => true),
                'name'      => array('type' => 'varchar', 'constraint' => 255),
                'student_id'=> array('type' => 'varchar', 'constraint' => 5),
                'is_teacher'=> array('type' => 'tinyint', 'constraint' => 1,    'default' => 0)
            ),
            array('user_id'));
        //create index
        DBUtil::create_index('users', 'student_id', 'idx_student_id');
        DBUtil::create_table('courses', array(
                'course_id' => array('type' => 'int'    , 'constraint' => 11,   'auto_increment' => true),
                'name'      => array('type' => 'varchar', 'constraint' => 255),
                'teacher_id'=> array('type' => 'varchar', 'constraint' => 64),
                'room_id'   => array('type' => 'varchar', 'constraint' => 5),
                'enabled'   => array('type' => 'tinyint', 'constraint' => 1,    'default' => 1)
            ),
            array('course_id'));
        DBUtil::create_table('rooms', array(
                'id'        => array('type' => 'varchar', 'constraint' => 5),
                'name'      => array('type' => 'varchar', 'constraint' => 255)
            ),
            array('id'));
        DBUtil::create_table('join_course', array(
                'user_id'   => array('type' => 'int'    , 'constraint' => 11),
                'course_id' => array('type' => 'int'    , 'constraint' => 11),
                'server_id' => array('type' => 'varchar', 'constraint' => 64,   'null' => true)
            ),
            array('user_id', 'course_id'));
    }

    function down()
    {
        DBUtil::drop_table('users');
        DBUtil::drop_table('courses');
        DBUtil::drop_table('rooms');
        DBUtil::drop_table('join_course');
    }
}