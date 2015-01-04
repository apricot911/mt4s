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
} 