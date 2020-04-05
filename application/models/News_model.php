<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    public function list_total_rule1($params){
        $params_default = array("category_id" => 0, "exclude" => array());
        $params = array_merge($params_default,$params);
        $this->db->join('news_to_cate as t','t.news_id = n.news_id', 'left');
        $this->db->where('t.cate_id = '.$params['category_id']);
        $this->db->where('n.publish',1);
        if (!empty($params['exclude'])){
            $this->db->where_not_in("n.news_id",$params['exclude']);
        }
        return $this->db->count_all_results('news as n');
    }
    /**
     * @author: namtq
     * @todo: Danh sach tin theo cate co liston
     * @param: array("category_id" => 0, "limit" => 10, "page" => 1, "exclude" => array()));
     */
    public function lists_by_cate_rule1($params){
        $params_default = array("category_id" => 0, "limit" => 10, "offset" => 0, "exclude" => array());
        $params = array_merge($params_default,$params);
        // $params['limit'] = 100;
        $this->db->select('n.news_id,n.title,n.images,description,n.share_url,n.publish_time,n.params');
        $this->db->where('n.publish',1);
        if (is_array($params['category_id'])) {
            $this->db->where_in("t.cate_id",(int) $params['category_id']);
        }
        else {
            $this->db->where("t.cate_id",(int) $params['category_id']);
        }
        if (!empty($params['exclude'])){
            $this->db->where_not_in("n.news_id",$params['exclude']);
        }
        $this->db->join('news_to_cate as t','t.news_id = n.news_id','left');
        $this->db->order_by('n.publish_time','DESC');
        $query = $this->db->get('news as n',(int) $params['limit'],(int)$params['offset']);
        // var_dump($query->result_array());exit;
		return $query->result_array();
    }
    /**
     * @author: namtq
     * @todo: tong tin theo original cate
     * @param: array("category_id" => 0, "limit" => 10, "page" => 1);
     */
    public function lists_total_rule2($params){
        $params_default = array("category_id" => 0);
        $params = array_merge($params_default,$params);
        $this->db->where('n.publish',1);
        if ($params['category_id'] > 0){
            $this->db->where('original_cate = '.$params['category_id']);
        }

        return $this->db->count_all_results("news");
    }
    /**
     * @author: namtq
     * @todo: Danh sach tin theo original cate
     * @param: array("category_id" => 0, "limit" => 10, "page" => 1);
     */
    public function lists_by_cate_rule2($params){
        $params_default = array("category_id" => 0, "limit" => 10, "offset" => 0);
        $params = array_merge($params_default,$params);

        $this->db->select('n.news_id,n.title,n.images,description,n.share_url,n.publish_time');
        $this->db->where('n.publish',1);
        if (is_array($params['category_id'])) {
            $this->db->where_in("n.original_cate",$params['category_id']);
        }
        else {
            $this->db->where("n.original_cate",(int) $params['category_id']);
        }
        $this->db->order_by('publish_time','DESC');
        $query = $this->db->get("news as n",$params['limit'],$params['offset']);
		return $query->result_array();
    }
    /**
     * @author: namtq
     * @todo: Get detail of news
     * @param: product_id int, option array(publish)
     */
    public function detail($news_id,$option = array()){
        if (isset($option['publish'])) {
            $this->db->where('publish',1);
        }
        $this->db->where('n.news_id',$news_id);
    	$query = $this->db->get('news as n',1);
    	return $query->row_array();
    }
    /**
     * @author: Namtq
     * @desc: Lay tin lien quan cu hon
     * @param: array("cate_id","news_id","limit" => 10)
     */
    public function relate($param = array()){
        $param_default = array("limit" => 10, "news_id" => 0);
        $param = array_merge($param_default,$param);

        $this->db->where("n.original_cate",$param['cate_id']);
        $this->db->where('n.news_id !=',$param["news_id"]);
        $this->db->where('n.publish',1);
		$this->db->from('news as n');
        $this->db->limit($param['limit']);
        $this->db->order_by('publish_time','DESC');
		$this->db->select('n.news_id,n.title,publish_time,share_url,images');
        $query = $this->db->get();
		return $query->result_array();
    }
    /** LIST FOR MEMBER CLASSS **/
    public function list_for_class($role,$option = array()){
        $offset = ($page - 1) * $limit;
        if ($option['cate']){
            $this->db->join("news_to_cate as c","c.news_id = r.news_id");
            $this->db->where_in("c.cate_id",$option['cate']);
        }
        $this->db->distinct();
        $this->db->join("news as n","n.news_id = r.news_id");
        $this->db->select("r.news_id,n.title,n.description,n.images,n.share_url");
        $this->db->where("publish",1);
        $this->db->where("r.class_id",$role);
        $this->db->order_by("r.news_id","DESC");
        $query = $this->db->get("news_to_class as r",$option['limit'],$option['offset']);
        return $query->result_array();
    }
    public function count_list_for_class($role,$option = array()){
        if ($option['cate']){
            $this->db->join("news_to_cate as c","c.news_id = r.news_id");
            $this->db->where_in("c.cate_id",$option['cate']);
        }
        $this->db->join("news as n","n.news_id = r.news_id");
        $this->db->where("publish",1);
        $this->db->where("r.class_id",$role);
        return $this->db->count_all_results("news_to_class as r");
    }
    public function check_news_role($news_id,$role){
        $this->db->where("news_id",$news_id);
        $this->db->where("class_id",$role);
        return $this->db->count_all_results("news_to_class");
    }
    /**
     * @author: Namtq
     * @desc: Lay tin lien quan moi hon
     * @param: array("cate_id","news_id","limit" => 10)
     */
    public function latest($param = array()){
        $param_default = array("limit" => 10,"offset" => 0);
        $param = array_merge($param_default,$param);
        if (isset($param['cate_id'])) {
            $this->db->where("n.original_cate",$param['cate_id']);    
        }
        if (isset($param['news_id'])) {
            $this->db->where('n.news_id >',$param["news_id"]);
        }
        $this->db->where('n.publish',1);
        if (isset($param['isclass'])) {
            $this->db->where("n.isclass",$param['isclass']);
        }
        $this->db->order_by('publish_time','DESC');
		$this->db->select('n.news_id,n.title,publish_time,share_url');
        $query = $this->db->get("news as n",$param['limit'],$param['offset']);
		return $query->result_array();
    }
    public function search_count($keyword){
        $this->db->where('publish',1);
        $this->db->like('title',$keyword);
        return $this->db->count_all_results('news');
    }
    public function search($keyword,$page = 1,$limit = 10){
        $offset = ($page - 1)*$limit;
        $this->db->select('news_id,title,description,images,publish_time');
        $this->db->where('publish',1);
        $this->db->like('title',$keyword);
        $this->db->order_by('publish_time','DESC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get('news');
        return $query->result_array();

    }
    /**
     * @author: Namtq
     * @desc: Lay tag theo bai viet chi tiet
     * @param: array("news_id")
     */
    public function get_tag_by_news($param = array()){
        $this->db->where("n.news_id", (int)$param['news_id']);
        $this->db->join("tags as t","t.tag_id = n.tag_id");
        $this->db->order_by('n.ordering');
        $query = $this->db->get("news_to_tags as n",50);
        return $query->result_array();
    }
    /**
     * @author: Namtq
     * @desc: Chi tiet 1 tag
     * @param: tag_id
     */
    public function get_tag_detail($id){
        $this->db->where("tag_id",$id);
        $query = $this->db->get("tags");
        return $query->row_array();
    }
    /**
     * @author: Namtq
     * @desc: Tong bai viet trong 1 tag
     * @param: array("tag_id")
     */
    public function list_total_news_by_tag($param = array()){
        $this->db->where("t.tag_id",$param['tag_id']);
        $this->db->where("n.publish",1);
        $this->db->join("news as n","n.news_id = t.news_id");
        return $this->db->count_all_results("news_to_tags as t");
    }
    /**
     * @author: Namtq
     * @desc: lists bai viet trong 1 tag
     * @param: array("tag_id")
     */
    public function get_news_by_tag($param = array()){
        $param = array_merge($param,array("limit" => 10, "offset" => 0));
        $this->db->select('n.news_id,n.title,n.images,n.description,n.share_url');
        $this->db->where("t.tag_id",$param['tag_id']);
        $this->db->where("n.publish",1);
        $this->db->order_by("n.publish_time","DESC");
        $this->db->join("news as n","n.news_id = t.news_id");
        $query = $this->db->get("news_to_tags as t",$param['limit'],$param['offset']);
        return $query->result_array();
    }
    /**
     * @author: Namtq
     * @todo: Get news by special
     * @param: array(position,limit,offset)
     */
    public function get_buildtop($params) {
        $params = array_merge(array("limit" => 10, "offset" => 0),$params);
        $this->db->select('n.news_id, title, description, share_url, images');
        $this->db->where('b.position',$params['position']);
        $this->db->where('b.type','news');
        $this->db->join("news as n",'n.news_id = b.item_id');
        $this->db->order_by('b.ordering');
        $query = $this->db->get('build_top as b',$params['limit'],$params['offset']);
        return $query->result_array();
    }
    /**
     * @author: Namtq
     * @desc: update số lần xem
     */
    public function count_hit($id){
        $this->db->where('news_id',$id);
        $this->db->set('hit','hit + 1',FALSE);
        $this->db->update('news');
    }
    public function count_all_news() {
        $this->db->where('isclass',0);
        $this->db->where('publish',1);
        return $this->db->count_all_results('news');
    }
    public function get_tags_hot($params = array()) {
        $params = array_merge(array('limit' => 10,'offset' => 0),$params);
        $this->db->where('b.type','news_tags');
        $this->db->join('tags as t','t.tag_id = b.item_id');
        $query = $this->db->get('build_top as b',$params['limit'],$params['offset']);
        return $query->result_array();
    }
}