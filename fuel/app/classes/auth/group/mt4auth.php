<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 2:00
 */


use Auth\Auth_Group_Driver;
use Auth\condition;
use Auth\group;
use Auth\user;

class Auth_Group_Mt4Auth extends Auth_Group_Driver{

    /**
     * Check membership of given users
     *
     * @param    mixed    condition to check for access
     * @param    array    user identifier in the form of array(driver_id, user_id), or null for logged in
     * @return    bool
     */
    public function member($group, $user = null)
    {
        return true;
    }

    /**
     * Fetch the display name of the given group
     *
     * @param    mixed    group condition to check
     * @return    string
     */
    public function get_name($group)
    {
        return "";
    }

} 