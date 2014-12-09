<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 14:25
 */

class Controller_Admin extends Controller_Template{

    public $template = "admin/template";
    public function before(){
        parent::before();
        Session::instance();
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('admin/header');
        $this->template->navbar = View::forge('admin/navigation');
       // echo "test";
        self::fetchToken();
        echo Session::get("token");

    }

    public function action_index(){
        $this->template->content = View::forge('admin/index');
    }

    public function action_instance(){
        $this->template->content = View::forge('admin/instance');
    }

    public function action_network(){
        $this->template->content = View::forge('admin/network');
    }

    public function action_course(){
        $this->template->content = View::forge('admin/course');
    }

    public function action_user(){
        $this->template->content = View::forge('admin/index');
    }

    public function fetchToken(){
        if ((new DateTime(Session::get('token_expire', 'now')))->getTimestamp() < (new Datetime('now'))->getTimestamp()){
            return;
        }
        /**
         * {"auth": {"tenantName": "admin", "passwordCredentials": {"username": "admin", "password": "mysql"}}}
         */
        $str_data = json_encode(array('auth' =>
            array('tenantName' => 'admin', 'passwordCredentials' =>
                array('username' => 'admin', 'password' => 'mysql'))));
        $ch = curl_init('http://133.242.225.231:5000/v2.0/tokens');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        $result = curl_exec($ch);
        $openstack_token = json_decode($result, true);
        Session::set("token", $openstack_token['access']['token']['id']);
        Session::set("token_expire", $openstack_token['access']['token']['expires']);
    }
}