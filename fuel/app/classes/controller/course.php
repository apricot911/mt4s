<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 17:05
 */

class Controller_Course extends \Fuel\Core\Controller_Template{

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
        return "";
    }

    public function action_detail(){
        $this->template->content = View::forge('admin/course/detail');
    }
}