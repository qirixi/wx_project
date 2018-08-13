<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Order extends MY_controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$this->load->helper('url');
        $this->render('order',[],array('title'=>"订单列表",'small_title'=>"状态管理"));
	}


    public function delete_item(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);
        if(!empty($item_id))    $rows = DB::delete('lr_guige',['id'=>$item_id]);
        redirect('Stock/index');
    }

    private  function object_to_array($array){
        if(is_object($array)){
            $array = (array)$array;
        }
        if(is_array($array)){
            foreach ($array as $key=>$value){
                $array[$key] = $this->object_to_array($value);
            }
        }
        return $array;
    }
    public function get_order_list(){
        $this->load->helper('url');
        $order_status = $this->input->post('order_status');
        $order_column =  $this->input->post('order');
        $order_index = $order_column[0]['column'];
        $order_dir = $order_column[0]['dir'];
        $order_array = array('order_sn','price','price_h','addtime','receiver','address_xq','status');
        $search = $this->input->post('search');
        $search_value = addslashes($search['value']);
        $where = " status = '".$order_status."' ";
        if(isset($search_value)&&!empty($search_value)){
            $where .= "and ( order_sn like '%".$search_value."%' or  receiver like '%".$search_value."%' or   address_xq like '%".$search_value."%' ) ";
        }

        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $suffix = ' order by '.$order_array[$order_index].' '.$order_dir.' limit '.$start.','.$length;

        $count_result = DB::select("lr_order",['count(*) as total_rows'],['status'=>$order_status],'');
        $data['draw']= $this->input->post('draw');
        $data['recordsTotal']= $count_result[0]->total_rows;
        $data['recordsFiltered']= $count_result[0]->total_rows;
        $goods = DB::select("lr_order",['*'],$where,'',$suffix);
        $data['data']= $this->object_to_array($goods);
        echo json_encode($data);
    }

    public function count_status_orders(){
        $this->load->helper('url');
        $count_result = DB::select("lr_order",['status','count(*) as rows'],'','',' group by status ');

        echo json_encode($count_result);
    }

    public function order_info(){
        $this->load->helper('url');
        $item_id = $this->uri->segment(3);

        $order_info = DB::row("lr_order",['*'],['id'=>$item_id],'');
        $data['order_info'] = $this->object_to_array($order_info);
        $data['order_details'] = DB::select("lr_order_product",['*'],['order_id'=>$item_id],'');
        $this->render('order_info',$data,array('title'=>"订单列表",'small_title'=>"状态管理"));
    }

    public function back_to_order(){
        $this->load->helper('url');
        redirect('Order/index');
    }

}