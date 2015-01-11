<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 2:00
 */

use Auth\Auth_Acl_Driver;
use Auth\condition;
use Auth\user;
use Fuel\Core\DB;

class Auth_Acl_Mt4Auth extends Auth_Acl_Driver {

    /**
     * Check access rights
     * condition = student or teacher;
     *
     * @param    mixed    condition to check for access;
     * @param    mixed    user or group identifier in the form of array(driver_id, id)
     * @return    bool
     */
    public function has_access($condition, Array $entity)
    {
        $user_id = $entity[1];
        $sql = "SELECT is_teacher FROM users WHERE user_id = :user_id";
        $query = DB::query($sql);
        $query->parameters(array('user_id' => $user_id));
        $result = $query->execute()->as_array();

        if(count($result) == 0){
            return false;
        }else if($condition == 'teacher'){
            if($result['is_teacher'] >= 1){
                return true;
            }
        }else if($condition == 'student'){
            if($result['is_teacher'] >= 0){
                return true;
            }
        }
        return false;
    }
} 