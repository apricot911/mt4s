<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 2:01
 */

use Auth\Auth;
use Auth\Auth_Login_Driver;
use Fuel\Core\Session;
use Fuel\Core\DB;
use Model\User;

class Auth_Login_Mt4Auth extends Auth_Login_Driver {

    const SESSION_KEY_LOGGED_IN = 'loggin';
    /**
     * Perform the actual login check
     *
     * @return  bool
     */
    protected function perform_check()
    {
        $is_login = Session::get(self::SESSION_KEY_LOGGED_IN);
        return !empty($is_login);
    }

    /**
     * @param string $student_id
     * @param string $password_hash
     * @return bool
     */
    public function validate_user($student_id = '', $password = '')
    {
        $sql = "SELECT * FROM users WHERE student_id = :student_id AND password = :password";
        $query = DB::query($sql);
        $query->parameters(array(
            'student_id'    => $student_id,
            'password'      => Auth::instance()->hash_password($password)
        ));
        $result = $query->execute();
        var_dump($result);
        $result = $result->as_array();
        if(count($result) == 0){
            return false;
        }else if(count($result) == 1){  //one hit でtrue
            return true;
        }
        return false;
    }

    /**
     * ログインを行う
     * @param string $student_id
     * @param string $password_hash
     * @return bool
     */
    public function login($student_id = '', $password = '')
    {
        if(!$this->validate_user($student_id, $password)){
            return false;
        }

        Session::create();
        Session::set(self::SESSION_KEY_LOGGED_IN, $student_id);
        $user_data = self::get_user_data($student_id, $password);

        Session::set('user_id', $user_data['user_id']);
        Session::set('student_id', $user_data['student_id']);
        Session::set('name', $user_data['name']);
        Session::set('is_teacher', $user_data['is_teacher']);
        return true;
    }

    /**
     * Logout method
     */
    public function logout()
    {
        Session::delete(self::SESSION_KEY_LOGGED_IN);
        Session::destroy();
    }

    /**
     * Get User Identifier of the current logged in user
     * in the form: array(driver_id, user_id)
     *
     * @return  array
     */
    public function get_user_id()
    {
        return Session::get('user_id');
    }

    /**
     * Get User Groups of the current logged in user
     * in the form: array(array(driver_id, group_id), array(driver_id, group_id), etc)
     *
     * @return  array
     */
    public function get_groups()
    {
        Session::get('is_teacher', null);
    }

    /**
     * Get emailaddress of the current logged in user
     *
     * @return  string
     */
    public function get_email()
    {
        Session::get('student_id');
    }

    /**
     * Get screen name of the current logged in user
     *
     * @return  string
     */
    public function get_screen_name()
    {
        Session::get('name');
    }

    public function get_user_data($student_id, $password)
    {
        $sql = "SELECT * FROM users WHERE student_id = :student_id AND password = :password";
        $query = DB::query($sql);
        $query->parameters(array(
            'student_id'    => $student_id,
            'password'      => Auth::instance()->hash_password($password)
        ));
        $result = $query->execute()->as_array();
        return $result[0];
    }

} 