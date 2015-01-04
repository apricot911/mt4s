<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 23:33
 */

namespace Model;


use Fuel\Core\DB;
use Fuel\Core\Model;

class Room extends Model
{
    public static function get_all_room(){
        $query = DB::select('*')->from('rooms');
        return $query->execute();
    }
} 