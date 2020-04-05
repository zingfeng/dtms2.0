<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller{
    function __construct(){
		parent::__construct();
		if (!$this->session->has_userdata('room')) {
			redirect(SITE_URL.'/users/room?redirect_uri='.urlencode(current_url()));
		}
	}
    public function index () {

    }
    public function news($cate_id = 0) {
    	$limit = 12; 
    	// get room id
    	$roomSession = $this->session->userdata('room');
    	$room_id = $roomSession['room_id'];
    	// page
    	$page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $offset = ($page - 1) * $limit;
        // get cate id 
        $cate_id = (int) $cate_id;
        // get total
        $params = array('type' => 1, 'room_id' => $room_id, 'limit' => $limit, 'offset' => $offset, 'cate_id' => $cate_id);

        $this->load->model("room_model","room");
        $this->load->model("news_model","news");
        $total = $this->room->totalSourceByRoom($params);
        // get cate detail
        $cateDetail = ($cate_id > 0) ? $this->news->get_cate_detail($cate_id) : array();

        if ($total > 0) {       	
        	$rows = $this->room->getSourceByRoom($params);
        }
        else {
            return show_404();
        }
        $config = array(
        	'total_rows' => $total,
        	'per_page' => $limit
        );
        $this->load->library('pagination',$config);
        $paging =  $this->pagination->create_links();

        $this->load->setData('title',$roomSession['name']);

        $data = array(
        	'rows' => $rows,
        	'paging' => $paging,
        	'room' => $roomSession,
            'cateDetail' => $cateDetail
        );
        $data['breadcrumb'] = $this->load->view('block/breadcrumb', array(
            'rows' => array(
                array('name' => $roomSession['name'] ,'link' => '#'),
                array('name' => 'Chia sẻ'),
            )
        ), TRUE);
        $this->load->layout('room/news',$data);
    }
    public function test($cate_id = 0) {
    	$limit = 12;
    	// get room id
    	$roomSession = $this->session->userdata('room');
    	$room_id = $roomSession['room_id'];
    	// page
    	$page = (int)$this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $offset = ($page - 1) * $limit;
        $cate_id = (int) $cate_id;
        // get total

        $params = array('type' => 2, 'room_id' => $room_id, 'limit' => $limit, 'offset' => $offset,'cate_id' => $cate_id);
        $this->load->model("room_model","room");
        $this->load->model("test_model","test");
        // get cate detail
        $cateDetail = ($cate_id > 0) ? $this->test->get_cate_detail(array('cate_id' => $cate_id)) : array();


        $total = $this->room->totalSourceByRoom($params);
        if ($total > 0) {
        	// get news detail        	
        	$rows = $this->room->getSourceByRoom($params);
        }
        else {
            return show_404();
        }
        $config = array(
        	'total_rows' => $total,
        	'per_page' => $limit
        );
        $this->load->library('pagination',$config);
        $paging =  $this->pagination->create_links();

        $data = array(
        	'rows' => $rows,
        	'paging' => $paging,
        	'room' => $roomSession,
            'cateDetail' => $cateDetail
        );
        $this->load->setData('title',$roomSession['name']);
        $data['breadcrumb'] = $this->load->view('block/breadcrumb', array(
            'rows' => array(
                array('name' => $roomSession['name'] ,'link' => '#'),
                array('name' => 'Luyện tập'),
            )
        ), TRUE);
        $this->load->layout('room/test',$data);
    }
}