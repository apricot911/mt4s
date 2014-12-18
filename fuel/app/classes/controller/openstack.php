<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/12/13
 * Time: 23:17
 */

define("SERVER_ADDRESS", "133.242.238.61");

class Controller_Openstack extends Controller_Rest{


    public function before(){
        parent::before();
        Session::destroy();
        Session::instance();
        self::fetchToken();
       // echo \mt4\TokenHelper::getPublicUrl("nova", Session::get("openstack"));
//        $this->template->token = Session::get('token');
//        $this->template->tenantid = Session::get('tenantid');
    }

    public function action_index(){
        echo Input::ip();
        return "aa";
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
    public function post_sendRequest(){
        $component  = Input::json('component');
        $path       = Input::json('path');
        $method     = Input::json('method');
        $data       = Input::json('data', "");
        $public_url = self::getPublicUrl($component);
        if(empty($public_url)){
            return "error";
        }
        $url        = $public_url . $path;
        $result     = self::sendCurlRequest($url, $method, $data);
//        echo "<br>" . $url . "<br>";
//        var_dump($result);
//        return "";
        return $this->response(json_decode($result));
    }

    public function action_serverList(){
        $nova_public_url = self::getPublicUrl("nova");
        $result = self::sendCurlRequest($nova_public_url . "/servers", "GET");
        return $this->response(json_decode($result));
    }

    /**
     * OpenStackのtokenを取得する
     */
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
    public function sendCurlRequest($url, $method, $data = ""){
        $token = Session::get('token');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, mb_strtoupper($method));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Auth-Token: ' . $token
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        return $result;
    }


    public function getPublicUrl($compornentName){
        $openstackObj = Session::get("openstack");
        $catalogs =  $openstackObj['access']['serviceCatalog'];

        $findCatalog = array_filter($catalogs, function($e) use ($compornentName){
            return $e['name'] ==  $compornentName;
        });
        if(count($findCatalog) == 1){
            return $findCatalog[0]['endpoints'][0]['publicURL'];
        }else{
            echo "findCatalog : {$compornentName}";
            var_dump($findCatalog);
            return null;
        }
        //var_dump($catalog['endpoints']);

    }
}