<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Swiper extends MY_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$this->load->helper('url');
		$data = array();

        $this->load->library('pagination');
        $data_limit = $this->uri->segment(3,0);
        $config['base_url']=base_url()."Swiper/index";
        $config['per_page']=10;
        $suffix = ' order by id '.' limit '.$data_limit.','.$config['per_page'];
        $data['img_list'] = DB::select("lr_swiper_img",['*'],[],'',$suffix);
        $query_result = DB::select("lr_swiper_img",['count(*) as total_rows'],'');
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

        $this->render('swiper_list',$data,array('title'=>"轮番图列表",'small_title'=>"数据管理"));
	}

	public function get_img_list(){
        $img_list = DB::select("lr_swiper_img",['*'],[],'','');
        echo json_encode($img_list);
    }
	public function add_form(){
        $this->load->helper('url');

        $data['form_action'] = "Swiper/add_item";
        $this->render('swiper_add_form',$data,array('title'=>"增加",'small_title'=>"图片列表"));
    }

    public function add_item(){
        $this->load->helper('url');
        $img_array = explode(',',$this->input->post('photo_string'));
        foreach ( $img_array as $img_url){
            $insert_data = array(
                'img_url' => $img_url
            );
            DB::insert('lr_swiper_img',$insert_data);
        }
        redirect('Swiper/index');
    }

    public function delete_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        if(!empty($item_id))    $rows = DB::delete('lr_swiper_img',['id'=>$item_id]);
        redirect('Swiper/index');
    }

}