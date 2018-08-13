<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Swiper_interface extends CI_controller{

	public function get_img_list(){
        $img_list = DB::select("lr_swiper_img",['*'],[],'','');
        echo json_encode($img_list);
    }

}