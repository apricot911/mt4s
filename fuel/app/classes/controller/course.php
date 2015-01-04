<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 17:05
 */

use Fuel\Core\View;
use Fuel\Core\Controller_Template;

class Controller_Course extends Controller_Template{

    public $template = "admin/template";
    public function before(){
        parent::before();
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('admin/header');
        $this->template->navbar = View::forge('admin/navigation');
    }

    public function action_index(){
        return null;
    }

    public function action_detail(){
        $this->template->content = View::forge('admin/course/detail');
    }
}