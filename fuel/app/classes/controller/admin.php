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
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('admin/header');
        $this->template->navbar = View::forge('admin/navigation');
       // Asset::css(array('bootstrap.css'));
       // echo "test";
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
}