<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 15/01/11
 * Time: 3:09
 */

use Fuel\Core\Controller;
use Fuel\Core\View;
use Fuel\Core\Response;
use Auth\Auth;
use Fuel\Core\Input;

class Controller_Index extends Controller
{
    public function before(){
        parent::before();
        Asset::add_path('assets/plugins', 'plugins');
        if(Auth::instance()->check()){
            if(Auth::instance()->get_groups() == 1){
                Response::redirect('admin/index');
            }else{
                Response::redirect('user/index');
            }
        }
    }
    public function get_index()
    {
        $view =  View::forge('login');
        return Response::forge($view);
    }

    public function post_index()
    {
        $student_id = Input::post('student_id');
        $password = Input::post('password');
        if(Auth::instance()->login($student_id, $password)){
            if(Auth::instance()->get_groups() == 1){
                return Response::redirect('admin/index');
            }else{
                return Response::redirect('user/index');
            }
        }else{
            $view = View::forge('login');
            $view->error = "ユーザ名かパスワードが間違っています。";
            return Response::forge($view);
        }
    }

    public function get_logout()
    {
        Auth::logout();
        return Response::redirect('/');
    }
}