<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Categories extends MY_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$this->load->helper('url');
		$data = array();
        //var_dump($data);

        $this->load->library('pagination');
        $data_limit = $this->uri->segment(3,0);
        $config['base_url']=base_url()."Categories/index";
        $config['per_page']=10;
        $suffix = ' order by sort '.' limit '.$data_limit.','.$config['per_page'];
        $data['cate_list'] = DB::select("lr_category",['*'],[],'',$suffix);
        $query_result = DB::select("lr_category",['count(*) as total_rows'],'');
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

        $this->render('categories',$data,array('title'=>"商品分类",'small_title'=>"分类管理"));
	}

	public function add_form(){
        $this->load->helper('url');
        $parents_node = DB::select("lr_category",['*'],['tid'=>'0'],'');
        $parents_node_array = array();
        foreach ($parents_node as $row){
            $parents_node_array[$row->id] = $row->name;
        }
        $parents_node_array['0'] = '根节点';

        $data['field_list'] = array(
            array('type'=>"select",'name'=>'p_ID','label'=>'父级分类','default_value'=>"",'option'=>$parents_node_array,'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'cate_name','label'=>'分类名称','default_value'=>"",'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'sort','label'=>'排序','default_value'=>"",'option'=>array(),'required'=>true,'readonly'=>false)
        );
        $data['form_action'] = "Categories/add_item";
        $this->render('form_builder',$data,array('title'=>"增加",'small_title'=>"分类信息"));
    }

    public function add_item(){
        $this->load->helper('url');
        $insert_data = array(
            'tid' => $this->input->post('p_ID'),
            'name' => $this->input->post('cate_name'),
            'sort' => $this->input->post('sort')
        );
        DB::insert('lr_category',$insert_data);
        redirect('Categories/index');
    }

    public function edit_form(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        $item_info = DB::row("lr_category",['*'],['id'=>$item_id],'');

        $parents_node = DB::select("lr_category",['*'],['tid'=>'0'],'');
        $parents_node_array = array();
        foreach ($parents_node as $row){
            $parents_node_array[$row->id] = $row->name;
        }
        $parents_node_array['0'] = '根节点';

        $data['field_list'] = array(
            array('type'=>"select",'name'=>'p_ID','label'=>'父级分类','default_value'=>$item_info->tid,'option'=>$parents_node_array,'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'cate_name','label'=>'分类名称','default_value'=>$item_info->name,'option'=>array(),'required'=>true,'readonly'=>false),
            array('type'=>"input",'name'=>'sort','label'=>'排序','default_value'=>$item_info->sort,'option'=>array(),'required'=>true,'readonly'=>false)
        );
        $data['form_action'] = "Categories/edit_item/".$item_id;
        $this->render('form_builder',$data,array('title'=>"修改",'small_title'=>"分类信息"));
    }

    public function edit_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        $update_data = array(
            'tid' => $this->input->post('p_ID'),
            'name' => $this->input->post('cate_name'),
            'sort' => $this->input->post('sort')
        );
        DB::update('lr_category',$update_data,['id'=>$item_id]);
        redirect('Categories/index');
    }
    public function delete_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        if(!empty($item_id))    $rows = DB::delete('lr_category',['id'=>$item_id]);
        redirect('Categories/index');
    }

}