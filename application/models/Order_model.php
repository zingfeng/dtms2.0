<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function save_cart($params,$cart_info){
        $order = array(
            'user_id' => $params['user_id'],
            'voucher_id' => $params['voucher_id'],
            'payment' => $params['payment'], // thanh toan tu tai khoan
            'status' => $params['status'], // da thanh toan
            'price_received' => $params['price_received'],
            'price_discount' => $params['price_discount'],
            'create_time' => time()
        );
        $this->db->insert('order',$order);
        $order_id = $this->db->insert_id();
        foreach ($cart_info as $content){
            $input[] = array(
                'order_id' => $order_id,
                'object_id' => $content['id'],
                'course_id' => $content['course_id'],
                'name' => $content['name'],
                'price_item' => $content['price'],
                'quantity' => $content['qty'],
                'type' => $content['type'],
            );   
        }
        $this->db->insert_batch('order_detail',$input);
    }
    /**
    * @author: namtq
    * @todo: get detail of order by course id
    * @param: array(course_id, user_id)
    * @return: array order
    */
    public function get_order_by_course($params){
        //var_dump($params); die;
        $this->db->select('order_detail.*');
        $this->db->where('order_detail.course_id',$params['course_id']);
        $this->db->where('order.user_id',$params['user_id']);
        $this->db->join('order','order.order_id = order_detail.order_id');
        $this->db->where("order.status",1);
        $query = $this->db->get('order_detail');
        $rows = $query->result_array();
        $result = array();
        foreach ($rows as $key => $row) {
            $result[$row['type']][$row['object_id']] = $row;
        }
        return $result;
    }
    public function lists($params) {

    }
}