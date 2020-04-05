<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function detail($cate_id){
        $this->db->where_in('cate_id',$cate_id);
        $query = $this->db->get('category');
        if (is_array($cate_id)) {
            return $query->result_array();
        }
        else {
            return $query->row_array();
        }
    }
    /**
    * @author: hieund11
    * @todo: Get all category category with filter
    */
    public function get_category($params = array()) {
        $this->db->select("cate_id, name, share_url, parent,icon");
        if (isset($params['type']) && $params['type']){
            $this->db->where('type',(int) $params['type']);
        }
        $this->db->where('hide_folder',0);
        if (isset($params['show_home']) && $params['show_home']){
            $this->db->where('show_home',(int) $params['show_home']);
        }
        if ($params['limit']) {
            $this->db->limit($params['limit']);
        }
        if (isset($params['parent']) && $params['parent']){
            $this->db->where_in('parent',$params['parent']);
        }
        if (isset($params['style'])) {
            $this->db->where('style',$params['style']);
        }

        $this->db->order_by('parent,ordering');
        $query = $this->db->get('category');
        $arrCate = $query->result_array();
        $arrReturn = array();
        foreach($arrCate as $cate){
            $arrReturn[$cate['cate_id']] = $cate;
        }
        return $arrReturn;
    }
    /**
    * @author: namtq
    * @todo: Get category for dropbox
    */
    public function recursiveCate($arrCate,$params = array(),$deep = 0) {
        $result = array();
        $params = array_merge(array('parent_id' => 0, 'subStr' => '','excluse' => 0),$params);
        foreach($arrCate as $key => $cate){
            if ($cate['cate_id'] == $params['excluse']){
                unset($arrCate[$key]);
                continue;
            }
            if ($cate['parent'] == $params['parent_id']){
                unset($arrCate[$key]);
                if (!isset($params['deep']) || $params['deep'] < $deep) {
                    $arrChild = $this->recursiveCate($arrCate,array('parent_id' => $cate['cate_id'], 'excluse' => $params['excluse'], 'subStr' => '-- '.$params['subStr']),$deep + 1);
                    if ($arrChild) {
                        $cate['child'] = $arrChild;
                    }    
                }
                $result[] = $cate;
            }
        }
        return $result;
    }
}