<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class User_interface extends CI_Controller {
    public function index() {
        $result = LoginService::check();

        if ($result['loginState'] === Constants::S_AUTH) {
            $this->json([
                'code' => 0,
                'data' => $result['userinfo']
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => []
            ]);
        }
    }

    public function add_user_address(){
        $this->load->helper('url');

        $open_id = $this->input->post('open_id');
        $addr_list = DB::select("lr_address",['*'],['openId'=>$open_id],'');
        if(count($addr_list)>0){

            $update_data = array(
                'name' => $this->input->post('post_name'),
                'address' => $this->input->post('address'),
                'tel' => $this->input->post('phone')
            );
            DB::update('lr_address',$update_data,['openId'=>$open_id]);
        }
        else{
            $insert_data = array(
                'openId' => $this->input->post('open_id'),
                'name' => $this->input->post('post_name'),
                'address' => $this->input->post('address'),
                'tel' => $this->input->post('phone')
            );

            DB::insert('lr_address',$insert_data);
        }


    }

    public function get_user_address(){
        $this->load->helper('url');

        $open_id = $this->input->post('open_id');
        $addr_list = DB::select("lr_address",['*'],['openId'=>$open_id],'');
        echo json_encode($addr_list);

    }
}
