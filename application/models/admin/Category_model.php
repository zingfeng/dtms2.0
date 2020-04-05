<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }    
    //////////////////////////////////// CATEGORY /////////////////////////
    public function cate_detail($id){
    	$this->db->where('cate_id',(int) $id);
    	$query = $this->db->get('category',1);
    	return $query->row_array();
    }
    /**
    * @author: Namtq
    * @todo: Insert category
    */
    public function cate_insert($input){
        $input = array_merge($input, array(
            'create_time' => time(),
            'update_time' => time()
        ));
        // insert data
		$this->db->insert('category',$input);
        $cateid = (int)$this->db->insert_id();
        $arrCateType = $this->config->item("cate_type");
        // update share_url
        $this->db->where("cate_id",$cateid);
        $this->db->set("share_url",'/'.$arrCateType[$input['type']]['code'].'/'.set_alias_link($input['name']).'-c'.$cateid.'.html');
        $this->db->update("category");
        // return 
        return $cateid;
    }
    public function cate_update($cate_id, $input){
        $arrCate = $this->cate_detail($cate_id);
        $arrCateType = $this->config->item("cate_type");
        
    	$input = array_merge($input, array(
            'type' => $arrCate['type'],
            'update_time' => time(),
            'share_url' => '/'.$arrCateType[$arrCate['type']]['code'].'/'.trim(set_alias_link($input['name']),'/').'-c'.$cate_id.'.html'
        ));       
		$this->db->where('cate_id',$cate_id);
		$this->db->update('category',$input);
        $countRow = $this->db->affected_rows();
        // edit menu
        /* if ($countRow) {
            $this->db->where("item_mod","category_cate");
            $this->db->where("item_id",$id);
            $query = $this->db->get("menus");
            $row = $query->result_array();
            foreach ($row as $row){
                $this->db->set("link",$input['share_url']);
                $this->db->where("menu_id",$row['menu_id']);
                $this->db->update("menus");
            }
        }*/
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Delete category
    */
    public function cate_delete($cid = array()){
		if (is_numeric($cid)) {$cid = array($cid);}
        $arrCate = $this->get_category();
        $arrId = $cid;
        foreach ($cid as $key => $id) {
            if ($id <= 0) continue;
            if ($arrCateRev = $this->recursiveCate($arrCate,array('parent_id' => $id))){
                foreach ($arrCateRev as $key => $c) {
                    $arrId[] = (int) $c['cate_id'];
                }
            }   
            
        }
        $countRow = false;
        if ($arrId) {
            $arrId = array_unique($arrId);
            // Delete category_to_cate
            /* $this->db->where_in('cate_id',$arrId);
            $this->db->delete('category_to_cate'); */
            // DELETE CATEGORY
            $this->db->where_in('cate_id',$arrId);
            $this->db->delete('category');
            $countRow = $this->db->affected_rows();
        }
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Get category for dropbox
    */
    public function get_category($params = array()) {
        $this->db->select("cate_id, name, share_url, parent, type, ordering");
        if (isset($params['type']) && $params['type']){
            $this->db->where('type',(int) $params['type']);
        }
        $this->db->order_by('parent,ordering');
        $query = $this->db->get('category');
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get category for dropbox
    */
    public function recursiveCate($arrCate,$params = array()) {
        $result = array();
        $params = array_merge(array('parent_id' => 0, 'subStr' => '','excluse' => 0),$params);
        foreach($arrCate as $key => $cate){
            if ($cate['cate_id'] == $params['excluse']){
                unset($arrCate[$key]);
                continue;
            }
            if ($cate['parent'] == $params['parent_id']){
                unset($arrCate[$key]);
                $cate['name'] = $params['subStr'].$cate['name'];
                $result[$cate['cate_id']] = $cate;
                $rev = $this->recursiveCate($arrCate,array('parent_id' => $cate['cate_id'], 'excluse' => $params['excluse'], 'subStr' => '-- '.$params['subStr']));
                if ($rev) {
                    $result = $result + $rev;
                }
            }
        }
        return $result;
    }
}