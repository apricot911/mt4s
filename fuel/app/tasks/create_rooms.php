<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/04
 * Time: 12:15
 */

namespace Fuel\Tasks;


use Fuel\Core\DB;

class Create_Rooms {
    public function run($speech = null)
    {
        $rooms = array(
            '5A'    =>  '5-A Cisco 教室',
            '5B'    =>  '5-B 教室',
            '5D'    =>  '5-D 大きな教室'
        );
        DB::delete('rooms')->execute();

        $query = DB::insert('rooms');
        foreach($rooms as $id => $name){
            $query->values(array($id, $name));
        }
        $query->execute();
        return "done";
    }
} 