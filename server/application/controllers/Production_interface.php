<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use \QCloud_WeApp_SDK\Conf as Conf;
use \QCloud_WeApp_SDK\Cos\CosAPI as Cos;


class Production_interface extends CI_controller{
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->helper('url');
        $sql = "select lr_product.id as goods_id,lr_product.name as p_name,lr_product.pro_number,photo_x, lr_guige.* from lr_product,lr_guige where lr_product.id = lr_guige.pid ";

        $query = DB::raw($sql, []);
        $stock_list = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($stock_list);

	}

	public function get_goods_info(){
        $this->load->helper('url');

        $goods_id = $this->input->post('goods_id');

        $sql = "select lr_product.id as goods_id,lr_product.name as p_name,lr_guige.price as stock_price,lr_guige.name as guige_name,lr_product.*,lr_guige.* ".
"from lr_product,lr_guige where lr_product.id = lr_guige.pid and lr_product.id = '".$goods_id."'";

        $query = DB::raw($sql, []);
        $stock_list = $query->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($stock_list);

    }



}