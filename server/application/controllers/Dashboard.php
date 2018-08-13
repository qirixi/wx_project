<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$this->load->helper('url');
		$data = array();
        $this->render('dashboard',$data,array('title'=>"测试布局",'small_title'=>"小标题"));
	}

}