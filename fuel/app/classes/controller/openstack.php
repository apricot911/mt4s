<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/12/13
 * Time: 23:17
 */

use Fuel\Core\Session;

define("SERVER_ADDRESS", "126.26.225.14");
define("OPENSTACK_TENANT", "admin");
define("OPENSTACK_TENANT_USER", "admin");
define("OPENSTACK_TENANT_PASSWORD", "mysql");

class Controller_Openstack extends Controller_Rest{


    public function before(){
        parent::before();
        self::fetch_token();
    }

    public function action_index(){
        echo Input::ip();
        echo self::get_public_url('nova');
        return "";
    }

    public function action_api(){
        $url = Input::get('url');
        $type = Input::get('type');
        $data = Input::get('data');
    }

    /**
     * OpenStackAPIをサーバから送信するためのメソッド
     * $.ajaxで使用する場合はdataの部分を下記のようにする
     * data : '{"data": {"component":"nova", "path": "/servers", "data": ""}}'
     * @return mixed
     */
    public function post_send_request(){
        $component  = Input::json('component');
        $path       = Input::json('path');
        $method     = Input::json('method');
        $data       = Input::json('data', "");
        $public_url = self::get_public_url($component);
        if(empty($public_url)){
            return "error";
        }
//        echo Session::get('token');
        $url        = $public_url . $path;
        $result     = self::send_curl_request($url, $method, json_encode($data));
        if($result == "Authentication required"){
            self::fetch_token(true);
            $result = self::send_curl_request($url, $method, json_encode($data));
        }
        return $this->response(json_decode($result));
    }

    /**
     * OpenStackのtokenを取得する
     */
    public function fetch_token($force = false){
        if ((new DateTime(Session::get('token_expire', 'now')))->getTimestamp() < (new Datetime('now'))->getTimestamp()){
            if(!$force){
                return;
            }
        }
        /**
         * {"auth": {"tenantName": "admin", "passwordCredentials": {"username": "admin", "password": "mysql"}}}
         */
        $str_data = json_encode(array('auth' =>
            array('tenantName' => OPENSTACK_TENANT, 'passwordCredentials' =>
                array('username' => OPENSTACK_TENANT_USER, 'password' => OPENSTACK_TENANT_PASSWORD))));
        $ch = curl_init('http://'. SERVER_ADDRESS .':5000/v2.0/tokens');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        $result = curl_exec($ch);
        $openstack_token = json_decode($result, true);
        Session::set("openstack", $openstack_token);
        Session::set("token", $openstack_token['access']['token']['id']);
        Session::set("token_expire", $openstack_token['access']['token']['expires']);
        Session::set("tenantid", $openstack_token['access']['token']['tenant']['id']);
    }

    /**
     * curl Request送るやつ
     * @param $url
     * @param $method
     * @param string $data
     * @return mixed
     */
    public function send_curl_request($url, $method, $data = ""){
        $token = Session::get('token');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, mb_strtoupper($method));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: python-novaclient',
            'X-Auth-Project-Id: '. OPENSTACK_TENANT_USER,
            'X-Auth-Token: ' . $token
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        return $result;
    }


    private function get_public_url($compornent_name){
        $openstack_obj = Session::get("openstack");
        $catalogs =  $openstack_obj['access']['serviceCatalog'];

        $find_catalog = array_filter($catalogs, function($e) use ($compornent_name){
            return $e['name'] ==  $compornent_name;
        });
        if(count($find_catalog) == 1){
            return $find_catalog[0]['endpoints'][0]['publicURL'];
        }else{
            echo "findCatalog : {$compornent_name}";
            var_dump($find_catalog);
            return null;
        }
        //var_dump($catalog['endpoints']);

    }
}