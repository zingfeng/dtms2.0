<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
    }
    public function lists($params = array()){
		$params = array_merge(array('limit' => 30,'offset' => 0),$params);
        if ($params['keyword']){
            $this->db->like('title',$params['keyword']);
        }
        if ($params['cate_id']){
            $this->db->where('original_cate',$params['cate_id']);
        }
        if (isset($params['publish'])) {
            $this->db->where('publish',$params['publish']);
        }
        if (isset($params['convert_status'])) {
            $this->db->where('convert_status',$params['convert_status']);
        }
        $this->db->order_by('n.video_id DESC');
		$this->db->select('n.video_id,n.title,n.vimeo_id,n.publish,n.original_cate');
		$query = $this->db->get('video as n',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function detail($id,$params = array()){
		$this->db->where('n.video_id',$id);
        if ($params['user_id']) {
            $this->db->where('n.user_id',$params['user_id']);
        }
    	$query = $this->db->get('video as n',1);
    	return $query->row_array();
    }
    public function insert($input){
        $profile = $this->permission->getIdentity();
    	$input['video'] = array_merge($input['video'],array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
            'update_time' => time()
        ));
    	$this->db->insert('video',$input['video']);
    	$video_id = (int)$this->db->insert_id();
        if (!$video_id) return false;
        // update share url
        // get original cate
        $orgCateId = $input['video']['original_cate'];

        // insert course to cate
        $arrCateId = ($input['category']) ? array_merge($input['category'],array($orgCateId)) : array($orgCateId);        
        $this->_update_video_to_cate($video_id,$arrCateId);
        return $video_id;
    }
    public function update($video_id,$input){
        // get original cate
        $orgCateId = $input['video']['original_cate'];
        if ($orgCateId > 0){
            $cateorg = $this->cate_detail($orgCateId);
            $cateorg = set_alias_link($cateorg['name']);
        }
        // set more input
        $input['video'] = array_merge($input['video'], array(
            'update_time' => time(),
        ));
        // update video 
        $this->db->where('video_id',$video_id);
        $this->db->update('video',$input['video']);
        $countRow = $this->db->affected_rows();
        // insert course to cate
        if ($orgCateId) {
            $arrCateId = ($input['category']) ? array_merge($input['category'],array($orgCateId)) : array($orgCateId);        
            $this->_update_video_to_cate($video_id,$arrCateId);
        }
        // return result
        return $countRow;
    }
    
    /**
    * @author: namtq
    * @todo: Delete video
    * @param: video_id
    */
    public function delete($cid){
 		$cid = (is_array($cid)) ? $cid : (int) $cid;
        // xoa video 
        $this->db->where_in('video_id',$cid);
        $this->db->delete('video');
        return $this->db->affected_rows();
    }
    //////////////////////////////////// CATEGORY /////////////////////////
    public function cate_detail($id){
        $this->db->where('cate_id',$id);
        $query = $this->db->get('category',1);
        return $query->row_array();
    }

    /**
    * @author: namtq
    * @todo: Insert News to Cate
    * @param: array(id1,id2) 
    */
    private function _update_video_to_cate($video_id, $input) {
        // delete existed data
        $this->db->where('video_id',$video_id);
        $this->db->delete('video_to_cate');
        $input = array_unique($input);
        // insert new data
        foreach ($input as $cate_id) {
            $dataInsert[] = array('video_id' => (int) $video_id, 'cate_id' => (int) $cate_id); 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('video_to_cate',$dataInsert);
        }
    }

    /**
    * @author: namtq
    * @todo: Get all cate of news
    * @param: news_id
    */
    public function get_cate_by_video($video_id){
        $this->db->select('cate_id');
        $this->db->where('video_id',$video_id);
        $query = $this->db->get('video_to_cate');
        return $query->result_array();
    }
}