<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use \QCloud_WeApp_SDK\Conf as Conf;
use \QCloud_WeApp_SDK\Cos\CosAPI as Cos;


class Production extends MY_controller{
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->helper('url');
		$data = array();
        //var_dump($data);

        $this->load->library('pagination');
        $data_limit = $this->uri->segment(3,0);
        $config['base_url']=base_url()."Production/index";
        $config['per_page']=10;
        $suffix = ' order by id '.' limit '.$data_limit.','.$config['per_page'];
        $data['goods_list'] = DB::select("lr_product",['*'],[],'',$suffix);

        $cate_list = DB::select("lr_category",['*'],[],'');
        $parents_node_array = array();
        foreach ($cate_list as $row){
            $parents_node_array[$row->id] = $row->name;
        }
        $data['cate_array'] = $parents_node_array;

        $query_result = DB::select("lr_product",['count(*) as total_rows'],'');
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

        $this->render('production',$data,array('title'=>"商品列表",'small_title'=>"商品管理"));
	}

	public function add_form(){
        $this->load->helper('url');
        $parents_node = DB::select("lr_category",['*']);

        $parents_node_array = array();
        foreach ($parents_node as $row){
            $parents_node_array[$row->id] = $row->name;
        }

        $data['field_list'] = array(
            array('type'=>"input",'name'=>'name','label'=>'产品名称','default_value'=>"",'required'=>true),
            array('type'=>"input",'name'=>'intro','label'=>'广告语','default_value'=>"",'required'=>true),
            array('type'=>"input",'name'=>'pro_number','label'=>'产品编号','default_value'=>"",'required'=>true),
            array('type'=>"number",'name'=>'price','label'=>'价格','default_value'=>"",'required'=>true),
            array('type'=>"number",'name'=>'price_yh','label'=>'优惠价格','default_value'=>"",'required'=>true),
            array('type'=>"select",'name'=>'cid','label'=>'分类','default_value'=>"",'option'=>$parents_node_array,'required'=>true,'readonly'=>false),
            array('type'=>"textarea",'name'=>'content','label'=>'产品详情','default_value'=>""),
            array('type'=>"file",'name'=>'photo_x','label'=>'商品展示图','default_value'=>""),
            array('type'=>"picGroup",'name'=>'photo_string','label'=>'图片组','default_value'=>"")
        );
        $data['form_action'] = "Production/add_item";
        $this->render('form_builder',$data,array('title'=>"增加",'small_title'=>"分类信息"));
    }

    public function picGroup_frame(){
        $this->load->helper('url');
        $this->load->view('picGroup');
    }

    public function upload_image(){

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }

        $this->load->library('upload_img');
        $result = $this->upload_img->do_upload('goods',$_FILES['file']);
        $this->json($result);
    }

    public function add_item(){
        $this->load->helper('url');

        $insert_data = array(
            'name' => $this->input->post('name'),
            'intro' => $this->input->post('intro'),
            'pro_number' => $this->input->post('pro_number'),
            'price' => $this->input->post('price'),
            'price_yh' => $this->input->post('price_yh'),
            'cid' => $this->input->post('cid'),
            'content' => $this->input->post('content'),
            'photo_string' => $this->input->post('photo_string'),
            'addtime' => time(),
            'updatetime' => time()
        );

        if(isset($_FILES['photo_x']['tmp_name'])){
            $this->load->library('upload_img');
            $result = $this->upload_img->do_upload('thumb',$_FILES['photo_x']);
            $insert_data['photo_x'] = $result['data']['imgUrl'];
        }

        DB::insert('lr_product',$insert_data);
        redirect('Production/index');
    }

    public function edit_form(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        $item_info = DB::row("lr_product",['*'],['id'=>$item_id],'');

        $parents_node = DB::select("lr_category",['*'],[],'');
        $parents_node_array = array();
        foreach ($parents_node as $row){
            array_push($parents_node_array,array($row->id=>$row->name));
        }

        $data['field_list'] = array(
            array('type'=>"input",'name'=>'name','label'=>'产品名称','default_value'=>$item_info->name,'required'=>true),
            array('type'=>"input",'name'=>'intro','label'=>'广告语','default_value'=>$item_info->intro,'required'=>true),
            array('type'=>"input",'name'=>'pro_number','label'=>'产品编号','default_value'=>$item_info->pro_number,'required'=>true),
            array('type'=>"number",'name'=>'price','label'=>'价格','default_value'=>$item_info->price,'required'=>true),
            array('type'=>"number",'name'=>'price_yh','label'=>'优惠价格','default_value'=>$item_info->price_yh,'required'=>true),
            array('type'=>"select",'name'=>'cid','label'=>'分类','default_value'=>$item_info->cid,'option'=>$parents_node_array,'required'=>true,'readonly'=>false),
            array('type'=>"textarea",'name'=>'content','label'=>'产品详情','default_value'=>$item_info->content),
            array('type'=>"file",'name'=>'photo_x','label'=>'商品展示图','default_value'=>$item_info->photo_x),
            array('type'=>"picGroup",'name'=>'photo_string','label'=>'图片组','default_value'=>$item_info->photo_string)
        );
        $data['form_action'] = "Production/edit_item/".$item_id;
        $this->render('form_builder',$data,array('title'=>"修改",'small_title'=>"分类信息"));
    }

    public function delete_image(){
        $this->load->helper('url');
        $file_path = $this->input->post('file_url');
        $file_name = basename($file_path);
        $this->load->library('upload_img');
        $result = $this->upload_img->delete_img($file_name);
        $this->json($result);
    }

    public function edit_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);

        $update_data = array(
            'name' => $this->input->post('name'),
            'intro' => $this->input->post('intro'),
            'pro_number' => $this->input->post('pro_number'),
            'price' => $this->input->post('price'),
            'price_yh' => $this->input->post('price_yh'),
            'cid' => $this->input->post('cid'),
            'content' => $this->input->post('content'),
            'photo_string' => $this->input->post('photo_string'),
            'updatetime' => time()
        );

        if(!isset($_FILES['photo_x']['tmp_name'])){
            $this->load->library('upload_img');
            $result = $this->upload_img->do_upload('thumb',$_FILES['photo_x']);
            $update_data['photo_x'] = $result['data']['imgUrl'];
        }
        DB::update('lr_product',$update_data,['id'=>$item_id]);
        redirect('Production/index');
    }
    public function delete_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        if(!empty($item_id))    $rows = DB::delete('lr_product',['id'=>$item_id]);
        redirect('Production/index');
    }

}