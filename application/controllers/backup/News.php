<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News extends CI_Controller{
    function __construct(){
		parent::__construct();
        $this->lang->load('frontend/module');
	}
    public function index(){
        $this->config->set_item("menu_select","home");
        $this->load->model('news_model','news');
        /////// GET TAG BUILD TOP 
        $data['arrTags'] = $this->news->get_tags_hot();
        ////

        $this->load->layout('news/index',$data);
    }
    
    public function support() {
        $this->load->layout('news/support');
    }
    public function preview($id, $token) {
        if (!$this->security->verify_token_post($id,$token)) {
            show_404();
        }
        $id = (int) $id;
        $this->load->model('news_model','news');
        $this->load->model('category_model','category');
        $detail = $this->news->detail($id);
        if (empty($detail)){
            show_404();
        }
        // check valid url
        $url = $this->uri->uri_string();
        if ($url != trim($detail['share_url'],'/') || $detail['lang'] != $this->config->item("lang")){
            redirect_seo(array('url' => $detail['share_url'], 'lang' => $detail['lang']),'location','301');
        }
        $data['row'] = $detail;
        // neu can lay category info
        $cate = $this->category->detail($detail['original_cate']);
        $this->config->set_item("menu_select",array('item_mod' => 'news_cate', 'item_id' => $detail['original_cate']));
        // set data
        $data = array(
            'cate' => $cate,
            'relate' => $this->news->relate(array("cate_id" => $detail['original_cate'], "news_id" => $id,'limit' => 8)),
            'newsDetail' => $detail,
            'tags'=> $this->news->get_tag_by_news(array("news_id" => $id))
        );
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => $cate['name'],"link" => $cate['share_url'])));
        $this->config->set_item("menu_select",array('news_cate' => array($cate['cate_id'], $cate['parent']),'news' => $id));
        $this->load->setData('seo_title',($detail['seo_title']) ? $detail['seo_title'] : $detail['title']);
        $this->load->setData('meta',array(
            'keyword' => ($detail['seo_keyword']) ? $detail['seo_keyword'] : $detail['title'],
            'description' => ($detail['seo_description']) ? $detail['seo_description'] : $detail['description']
        ));
        $this->load->setData('ogMeta',array(
                'og:image' => getimglink($detail['images']),
                'og:title' => $detail['title'],
                'og:description' => $detail['description'],
                'og:url' => current_url())
        );
        // render view
        $this->load->layout('news/detail',$data);
    }
	public function lists($cate_id = 0){
        $limit = 12; $cate_id = intval($cate_id);
        if ($cate_id <= 0){
            show_404();
        }
        // instance
        $page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $offset = ($page - 1) * $limit;
        $this->load->model('news_model','news');
        $this->load->model('category_model','category');
        // GET CATE DETAIL
        $cate = $this->category->detail($cate_id); 

        $url = $this->uri->uri_string();
        if ($url != trim($cate['share_url'],'/') || $cate['lang'] != $this->config->item("lang")){
            redirect_seo(array('url' => $cate['share_url'], 'lang' => $cate['lang']),'location','301');
        }
        // GET PAGINATION
        $param = array('category_id' => $cate_id,"limit" => $limit, "page" => $page, "offset" => $offset);
        $total_row = $this->news->list_total_rule1($param);
        $config['total_rows'] = $total_row;

        if ($cate['type'] != 3 && $config['total_rows'] < 1){       //Không tính list video
            return $this->load->layout('common/noresult');
        }
        $config['per_page'] = $limit;
        $this->load->library('pagination',$config);
        // set data
        $data = array(
            'cate' => $cate,
            'total_row' => $total_row,
            'page' => $page,
            'paging' => $this->pagination->create_links(),
            'arrNews' => $this->news->lists_by_cate_rule1($param),
        );
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => $cate['name'])));
        $this->config->set_item("menu_select",array('news_cate' => array($cate_id,$cate['parent'])));
        $this->load->setData('seo_title',($cate['seo_title']) ? $cate['seo_title'] : $cate['name']);
        $this->load->setData('meta',array(
            'keyword' => ($cate['seo_keyword']) ? $cate['seo_keyword'] : $cate['name'],
            'description' => ($cate['seo_description']) ? $cate['seo_description'] : $cate['description']
        ));
        $this->load->setData('ogMeta',array(
                'og:image' => getimglink($cate['images']),
                'og:title' => ($cate['seo_title']) ? $cate['seo_title'] : $cate['name'],
                'og:description' => ($cate['seo_description']) ? $cate['seo_description'] : $cate['description'],
                'og:url' => current_url())
        );
        switch ($cate['style']) {
            case 3:
                $template = 'news/khoa_hoc';
                break;
            case 2:
                //All cate
                if(!empty($cate_id)){
                    $data['cate_list'] = $this->category->get_category(array('parent' => $cate_id));
                }
                $data['arrVideo'] = array_merge(array($cate), $data['cate_list']);
                //Data video
                if(!empty($data['arrVideo'])){
                    foreach ($data['arrVideo'] as $key => $value) {
                        $param = array('category_id' => $value['cate_id'],"limit" => $limit, "page" => $page, "offset" => $offset);
                        $data['arrVideo'][$key]['list'] = $this->news->lists_by_cate_rule1($param);
                    }
                }

                $template = 'news/video';
                break;
            default:
                $template = 'news/list';
                break;
        }

        // render html
        $this->load->layout($template,$data);
	}
    public function detail($id = ''){
        $now_link = base_url(uri_string());
        if ($now_link == 'https://www.aland.edu.vn/tin-tuc/tuyen-tap-tai-lieu-ielts-simon-writing-moi-nhat-2019-ebook-pdf-37722.html'){
            redirect('tin-tuc/ielts-simon-37722.html','auto',301);
        }


        $id = (int) $id;
        $this->load->model('news_model','news');
        $this->load->model('category_model','category');
        $detail = $this->news->detail($id, array('publish' => 1));
        if (empty($detail)){
            show_404();
        }
        // check valid url
        $url = $this->uri->uri_string();
        if ($url != trim($detail['share_url'],'/')){
            redirect(SITE_URL.$detail['share_url'],'location','301');
        }
        $data['row'] = $detail;
        // neu can lay category info
        $cate = $this->category->detail($detail['original_cate']);
        $this->config->set_item("menu_select",array('item_mod' => 'news_cate', 'item_id' => $detail['original_cate']));
        // set data
        $data = array(
            'id' => $id,
            'target_id' => $id,
            'cate' => $cate,
            'relate' => $this->news->relate(array("cate_id" => $detail['original_cate'], "news_id" => $id,'limit' => 8)),
            'newsDetail' => $detail,
            'tags'=> $this->news->get_tag_by_news(array("news_id" => $id))
        );
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array("name" => $cate['name'],"link" => $cate['share_url'])));
        $this->config->set_item("menu_select",array('news_cate' => array($cate['cate_id'], $cate['parent']),'news' => $id));
        $this->load->setData('seo_title',($detail['seo_title']) ? $detail['seo_title'] : $detail['title']);
        $this->load->setData('noindex', ($detail['noindex']) ? $detail['noindex'] : 0);
        $this->load->setData('meta',array(
            'keyword' => ($detail['seo_keyword']) ? $detail['seo_keyword'] : $detail['title'],
            'description' => ($detail['seo_description']) ? $detail['seo_description'] : $detail['description']
        ));


        $this->load->setData('ogMeta',array(
                'og:image' => ($detail['images_social']) ? getimglink($detail['images_social']) : getimglink($detail['images']),
                'og:title' => ($detail['seo_title']) ? $detail['seo_title'] : $detail['title'] .' - Aland IELTS' ,
//                'og:title' => $detail['title'],
                'og:description' => $detail['description'],
                'og:url' => current_url())
        );
        // update count hit
        $this->news->count_hit($id); 
        // render view
        $this->load->layout('news/detail',$data);
    }
    public function byclass($cate_id = 0){
        $classDetail = $this->permission->getClassIdentity();
        //print_r($this->session->userdata);
        $limit = 10; $cate_id = intval($cate_id);
        $this->load->model('news_model','news');
        $page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $config['total_rows'] = $this->news->count_list_for_class($classDetail['class_id'],$cate_id);
        if ($config['total_rows'] < 1){
            return $this->load->layout('common/noresult');
        }
        $config['per_page'] = $limit;
        $this->load->library('pagination',$config);
        $data['paging'] =  $this->pagination->create_links();
        $data['rows'] = $this->news->list_for_class($classDetail['class_id'],array('limit' => $limit,'offset' => $offset));

        $this->config->set_item("breadcrumb",array(array("name" => 'Bài tập lớp',"link" => SITE_URL .'/chia-se-lop-hoc.html')));
        $this->config->set_item("mod_access",array("name" => "class_news"));
        $this->config->set_item("menu_select",array('item_mod' => 'class_news'));

        $this->load->layout('news/byclass',$data);

    }
    public function tag($tagid,$alias = ''){
        $tagid = (int) $tagid; $limit = 12;
        if ($tagid <= 0){
            show_404();
        }
        // instance
        $page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $this->load->model('news_model','news');

        // GET CATE DETAIL
        $tag_detail = $this->news->get_tag_detail($tagid);
        // GET PAGINATION
        $param = array('tag_id' => $tagid,"limit" => $limit, "page" => $page);
        $config['total_rows'] = $this->news->list_total_news_by_tag($param);
        if ($config['total_rows'] < 1){
            return $this->load->layout('common/noresult');
        }
        $config['per_page'] = $limit;
        $this->load->library('pagination',$config);
        $data['paging'] =  $this->pagination->create_links();
        // GET LIST NEWS
        $data['arrNews'] = $this->news->get_news_by_tag($param);
        // GET DETAIL CATE
        $cate = array('name' => $tag_detail['name']);
        // SET META DATA && SET CONFIG
        $metakey = $tag_detail['name'].' - '.$this->config->item("metakey");
        $metadesc = $this->config->item("metadesc");
        $this->load->setData('title',$metakey);
        $this->load->setData('metakey',$metakey);
        $this->load->setData('metades',$metadesc);
        // set data common
        $this->config->set_item("breadcrumb",array(array('name' => "Tag", 'link' => 'javascript:;'),array("name" => $cate['name'])));
        $this->config->set_item("mod_access",array("name" => "news_cate"));
        //$this->config->set_item("menu_select",array('item_mod' => 'news_cate', 'item_id' => $cate_id));
        $this->load->layout('news/list',$data);
    }
    /**
     * @author: Namtq
     * @desc: comment trong trang chi tiet
     */
    public function comment_action(){
        $proid = (int)$this->input->post("pro_id");
        $content = nl2br(strip_tags($this->input->post("content")));
        $userid = (int)$this->session->userdata("userid");
        $token = strip_tags($this->input->post("token"));
        // check content
        if (!$proid || !$content){
            return $this->output->set_output(json_encode(array("result" => "false", "reason" => "Lỗi dữ liệu đầu vào","error_code" => 1)));
        }
        if (strlen($content) <= 10){
            return $this->output->set_output(json_encode(array("result" => "false", "reason" => "Nội dung nhập quá ngắn","error_code" => 1)));
        }
        // check user login
        if ($userid <= 0) {
            return $this->output->set_output(json_encode(array("result" => "false", "reason" => "Lỗi chưa đăng nhập","error_code" => 2)));
        }
        // protect change proid
        if ($token != md5($this->config->item("encryption_key").$proid)){
            return $this->output->set_output(json_encode(array("result" => "false", "reason" => "Sai token key","error_code" => 3)));
        }
        // protect flood db
        if ($this->session->userdata("last_post") && (time() - $this->session->userdata("last_post") <= 5)){
            return $this->output->set_output(json_encode(array("result" => "false", "reason" => "Post quá nhiều","error_code" => 4)));
        }
        else{
            $this->session->set_userdata("last_post",time());
        }
        $this->load->model("news_model","news");
        $param = array(
            "user_id" => $userid,
            "pro_id" => $proid,
            "content" => $content,
            "status" => 0,
            "type" => 1
        );
        $this->news->insert_comment($param);
        return $this->output->set_output(json_encode(array("result" => "true", "data" => json_encode($param))));
    }
    public function search(){
        $limit = 10;
        $this->load->model('news_model','news');
        $keyword = strip_tags($this->input->get('keyword',true));
        $total = $this->news->search_count($keyword);
        if ($total <= 0){
            $this->load->layout('common/noresult');
            return;
        }
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $this->load->library('pagination',$config);
        $data['keyword'] = $keyword;
        $data['total'] = $total;
        $data['paging'] =  $this->pagination->create_links();
        $data['rows'] = $this->news->search($keyword,$this->pagination->cur_page);
        $this->load->layout('news/search',$data);
    }
    public function reconvert() {
        $result = null;
        if ($news_id = $this->input->post('article_id')) {
            $this->db->where('news_id',(int) $news_id);
            $query = $this->db->get("news");
            $newsDetail = $query->row_array();
            //var_dump($newsDetail); die;
            if (!$newsDetail || !$newsDetail['old_news']) {
                die("Khong ton tai bai viet nay");
            }
            //////////// GET OLD NEWS //////
            $dbv1 = $this->load->database('mshoatoeic_old', TRUE);

            $dbv1->where('news_id',$newsDetail['old_news']);
            $query = $dbv1->get('news');
            $newsDataOld = $query->row_array();

            $arrUpdate = array(
                'detail' => $newsDataOld['detail'],
                'publish_time' => $newsDataOld['date_up']
            );
            $this->db->where('news_id',(int) $news_id);
            $this->db->update('news',$arrUpdate);
            $result = 'ok';
        }

        echo $this->load->view("news/reconvert",array('result' => $result));
    }

    public function error_404()
    {
        if (($this->uri->segment(1) !== '404.html') || ($this->uri->segment(2) !== null)) {
            redirect('/404.html');
        }
        if (is_cli()) {
            $err_404 = $this->load->view('../errors/cli/error_404');
            echo $err_404;
        } else {
            $err_404 = $this->load->view('../errors/html/error_404');
            echo $err_404;
        }
    }

    public function getbranch() //List branch and Offline Place
    {
//        $this->lang->load('backend/setting');
        $this->load->setData('title',$this->lang->line('setting_title'));
        $query = $this->db->get('setting');
        $list_ = $query->row_array();

        $arr_res = array(); //
        if (isset($list_['branch']))    $arr_res['branch'] = $list_['branch'];
        if (isset($list_['offline_place'])) $arr_res['offline_place'] = $list_['offline_place'];
        echo json_encode($arr_res);
    }

    /**
     * Get các noti mới cho người dùng
     * @return |null
     */
    public function getnoti()
    {

        if ($this->permission->hasIdentity()) {
            $profile = $this->permission->getIdentity();
            $id_user = $profile['user_id'];


            $this->load->model('admin/noti_model','noti');
            $list_noti = $this->noti->get_list_noti_client_for_user($id_user);
            $html = '';
            for ($i = 0; $i < count($list_noti); $i++) {
                $mono_detail = $list_noti[$i][0];
//            Array
//            (
//                      [id_noti] => 6
//                      [title] => Test right now
//                      [content] => Content now
//                      [link] =>
//                      [avarta] => banner2.jpg
//                      [creat_time] => 1560410882
//             )
                $avarta = ($mono_detail['avarta']) ? getimglink($mono_detail['avarta'],'size2') : $this->config->item("img").'default_image.jpg';
                $time = date('d/m/y - H:i',$mono_detail['creat_time']);

                $html .=     '<li class="notif unread li_notif_unread" id_noti="'.$mono_detail['id_noti'].'">
                              <a href="'.$mono_detail['link'].'">
                                  <div class="imageblock">
                                      <img src="'.$avarta.'" class="notifimage"  />
                                  </div>
                                  <div class="messageblock">
                                      <div class="message"><strong>'.$mono_detail['title'].'</strong><br> '. $mono_detail['content']. '
                                      </div>
                                      <div class="messageinfo">
                                          <i class="icon-trophy"></i>'.$time.'
                                      </div>
                                  </div>
                              </a>
                          </li>';

            }
            $arr_res = array(
                'status' => 'success',
                'number' => count($list_noti),
                'html' => $html,
            );
            echo json_encode($arr_res);
            return null;
        }
        return null;
    }

    /**
     * Đánh dấu noti đã được người dùng xem
     * @return |null
     */
    public function notiold()
    {
        if ($this->permission->hasIdentity()) {
            $profile = $this->permission->getIdentity();
            $id_user = $profile['user_id'];
            $this->load->model('admin/noti_model', 'noti');
            $list_noti_old = $_REQUEST['list_noti'];
            $list_noti = $this->noti->make_noti_old($list_noti_old, $id_user);
        }
        return null;
    }

    public function test(){
        $this->load->layout('news/test',$data);
    }
}