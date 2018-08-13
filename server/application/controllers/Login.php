<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Login extends CI_Controller{
	public function __construct(){
    //session_start();
		parent::__construct();
	}

	public function index(){
		$this->load->helper('url');
		if(isset($_SESSION['userinfo'])){
			redirect('Dashboard/index');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username','username','trim|required');
		$this->form_validation->set_rules('password','password','trim|required|callback_valid_user_check');

		
		if($this->form_validation->run() === FALSE){
			$this->load->view('login');
		}
		else{
      $user_info = DB::select("lr_adminuser",['*'],['name'=>$this->input->post('username'),'pwd'=>md5(md5($this->input->post('password')))]);
			if(!empty($user_info)){
				$_SESSION['user_info'] = $user_info;
        //echo "session:";
        //var_dump($_SESSION);
				redirect('Dashboard/index');
			}
		}
	}
	public function logout(){
		$this->load->helper('url');
		if(isset($_SESSION['user_info'])){
			session_destroy();
		}
		redirect('Login/index');
	}

	function valid_user_check(){
    $row = DB::select("lr_adminuser",['*'],['name'=>$this->input->post('username'),'pwd'=>md5(md5($this->input->post('password')))]);
		if(empty($row)){
      //echo md5($this->input->post('password'));
			$this->form_validation->set_message('valid_user_check', '用户名或密码错误');			
			return FALSE;
		}
		return TRUE;
	}
	function check_old_passwd(){
		if($this->user_model->check_old_passwd()===FALSE){
			$this->form_validation->set_message('check_old_passwd', '原密码错误');
			return FALSE;
		}
		return TRUE;
	}
}