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
            'user_id'   => array('type' => 'varchar', 'constraint' => 64),
            'name'      => array('type' => 'varchar', 'constraint' => 255),
            'student_id'=> array('type' => 'varchar', 'constraint' => 5),
            'is_teacher'=> array('type' => 'tinyint', 'constraint' => 1)
        ));
    }

    function down()
    {
        DBUtil::drop_table('users');
    }
}