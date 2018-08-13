<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Stock extends MY_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$this->load->helper('url');
		$data = array();
        //var_dump($data);

        $this->load->library('pagination');
        $data_limit = $this->uri->segment(3,0);
        $config['base_url']=base_url()."Stock/index";
        $config['per_page']=10;

        $sql = "select lr_product.name as p_name,lr_product.pro_number,lr_guige.* from lr_product,lr_guige where lr_product.id = lr_guige.pid  limit ".$data_limit.",".$config['per_page'];
        //$data['stock_list'] = DB::raw($sql);
        $query = DB::raw($sql, []);
        $data['stock_list'] = $query->fetchAll(PDO::FETCH_OBJ);

        $query_result = DB::select("lr_guige",['count(*) as total_rows'],'');
        $config['total_rows']= $query_result[0]->total_rows;

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a>';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);

        $this->render('stock',$data,array('title'=>"商品库存",'small_title'=>"库存管理"));
	}

	public function add_form(){
        $this->load->helper('url');
        $goods = DB::select("lr_product",['*'],[],'');
        $goods_array = array();
        foreach ($goods as $row){
            $goods_array[$row->id] = $row->name;
        }

        $data['field_list'] = array(
            array('type'=>"select",'name'=>'pid','label'=>'商品','default_value'=>"",'option'=>$goods_array,'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'name','label'=>'规格名称','default_value'=>"",'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"number",'name'=>'price','label'=>'价格','default_value'=>"",'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"number",'name'=>'stock','label'=>'库存','default_value'=>"",'option'=>array(),'required'=>true,'readonly'=>false)
        );
        $data['form_action'] = "Stock/add_item";
        $this->render('form_builder',$data,array('title'=>"增加",'small_title'=>"库存信息"));
    }

    public function add_item(){
        $this->load->helper('url');
        $insert_data = array(
            'pid' => $this->input->post('pid'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'stock' => $this->input->post('stock')
        );
        DB::insert('lr_guige',$insert_data);
        redirect('Stock/index');
    }

    public function edit_form(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        $item_info = DB::row("lr_guige",['*'],['id'=>$item_id],'');

        $goods = DB::select("lr_product",['*'],[],'');
        $goods_array = array();
        foreach ($goods as $row){
            $goods_array[$row->id] = $row->name;
        }

        $data['field_list'] = array(
            array('type'=>"select",'name'=>'pid','label'=>'商品','default_value'=>$item_info->pid,'option'=>$goods_array,'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'name','label'=>'规格名称','default_value'=>$item_info->name,'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"number",'name'=>'price','label'=>'价格','default_value'=>$item_info->price,'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"number",'name'=>'stock','label'=>'库存','default_value'=>$item_info->stock,'option'=>array(),'required'=>true,'readonly'=>false)
        );
        $data['form_action'] = "Stock/edit_item/".$item_id;
        $this->render('form_builder',$data,array('title'=>"修改",'small_title'=>"库存信息"));
    }

    public function edit_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        $update_data = array(
            'pid' => $this->input->post('pid'),
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'stock' => $this->input->post('stock')
        );
        DB::update('lr_guige',$update_data,['id'=>$item_id]);
        redirect('Stock/index');
    }
    public function delete_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        if(!empty($item_id))    $rows = DB::delete('lr_guige',['id'=>$item_id]);
        redirect('Stock/index');
    }

}