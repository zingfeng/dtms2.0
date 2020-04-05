<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model {
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
            // $this->db->join('news_to_cate','news_to_cate.news_id = n.news_id');
            // $this->db->where('news_to_cate.cate_id',$params['cate_id']);
            $this->db->where('original_cate',$params['cate_id']);
        }
        if ($params['user_id']) {
            $this->db->where('user_id',$params['user_id']);
        }
        if (isset($params['publish'])) {
            $this->db->where('publish',$params['publish']);
        }
        $this->db->order_by('publish_time DESC, n.news_id DESC'); 
		$this->db->select('n.news_id,n.share_url,n.user_id,n.title,n.publish_time,n.hit,n.publish,n.original_cate');
		$query = $this->db->get('news as n',$params['limit'],$params['offset']);
		return $query->result_array();
    }
    public function detail($id,$params = array()){
    	$this->db->select("n.*,c.name as cate_name");
        $this->db->join("category as c","n.original_cate = c.cate_id","LEFT");
		$this->db->where('n.news_id',$id);
        if ($params['user_id']) {
            $this->db->where('n.user_id',$params['user_id']);
        }
    	$query = $this->db->get('news as n',1);
    	return $query->row_array();
    }
    public function insert($input){
        $profile = $this->permission->getIdentity();
    	$input['news'] = array_merge($input['news'],array(
            'user_id' => $profile['user_id'],
            'create_time' => time(),
            'update_time' => time()
        ));
    	$this->db->insert('news',$input['news']);
    	$news_id = (int)$this->db->insert_id();
        if (!$news_id) return false;        
        // set share_url
        if (trim($input['news']['slug_seo']) != '') {
            $slug = set_alias_link($input['news']['slug_seo']);
        } else {
            $slug = set_alias_link($input['news']['title']);
        }
        $this->db->set("share_url", '/tin-tuc/' . $slug . '-' . $news_id . '.html');
        $this->db->where("news_id",$news_id);
        $this->db->update('news');
        // insert tags
        if ($input['tags']){
            $this->_update_news_to_tags($news_id,$input['tags']);
        }
        // insert news to cate
        $arrCateId = ($input['category']) ? array_merge($input['category'],array($input['news']['original_cate'])) : array($input['news']['original_cate']);        
        $this->_update_news_to_cate($news_id,$arrCateId);
        //update news_to_class
        if ($input['group']) {
            $this->_update_news_to_class($news_id,$input['group']);
        }
        
        // insert other image;
        if ($input['gallery']) {
            $this->_news_gallery($news_id,$input['gallery']);
        }
        return $news_id;
    }
    public function update($news_id,$input){
        // set more input

        // set share_url
        if (trim($input['news']['slug_seo']) != '') {
            $slug = set_alias_link($input['news']['slug_seo']);
        } else {
            $slug = set_alias_link($input['news']['title']);
        }
        $input['news'] = array_merge($input['news'], array(
            'update_time' => time(),
            'share_url' => '/tin-tuc/' . $slug . '-' . $news_id . '.html'
        ));
        // update news 
        $this->db->where('news_id',$news_id);
        $this->db->update('news',$input['news']);
        $countRow = $this->db->affected_rows();
        /** Cap nhat thong tin moi **/
        
        // edit menu
        /* $this->db->where("item_mod","news");
        $this->db->where("item_id",$id);
        $query = $this->db->get("menus");
        $row = $query->result_array();
        foreach ($row as $row){
            $this->db->set("link",$input['share_url']);
            $this->db->where("menu_id",$row['menu_id']);
            $this->db->update("menus");
        }*/
        // insert tags
        
        $this->_update_news_to_tags($news_id,$input['tags']);
        // insert news to cate
        $arrCateId = ($input['category']) ? array_merge($input['category'],array($input['news']['original_cate'])) : array($input['news']['original_cate']);        
        $this->_update_news_to_cate($news_id,$arrCateId);
        //update news_to_class
        $this->_update_news_to_class($news_id,$input['group']);
        // insert other image;
        $this->_news_gallery($news_id,$input['gallery']);
        // return result
        return $countRow;
    }
    /**
    * @author: namtq
    * @todo: Update tag - news
    * @param: array(news_id, input[tag_new,tag_exist] ) 
    */
    private function _update_news_to_tags($news_id, $input){
        // delete old data
        $this->db->where('news_id',$news_id);
        $this->db->delete('news_to_tags');
        if (!$input['tag_new'] && !$input['tag_exist']) {
            return TRUE;
        }
        // insert new data
        $tagsExist = $input['tag_exist'];
        // check add push id tag new
        if ($input['tag_new']) {
            foreach ($input['tag_new'] as $tagName) {
                $this->db->where('name',$tagName);
                $query = $this->db->get('tags');
                $row = $query->row_array();
                // neu tag do da ton tai
                if ($row) {
                    $tagsExist[] = $row['tag_id'];
                }
                // neu tag do chua ton tai
                else {
                    $arrInput = array('name' => $tagName);
                    $this->db->insert('tags',$arrInput);
                    $tagId = (int)$this->db->insert_id();
                    // update share_url
                    if ($tagId) {
                        $this->db->set('share_url','/tag/'.set_alias_link($tagName).'-'.$tagId.'.html');
                        $this->db->where('tag_id',$tagId);
                        $this->db->update('tags');
                        // push id to array
                        $tagsExist[] = $tagId;
                    }
                }
            }
        }
        if ($tagsExist){
            $tagsExist = array_unique($tagsExist);
            $i = 1;
            $input = array();
            foreach ($tagsExist as $tagId) {
                if ($tagId <= 0) continue;
                $input[] = array(
                    'tag_id' => $tagId,
                    'news_id' => $news_id,
                    'ordering' => $i
                );
                $i ++;
            }
            if ($input) {
                $this->db->insert_batch('news_to_tags',$input);
            }
        }

    }
    /**
    * @author: namtq
    * @todo: Insert News to Cate
    * @param: array(id1,id2) 
    */
    private function _update_news_to_cate($news_id, $input) {
        // delete existed data
        $this->db->where('news_id',$news_id);
        $this->db->delete('news_to_cate');
        $input = array_unique($input);
        // insert new data
        foreach ($input as $cate_id) {
            $dataInsert[] = array('news_id' => (int) $news_id, 'cate_id' => (int) $cate_id); 
        } 
        if ($dataInsert) {
            $this->db->insert_batch('news_to_cate',$dataInsert);
        }
    }

    private function _update_news_to_class($news_id, $input) {
        // delete existed data
        $this->db->where('news_id',$news_id);
        $this->db->delete('news_to_class');
        if($input) {
            $input = array_unique($input);
            // insert new data
            foreach ($input as $class_id) {
                $dataInsert[] = array('news_id' => (int) $news_id, 'class_id' => (int) $class_id); 
            } 
            if ($dataInsert) {
                $this->db->insert_batch('news_to_class',$dataInsert);
            }
        }
    }
    /**
    * @author: namtq
    * @todo: Insert Other Image
    * @param: array(news_id, array(image_url)) 
    */
    private function _news_gallery($news_id, $arrImages) {
        $this->db->where("news_id",$news_id);
        $this->db->delete("news_images");
        if (!$arrImages) {
            return TRUE;
        }
        $i = 1;
        foreach ($arrImages as $image) {
            $input[] = array(
                'news_id' => $news_id,
                'images' => $image['url'],
                'caption' => $image['caption'],
                'ordering' => $i
            );
            $i ++;
        }
        if ($input) {
            $this->db->insert_batch('news_images',$input);
        }
        return TRUE;
    }
    
    public function get_tags($params = array()){
        $params = array_merge(array('limit' => 10,'offset' => 0),$params);
        $this->db->select("tag_id, name");
        if (isset($params['name']) && $params['name']) {
            $this->db->like("name",$params['name']);
        }
        $this->db->order_by('tag_id','DESC');
        $query = $this->db->get("tags",$params['limit'],$params['offset']);
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get all tag of news
    * @param: news_id
    */
    public function get_tags_by_news($news_id){
        $this->db->select("t.name,t.tag_id");
        $this->db->where('n.news_id',$news_id);
        $this->db->join("tags as t",'t.tag_id = n.tag_id');
        $query = $this->db->get("news_to_tags as n");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get all cate of news
    * @param: news_id
    */
    public function get_cate_by_news($news_id){
        $this->db->select('cate_id');
        $this->db->where('news_id',$news_id);
        $query = $this->db->get('news_to_cate');
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get all group of news
    * @param: news_id
    */
    public function get_group_by_news($news_id){
        $this->db->select('news_to_class.*,class.name');
        $this->db->where("news_id",$news_id);
        $this->db->join("class","news_to_class.class_id = class.class_id");
        $query = $this->db->get("news_to_class");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Get all images of news
    * @param: news_id
    */
    public function get_images_by_news($news_id){
        $this->db->select("images,caption");
        $this->db->where("news_id",$news_id);
        $this->db->order_by("ordering");
        $query = $this->db->get("news_images");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Delete news
    * @param: news_id
    */
    public function delete($cid){
 		$cid = (is_array($cid)) ? $cid : (int) $cid;
        /** xoa news **/
        $this->db->where_in('news_id',$cid);
        $this->db->delete('news');
        $affected_rows =  $this->db->affected_rows();
        /** xoa news special **/
        $this->db->where_in('item_id',$cid);
        $this->db->where('type','news');
        $this->db->delete('build_top');
        // check affected row
        return $affected_rows;
    }
    /**
    * @author: namtq
    * @todo: Get all news special
    * @param: position
    */
    public function get_buildtop($params = array()) {
        $this->db->select('n.news_id, n.title,n.original_cate');
        $this->db->where('position',$params['position']);
        $this->db->where('b.type','news');
        $this->db->join('news as n','n.news_id = b.item_id');
        $this->db->order_by('b.ordering');
        $query = $this->db->get("build_top as b");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Set order all build top news
    * @param: position
    */
    public function update_buildtop($arrId,$position) {
        if (!$position) {
            return false;
        }
        // delete old data
        $this->db->where('position',$position);
        $this->db->where('type','news');
        $this->db->delete('build_top');
        // insert new data
        $i = 1;
        if ($arrId) {
            $arrId = array_unique($arrId);
            foreach ($arrId as $key => $arrId) {
                $input[] = array(
                    'type' => 'news',
                    'position' => $position,
                    'item_id' => $arrId,
                    'ordering' => $i
                );
                $i++;
            }
            $this->db->insert_batch('build_top',$input);
        }
        return $i;
    }
    /**
    * @author: namtq
    * @todo: Get all tags special
    * @param: position
    */
    public function get_buildtag($params = array()) {
        $this->db->select('n.tag_id, n.name');
        $this->db->where('position',$params['position']);
        $this->db->where('b.type','news_tags');
        $this->db->join('tags as n','n.tag_id = b.item_id');
        $this->db->order_by('b.ordering');
        $query = $this->db->get("build_top as b");
        return $query->result_array();
    }
    /**
    * @author: namtq
    * @todo: Set order all build top tags
    * @param: position
    */
    public function update_buildtag($arrId,$position) {
        if (!$position) {
            return false;
        }
        // delete old data
        $this->db->where('position',$position);
        $this->db->where('type','news_tags');
        $this->db->delete('build_top');
        // insert new data
        $i = 1;
        if ($arrId) {
            $arrId = array_unique($arrId);
            foreach ($arrId as $key => $arrId) {
                $input[] = array(
                    'type' => 'news_tags',
                    'position' => $position,
                    'item_id' => $arrId,
                    'ordering' => $i
                );
                $i++;
            }
            $this->db->insert_batch('build_top',$input);
        }
        return $i;
    }

    /**
     * Hàm check SEO title
     * @param $SEO_title
     * @param $title
     * @return bool
     */
    public function Check_SEO_Title_Exist($SEO_title = '', $title = "")
    {
        $SEO_title = trim($SEO_title);

        if ($SEO_title != '') {
            $this->db->select('news_id, seo_title');
            $this->db->where('seo_title', $SEO_title); // Ko phân biệt chữ hoa chữ thường
            $query = $this->db->get('news');
            if (count($query->result()) > 0) {
                return true;
            }
            return false;
        } else {
            $title = trim($title);
            $this->db->select('news_id, title');
            $this->db->where('title', $title); // Ko phân biệt chữ hoa chữ thường
            $query = $this->db->get('news');
            if (count($query->result()) > 0) {
                return true;
            }
            return false;
        }
    }

    public function Check_SEO_Title_Edit($id_news, $SEO_title = '', $title = "")
    {
        $id_news = (int) $id_news;
        $SEO_title = trim($SEO_title);
        if ($SEO_title != '') {
            $this->db->select('news_id, seo_title');
            $this->db->where('seo_title', $SEO_title); // Ko phân biệt chữ hoa chữ thường
            $this->db->where('news_id != ', $id_news); //
            $query = $this->db->get('news');
            if (count($query->result()) > 0) {
                return true;
            }
            return false;
        } else {
            $title = trim($title);
            $this->db->select('news_id, title');
            $this->db->where('title', $title); // Ko phân biệt chữ hoa chữ thường
            $this->db->where('news_id != ', $id_news); //
            $query = $this->db->get('news');
            if (count($query->result()) > 0) {
                return true;
            }
            return false;
        }

    }
    /**
    * @author: namtq
    * @todo: Get document by class_id from course_class_to_documents
    * @param: array(class_id)
    */
    public function lists_by_class_id($class_id) {
        $this->db->select('n.documents_id,n.share_url,n.title,n.publish_time,n.hit,n.publish,n.original_cate,n.price');
        $this->db->join('documents as n','n.documents_id = t.document_id');
        $this->db->where('t.class_id',$class_id);
        $this->db->order_by('t.ordering');
        $query = $this->db->get('course_class_to_documents as t');
        return $query->result_array();
    }
}