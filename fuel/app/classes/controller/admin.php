<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 14:25
 */

use Fuel\Core\View;
use Fuel\Core\Controller_Template;
use Model\Course;
use Model\Room;
use Model\User;

class Controller_Admin extends Controller_Template{

    public $template = "admin/template";
    public function before()
    {
        parent::before();
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('admin/header');
        $this->template->navbar = View::forge('admin/navigation');
    }

    public function action_index()
    {
        $this->template->content = View::forge('admin/index');
    }

    public function action_instance()
    {
        $this->template->content = View::forge('admin/instance');
    }

    public function action_network()
    {
        $this->template->content = View::forge('admin/network');
    }

    /**
     * コース一覧
     */
    public function action_courses()
    {
        $view = View::forge('admin/course');
        $view->room_list = Room::get_all_room()->as_array();
        $view->teacher_list = User::get_all_teacher()->as_array();
        $this->template->content = $view;
    }

    /**
     * コース修正
     */
    public function action_course($id){
        $view = View::forge('admin/course/detail');
        $view->course = Course::get_course($id);
        $this->template->content = $view;
    }

    public function action_students()
    {
        $view = View::forge('admin/students');
        $view->room_list = Room::get_all_room()->as_array();
        $view->teacher_list = User::get_all_teacher()->as_array();
        $this->template->content = $view;
    }
    public function get_config()
    {
        $view = View::forge('admin/config');
        $this->template->content = $view;
    }
    public function action_user()
    {
        $this->template->content = View::forge('admin/index');
    }
}