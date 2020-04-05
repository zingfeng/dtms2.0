<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rss extends CI_Controller{
    public function __construct(){
		parent::__construct();
	}
    public function index()  
    {  
        $this->load->model("rss_model","rss"); 
        $this->load->helper('xml');  
        $this->load->helper('text');  
        
        $limit = 10;
        $data['encoding']           = 'utf-8'; // the encoding
        $data['feed_name']          = base_url(); // your website  
        $data['feed_url']           = site_url("rss"); // the url to your feed  
        $data['page_description']   = $this->config->item("site_title"); // some description  
        $data['page_language']      = 'en-en'; // the language  
        $data['creator_email']      = 'support@imap.edu.vn'; // your email  
        $data['rows']              = $this->rss->recent_post($limit);  
        //header("Content-Type: application/rss+xml"); // important!
        @header('Content-Type:text/xml');
        $this->load->view('rss/news', $data, FALSE);
    }
    public function redirect($type,$id) {
        //var_dump($type,$id); die;
        switch ($type) {
            case 'news':
                $this->db->where('old_news',$id);
                $query = $this->db->get("news");
                $arrData = $query->row_array();
                if ($arrData){
                    redirect($arrData['share_url'],'location','301');
                }
                break;
            case 'test':
                $this->db->where('old_test',$id);
                $query = $this->db->get("test");
                $arrData = $query->row_array();
                if ($arrData){
                    redirect($arrData['share_url'],'location','301');
                }
                break;
            case 'fulltest':
                $id = 10000 + (int) $id;
                $this->db->where('old_test',$id);
                $this->db->where('type',1);
                $query = $this->db->get("test");
                $arrData = $query->row_array();
                if ($arrData){
                    redirect($arrData['share_url'],'location','301');
                }
                break;
            case 'news_cate':
                $this->db->where('old_cate',$id);
                $this->db->where("type",1);
                $query = $this->db->get("category");
                $arrData = $query->row_array();
                if ($arrData){
                    redirect($arrData['share_url'],'location','301');
                }
                break;
            break;
            case 'test_cate':
                $this->db->where('old_cate',$id);
                $this->db->where("type",2);
                $query = $this->db->get("category");
                $arrData = $query->row_array();
                if ($arrData){
                    redirect($arrData['share_url'],'location','301');
                }
                break;
            break;
            default:
                # code...
                break;
        }
        show_404();
    }
    public function sitemap_index() {
                $limit = 30;
        $arrLink = array(
            SITE_URL . '/sitemap/category.xml'
        );
        $this->load->model("news_model","news");
        $this->load->model("test_model","test");
        $count_news = $this->news->count_all_news();
        $limit_page = 200;
        $page = ceil($count_news / $limit_page);
        for ($i=1; $i <= $page; $i++) { 
            $arrLink[] = SITE_URL . '/sitemap/news.xml?page=' . $i;
        }
        $count_test = $this->test->count_all_test();
        $page = ceil($count_news / $limit_page);
        for ($i=1; $i <= $page; $i++) { 
            $arrLink[] = SITE_URL . '/sitemap/test.xml?page=' . $i;
        }
        $data['rows'] = $arrLink;
        $data['times'] = time();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('rss/sitemap_index', $data, false);
    }
    public function sitemap($type) {
        switch ($type) {
            case 'category':
                $this->load->model("category_model","category"); 
                $arrLink = array(
                    SITE_URL,
                    SITE_URL . '/lich-khai-giang/ha-noi',
                    SITE_URL . '/lich-khai-giang/ho-chi-minh',
                    SITE_URL . '/lich-khai-giang/ha-noi',
                );
                //Data test
                $arrCategory = $this->category->get_category();
                foreach ($arrCategory as $key => $category) {
                    $arrLink[] = SITE_URL . $category['share_url'];
                }
                $rows = $arrLink;
                $priority = 0.9;
                break;
            case 'news':
                $this->load->model("news_model","news"); 
                $page = $this->input->get("page");
                $limit = 200;
                $offset = ($page - 1)*$limit;
                $arrNews = $this->news->latest(array('limit' => $limit,'offset' => $offset,'isclass' => 0));
                foreach ($arrNews as $key => $news_detail) {
                    $rows[] = SITE_URL . $news_detail['share_url'];
                }
                $priority = 0.7;
            break;
            case 'test':
                $this->load->model("test_model","test"); 
                $page = $this->input->get("page");
                $limit = 200;
                $offset = ($page - 1)*$limit;
                $arrTest = $this->test->get_latest(array('limit' => $limit,'offset' => $offset, 'isclass' => 0));
                foreach ($arrTest as $key => $test_detail) {
                    $rows[] = SITE_URL . $test_detail['share_url'];
                }
                $priority = 0.7;
            break;
            default:
                
                break;
        }
        if (!$rows) {
            show_404();
        }
        $limit = 30;
        $data['priority'] = $priority;
        $data['rows'] = $rows;
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('rss/sitemap', $data, false);
    }
}