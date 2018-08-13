<?php
class MY_controller extends CI_Controller{

  protected $layout = "layout/main";

	public function __construct(){
		//session_start();
    parent::__construct();
    $this->check_login();
	}

  private function check_login(){
    $this->load->helper('url');
		if(!isset($_SESSION['user_info'])){
      //var_dump($_SESSION);
      
      $url = base_url()."Login/index";
      echo "<script language='javascript' type='text/javascript'>";
      echo "window.location.href='$url'";
      echo "</script>";
      exit;
      
    }
  }

  protected function render($file=NULL,$viewData=array(),$globalData=array()){
    if(!is_null($file)){
      $data['content'] = $this->load->view($file,$viewData,TRUE);
      $data['layout'] = $globalData;
      $this->load->view($this->layout,$data);
    }
    else{
      $this->load->view($this->layout,$viewData);
    }
    $viewData = array();
  }

}