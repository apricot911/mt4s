<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */
use Auth\Auth;
use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Model\User;

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_User extends Controller_Template
{
    public $template = "admin/template";
    public function before(){
        parent::before();
        if(!Auth::instance()->check()){
            return Response::redirect('/');
        }else{
            if(Auth::instance()->get_groups() == 1){
                return Response::redirect('/admin/');
            }
        }
        Asset::add_path('assets/plugins', 'plugins');
        $this->template->header = View::forge('user/header');
        $this->template->navbar = View::forge('user/navigation');
        $this->template->footer = View::forge('user/footer');
    }

    /**
     * The basic welcome message
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        $view = View::forge('user/index');
        $view->user_id = Auth::instance()->get_user_id();
        $this->template->content = $view;
    }

    public function get_config()
    {
        $user_data = User::get_user(Auth::instance()->get_user_id());
        $view = View::forge('user/config');
        $view->name = $user_data['name'];
        $this->template->content = $view;
    }

    public function post_config()
    {
        $user_name = Input::post('user_name', "OICの生徒");
        $password = Input::post('password', null);
        if(is_null($password) || $password == ""){
           $data_array = array(
               'name'   => $user_name
           );
        }else{
            $data_array = array(
                'name'  => $user_name,
                'password'=>$password
            );
        }
        User::update_user($data_array, Auth::instance()->get_user_id());
        return Response::redirect('/user/config');
    }
}
