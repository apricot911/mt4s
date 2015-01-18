<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/11/28
 * Time: 14:25
 */

use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\View;
use Fuel\Core\Controller_Template;
use Model\Course;
use Model\Room;
use Model\User;
use Auth\Auth;
use Fuel\Core\Response;

class Controller_Admin extends Controller_Template{

    public $template = "admin/template";
    public function before()
    {
        parent::before();
        if(!Auth::instance()->check()){
            return Response::redirect('/');
        }else{
            if(Auth::instance()->get_groups() == 0){
                return Response::redirect('/user/');
            }
        }
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('admin/header');
        $this->template->navbar = View::forge('admin/navigation');
        $this->template->footer = View::forge('admin/footer');
    }

    public function action_index()
    {
        $view = View::forge('admin/index');
        $course_list = array();
        foreach(Course::get_course_user_list() as $course){
            $course_list[$course['course_id']][] = $course;
        }
        $view->course_list = $course_list;
        $view->test = Course::get_course_user_list();
        $this->template->content = $view;
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
        $view = View::forge('admin/courses');
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
        $view->student_prefix = User::get_student_prefix_group();
        $this->template->content = $view;
    }
    public function get_config()
    {
        $user_data = User::get_user(Auth::instance()->get_user_id());
        $view = View::forge('admin/config');
        $view->user_name = $user_data['name'];
        $view->student_id = $user_data['student_id'];
        $this->template->content = $view;
    }

    public function post_config()
    {
        $user_name = Input::post('user_name');
        $student_id = Input::post('student_id');
        $password = Input::post('password', null);
        if(is_null($password) || $password == ""){
            $user_data = array(
                'name'  =>  $user_name,
                'student_id'    => $student_id
            );
        }else{
            $user_data = array(
                'name'      => $user_name,
                'student_id'=> $student_id,
                'password'  => $password
            );
        }
        User::update_user($user_data, Auth::instance()->get_user_id());
        Response::redirect('/admin/config');
    }

    public function action_user()
    {
        $this->template->content = View::forge('admin/index');
    }
}