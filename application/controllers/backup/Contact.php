<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Contact extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->lang->load('frontend/module');

		$this->config->set_item("breadcrumb", array(array("name" => $this->lang->line("contact_title"))));
		$this->config->set_item("menu_select", array('item_mod' => 'contact', 'item_id' => 0));
	}

    public function index()
    {
        // $esmsToken = $this->config->item("esms");
        // $APIKey = $esmsToken['key'];
        // $SecretKey = $esmsToken['secret'];
        // $YourPhone = "0977643316";
        // $Content = "[Aland Ielts] Đăng ký nhận tư vấn thành công - Đây là tin nhắn ví dụ chị nhé";

        // $SendContent=urlencode($Content);
        // $data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=".$YourPhone."&ApiKey=".$APIKey."&SecretKey=".$SecretKey."&Content=".$SendContent."&Brandname=QCAO_ONLINE&SmsType=2";

        // $curl = curl_init($data);
        // curl_setopt($curl, CURLOPT_FAILONERROR, true);
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($curl);

        // $obj = json_decode($result,true);

        // var_dump($obj);exit;


        // require FCPATH . 'vendor/autoload.php';

		$this->load->helper('form');
		$this->load->helper('captcha');
		if ($this->input->post()) {
			$this->_validation();
			//reset captcha
			$captcha = get_captcha("contact_captcha");
			$captcha = $captcha['image'];


            // Form Type
            $arr_form_type = array(
                'form_dang_ky_test'  => 3,
                'form_dang_ky_tu_van'  => 1,
                'form_dang_ky_offline'  => 4,
                'form_dang_ky_tai_lieu'  => 5,
            );
            $form_type = 1;
            if ($this->input->post('form_type')) {
                if (isset($arr_form_type[$this->input->post('form_type')]))  $form_type = $arr_form_type[$this->input->post('form_type')];
            }

			if ($this->form_validation->run()) {
				$input = array(
					'fullname' => strip_tags($this->input->post('fullname')),
					'email' => strip_tags($this->input->post('email')),
					'phone' => strip_tags($this->input->post('phone')),
					'address' => strip_tags($this->input->post('address')),
					'jobs' => strip_tags($this->input->post('jobs')),
					'content' => strip_tags($this->input->post('content')),
					'create_time' => time(),
                    'type' => $form_type,
				);
				$this->load->model('contact_model', 'contact');
				$contact_id = $this->contact->insert($input);

                ///// GỬI EMAIL VÀ ĐĂNG KÝ VÀO GG SHEET
                ///


                ///
                // Save to gg Sheet
                $this->load->library('user_agent');
                $ip = $this->input->ip_address();

                if ($this->agent->is_mobile())
                {
                    $mobile = 'mobile';
                    $browser = $this->agent->browser() . ' ' . $this->agent->version();
                }else{
                    $mobile = '';
                    $browser = '';
                }
                $arr_form_type_text = array(
                    'form_dang_ky_test'  => 'Đăng ký làm test',
                    'form_dang_ky_tu_van'  => 'Đăng ký tư vấn',
                    'form_dang_ky_offline'  => 'Đăng ký tham gia offline',
                    'form_dang_ky_tai_lieu'  => 'Đăng ký nhận tài liệu',
                );

                $type_fom_text = strip_tags($this->input->post('form_type'));

				if ($contact_id) {
                    $insert_arr = array(
                        '', // STT
                        date('d/m/y - H:i:s'),
                        strip_tags($this->input->post('fullname')),
                        $type_fom_text,
                        strip_tags($this->input->post('phone')),
                        strip_tags($this->input->post("dateofbirth")),
                        '', // địa chỉ
                        '', // khu vực
                        (int)strip_tags($this->input->post("coso")), // cơ sở
                        (int)strip_tags($this->input->post("offline_place")), // địa điểm offline
                        $mobile,
                        $browser,
                        $ip,
                        strip_tags($this->input->post("url")),
                    );
                    $this->pushDataTo_IMAP($insert_arr);

                    // Send Email - Flow 1: register
                    $email = strip_tags($this->input->post('email'));
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmail_dangky($this->input->post('fullname'), $email);
                    }

                    // Send Email - Flow 2: tư vấn
//                    $email_tu_van = 'giang.nguyen@imap.edu.vn';
//                    $body_this = 'Thông tin học viên mới: '. strip_tags($this->input->post('fullname')) ;
//
//                    $phone = strip_tags($this->input->post('phone'));
//                    $email = strip_tags($this->input->post('email'));
//                    $body_this .= '<br>Số điện thoại: '.$phone.'  <a href="tel:'.$phone.'" ><h2>Call</h2></a>' ;
//                    $body_this .= '<br>Email: '.$email ;
//                    $this->sendEmail_from_IMAP(array($email_tu_van),'Mshoatoeic - Email gửi tư vấn viên - Thông tin khách hàng mới',
//                        $body_this );
				}
                //// ==============================

				return $this->output->set_output(json_encode(array('status' => 'success', 'captcha' => $captcha, 'message' => 'Gửi liên hệ thành công')));
			} else {
				return $this->output->set_output(json_encode(array('status' => 'error', 'valid_rule' => $this->form_validation->error_array(), 'captcha' => $captcha)));
			}
		}
		// SET CAPTCHA //
		$captcha = get_captcha("contact_captcha");
		$data['security_code'] = $captcha['image'];
		$this->load->setData('title', $this->lang->line('contact_title'));
		$this->load->layout('contact/form', $data);
	}

    public function form_tai_lieu()
    {
        // require FCPATH . 'vendor/autoload.php';

        $this->load->helper('form');
        $this->load->helper('captcha');
        if ($this->input->post()) {
            $this->_validation();
            //reset captcha
            $captcha = get_captcha("contact_captcha");
            $captcha = $captcha['image'];


            // Form Type
            $arr_form_type = array(
                'form_dang_ky_test'  => 3,
                'form_dang_ky_tu_van'  => 1,
                'form_dang_ky_offline'  => 4,
                'form_dang_ky_tai_lieu'  => 5,
            );
            $form_type = 1;
            if ($this->input->post('form_type')) {
                if (isset($arr_form_type[$this->input->post('form_type')]))  $form_type = $arr_form_type[$this->input->post('form_type')];
            }

//            if ($this->form_validation->run())
            {
                $input = array(
                    'fullname' => strip_tags($this->input->post('fullname')),
                    'email' => strip_tags($this->input->post('email')),
                    'phone' => strip_tags($this->input->post('phone')),
                    'address' => strip_tags($this->input->post('address')),
                    'jobs' => strip_tags($this->input->post('jobs')),
                    'content' => strip_tags($this->input->post('content')),
                    'create_time' => time(),
                    'type' => $form_type,
                );
                $this->load->model('contact_model', 'contact');
                $contact_id = $this->contact->insert($input);

                ///// GỬI EMAIL VÀ ĐĂNG KÝ VÀO GG SHEET
                // Save to gg Sheet
                $this->load->library('user_agent');
                $ip = $this->input->ip_address();

                if ($this->agent->is_mobile())
                {
                    $mobile = 'mobile';
                    $browser = $this->agent->browser() . ' ' . $this->agent->version();
                }else{
                    $mobile = '';
                    $browser = '';
                }
                $arr_form_type_text = array(
                    'form_dang_ky_test'  => 'Đăng ký làm test',
                    'form_dang_ky_tu_van'  => 'Đăng ký tư vấn',
                    'form_dang_ky_offline'  => 'Đăng ký tham gia offline',
                    'form_dang_ky_tai_lieu'  => 'Đăng ký nhận tài liệu',
                );

                $type_fom_text = strip_tags($this->input->post('form_type'));

                if ($contact_id){
                    $insert_arr = array(
                        '', // STT
                        date('d/m/y - H:i:s'),
                        strip_tags($this->input->post('fullname')),
                        $type_fom_text,
                        strip_tags($this->input->post('phone')),
                        strip_tags($this->input->post("dateofbirth")),
                        '', // địa chỉ
                        '', // khu vực
                        (int)strip_tags($this->input->post("coso")), // cơ sở
                        (int)strip_tags($this->input->post("offline_place")), // địa điểm offline
                        $mobile,
                        $browser,
                        $ip,
                        strip_tags($this->input->post("url")),
                    );
                    $this->pushDataTo_IMAP($insert_arr);

                    // Send Email - Flow 1: register
                    $email = strip_tags($this->input->post('email'));
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->sendEmail_dangky($this->input->post('fullname'), $email);

//                        $body_this = 'Cảm ơn bạn đã đăng ký, tư vấn viên của chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất ';
//                        $this->sendEmail_from_IMAP(array($email),'Aland xác nhận đăng ký của bạn',
//                            $body_this );
                    }
                    // Send Email - Flow 2: tư vấn
//                    $email_tu_van = 'giang.nguyen@imap.edu.vn';
//                    $body_this = 'Thông tin học viên mới: '. strip_tags($this->input->post('fullname')) ;
//
//                    $phone = strip_tags($this->input->post('phone'));
//                    $email = strip_tags($this->input->post('email'));
//                    $body_this .= '<br>Số điện thoại: '.$phone.'  <a href="tel:'.$phone.'" ><h2>Call</h2></a>' ;
//                    $body_this .= '<br>Email: '.$email ;
//                    $this->sendEmail_from_IMAP(array($email_tu_van),'Mshoatoeic - Email gửi tư vấn viên - Thông tin khách hàng mới',
//                        $body_this );
                }
                //// ==============================
                ///
                return $this->output->set_output(json_encode(array('status' => 'success', 'captcha' => $captcha, 'message' => 'Gửi liên hệ thành công')));
//            }
//            else {
//                return $this->output->set_output(json_encode(array('status' => 'error', 'valid_rule' => $this->form_validation->error_array(), 'captcha' => $captcha)));
            }
        }
        // SET CAPTCHA //
        $captcha = get_captcha("contact_captcha");
        $data['security_code'] = $captcha['image'];
        $this->load->setData('title', $this->lang->line('contact_title'));
        $this->load->layout('contact/form2', $data);
    }

	public function success() {
		$data['title'] = $this->lang->line('contact_success_title');
		$data['result'] = $this->lang->line('contact_success');
		$this->load->layout('contact/result', $data);
	}
	private function _validation() {
		$this->load->library('form_validation');
		$valid = array(
			array(
				'field' => 'fullname',
				'label' => 'Họ và tên',
                'rules' => 'required'
			),
//            array(
//                'field' => 'email',
//                'label' => 'Email',
//                'rules' => 'required'
//            ),
			array(
				'field' => 'phone',
				'label' => 'Số diện thoại',
                'rules' => 'required'
			),
//            array(
//                'field' => 'address',
//                'label' => 'Địa chỉ',
//                'rules' => 'required'
//            ),
//            array(
//                'field' => 'content',
//                'label' => 'Lời nhắn',
//                'rules' => 'required'
//            ),
			array(
				'field' => 'captcha',
				'label' => 'Mã bảo mật',
                'rules' => 'required|matches_str[' . $this->session->userdata('contact_captcha') . ']'
			),

		);
		$this->form_validation->set_rules($valid);
	}

	public function tuvan() {
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$valid = array(
				array(
					'field' => 'fullname',
					'label' => 'Họ và tên',
                    'rules' => 'required'
				),
				array(
					'field' => 'phone',
					'label' => 'Số diện thoại',
                    'rules' => 'required'
				),
//                array(
//                    'field' => 'email',
//                    'label' => 'Email',
//                    'rules' => 'required|valid_email'
//                ),
            );

            // Form Type
            $arr_form_type = array(
                        'form_dang_ky_test'  => 3,
                        'form_dang_ky_tu_van'  => 1,
                        'form_dang_ky_offline'  => 4,
                        'form_dang_ky_tai_lieu'  => 5,
			);
            $form_type = 2;
            if ($this->input->post('form_type')) {
                if (isset($arr_form_type[$this->input->post('form_type')]))  $form_type = $arr_form_type[$this->input->post('form_type')];
            }


			$this->form_validation->set_rules($valid);
			$csrf = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash(),
			);

			if ($this->form_validation->run()) {
				$input = array(
					'fullname' => strip_tags($this->input->post('fullname')),
					'phone' => strip_tags($this->input->post('phone')),
					'email' => strip_tags($this->input->post('email')),
                    'create_time' => time(),
                    'type' => $form_type,
                    'branch' => (int)strip_tags($this->input->post("coso")),
                    'offline_place' => (int)strip_tags($this->input->post("offline_place")),
                    'dateofbirth' => strip_tags($this->input->post("dateofbirth")),
                    'live_area' => strip_tags($this->input->post("living_area")),
                    'url' => strip_tags($this->input->post("url")),
				);
				$this->load->model('contact_model', 'contact');
                $contact_id = $this->contact->insert($input);

                // Save to gg Sheet
                $this->load->library('user_agent');
                $ip = $this->input->ip_address();

                if ($this->agent->is_mobile())
                {
                    $mobile = 'mobile';
                    $browser = $this->agent->browser() . ' ' . $this->agent->version();
                }else{
                    $mobile = '';
                    $browser = '';
                }
                $arr_form_type_text = array(
                    'form_dang_ky_test'  => 'Đăng ký làm test',
                    'form_dang_ky_tu_van'  => 'Đăng ký tư vấn',
                    'form_dang_ky_offline'  => 'Đăng ký tham gia offline',
                    'form_dang_ky_tai_lieu'  => 'Đăng ký nhận tài liệu',
                );

                $type_fom_text = strip_tags($this->input->post('form_type'));
                if ($this->input->post('form_type')) {
                    if (isset($arr_form_type_text[$this->input->post('form_type')]))
                    {
                        $type_fom_text = $arr_form_type_text[$this->input->post('form_type')];
                    }
                }

                $query = $this->db->get('setting');
                $arrSetting =  $query->row_array();

                $arrBranchData = array();
                $arrBranch = json_decode($arrSetting['branch'],TRUE);
                foreach ($arrBranch as $key => $branch) {
                    $arrBranchData[$branch['id']] = $branch['name'];
                }

                $arrOfflinePlaceData = array();
                $arrOfflinePlace = json_decode($arrSetting['offline_place'], TRUE);
                if ( (is_array($arrOfflinePlace) )&& count($arrOfflinePlace) > 0){
                    foreach ($arrOfflinePlace as $key => $offline_place) {
                        $arrOfflinePlaceData[$offline_place['id']] = $offline_place['name'];
                    }
                }

                $coso_id  =  (int)strip_tags($this->input->post("coso"));
                $offline_place_id  =  (int)strip_tags($this->input->post("offline_place"));

                if (isset($arrBranchData[$coso_id])){
                    $arrBranchData_this = $arrBranchData[$coso_id];
                }else{
                    $arrBranchData_this = '';
                }

                if (isset($arrOfflinePlaceData[$offline_place_id])){
                    $arrOfflinePlaceData_this = $arrOfflinePlaceData[$offline_place_id];
                }else{
                    $arrOfflinePlaceData_this = '';
                }


                $insert_arr = array(
                    '', // STT
                    date('d/m/y - H:i:s'),
                    strip_tags($this->input->post('fullname')),
                    $type_fom_text,
                    strip_tags($this->input->post('phone')),
                    strip_tags($this->input->post('email')),
                    strip_tags($this->input->post("dateofbirth")),
                    '', // địa chỉ
                    '', // khu vực
                    $arrBranchData_this, // cơ sở
                    $arrOfflinePlaceData_this, // địa điểm offline
                    $mobile,
                    $browser,
                    $ip,
                    strip_tags($this->input->post("url")),
                );
                $result = $this->pushDataTo_IMAP($insert_arr);

                $email = strip_tags($this->input->post('email'));
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->sendEmail_dangky($this->input->post('fullname'), $email);
                }


                $output = array('status' => 'success', 'message' => 'Đăng ký tư vấn thành công');
				$result = json_encode($output);
				echo $result;
				exit;
			} else {
				echo json_encode(array('status' => 'error', 'message' => $this->form_validation->error_array(), 'csrf_hash' => $csrf['hash']));
				exit;
			}
		}
	}

	public function _getClient() {
		$client = new Google_Client();
		$client->setApplicationName('Google Sheets API PHP Quickstart');
		$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
		$client->setAuthConfig(BASEDIR . '/vendor/credentials.json');
		$client->setAccessType('online');
		$client->setPrompt('select_account consent');
		// Load previously authorized token from a file, if it exists.
		$tokenPath = 'token.json';
		if (file_exists($tokenPath)) {
			$accessToken = json_decode(file_get_contents($tokenPath), true);
			$client->setAccessToken($accessToken);
		}
		// If there is no previous token or it's expired.
		if ($client->isAccessTokenExpired()) {
			// Refresh the token if possible, else fetch a new one.
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
				// Request authorization from the user.
				$authUrl = $client->createAuthUrl();
				printf('Có lỗi xảy ra');
				printf('Truy cập link sau: ' . ":\n%s\n", $authUrl);
				print 'Get mã code và set vào config.php: ';
				// $authCode = trim(fgets(STDIN));
				$authCode = $this->config->item("authCode");
				// Exchange authorization code for an access token.
				$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
				$client->setAccessToken($accessToken);
				// Check to see if there was an error.
				if (array_key_exists('error', $accessToken)) {
					throw new Exception(join(', ', $accessToken));
				}
			}
			// Save the token to a file.
			if (!file_exists(dirname($tokenPath))) {
				mkdir(dirname($tokenPath), 0700, true);
			}
			file_put_contents($tokenPath, json_encode($client->getAccessToken()));
		}
		return $client;
	}

	// New function - đã tách process
    private function pushDataTo_IMAP($array_insert){

        $param = array(
            'token' => 'KY1ti8eSIMRCdqOq29B1',
            'snippet' => 'aland',
            'row' => json_encode($array_insert),
        );
        $url = 'https://thor.daybreak.icu/api/spreadsheet';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($param));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    // New function - đã tách process
//    public function sendEmail_from_IMAP($arr_receiver,$email_title, $email_body, $name_sender = "Mshoatoeic")
//    {
//        $param_post = array(
//            'snippet'  => 'thanhdat.imap',
//            'token' => 'KY1ti8eSIMRCdqOq29B1',
//            'html'  => $email_body,
//            'name_sender'  => $name_sender,
//            'title'  => $email_title,
//            'email_receiver' => $arr_receiver,
//        );
//
//        // Run it
//        $this->send_email_curl($param_post);
//    }

    public function test_email(){

        $email = strip_tags('thanhdat.finance@gmail.com');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'true';
            $this->sendEmail_dangky($this->input->post('fullname'), $email);

//                        $body_this = 'Cảm ơn bạn đã đăng ký, tư vấn viên của chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất ';
//                        $this->sendEmail_from_IMAP(array($email),'Aland xác nhận đăng ký của bạn',
//                            $body_this );
        }

//	    $this->sendEmail_dangky('Đạt', 'thanhdat.finance@gmail.com');
    }

    public function sendEmail_dangky($fullname, $email_receive){
        $content = $this->getContentEmail($fullname,$email_receive);
        $title = 'ALAND XÁC NHẬN ĐĂNG KÝ TỪ '. mb_strtoupper($fullname);
        return $this->sendEmail_from_IMAP($email_receive,$title, $content, "Aland");
    }

    function getContentEmail($name, $email_receive = ''){
        $content_raw = '
        <p style="font-size:24px; color:rgb(0,212,0);">Chúc mừng ' .$name.' đã đăng ký thành công!</p>
    <br>
    <p style="font-size:24px;">Thông tin của bạn đang được Aland xử lý. Trung tâm sẽ sớm liên hệ với bạn qua email hoặc điện thoại để tư vấn trực tiếp cho bạn trong thời gian sớm nhất (thông thường từ 1-2 ngày làm việc). Bạn vui lòng thường xuyên kiểm tra email (trong mục Inbox hoặc Spam) để cập nhật các thông tin liên quan đến khoá học.
    </p>
 <p style="font-size:24px;">
 Trường hợp không nhận được/chậm nhận được email phản hồi (do lỗi mạng hoặc lỗi hệ thống), bạn vui lòng liên hệ trực tiếp với chúng tôi theo đường dây nóng: 0969 264 966 hoặc đến trực tiếp các cơ sở của ALAND nha!
</p>
<br><hr style="color:grey">
<img style="width:100%" src="https://www.aland.edu.vn/uploads/images/userfiles/2019/06/he-sinh-thai-cover.jpg" alt="Aland - Trung Tâm Luyện Thi IELTS, Học IELTS">
<p style="font-size:20px;">Aland – Trung Tâm Luyện Thi IELTS, Học IELTS</p>
<p style="font-size:20px;">Website: <a href="https://www.aland.edu.vn/" target="_blank"> https://www.aland.edu.vn/ </a></p>
';

//        $content = str_replace('[Last Name]',$name,$content_raw);
        return $content_raw;

    }


    public function sendEmail_from_IMAP($arr_receiver,$email_title, $email_body, $name_sender = "Aland")
    {
        $CI = &get_instance();
        // load library
        $config = array(
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'thanhdat.imap@gmail.com',
            'smtp_pass' => 'cacc842679315',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'protocol' => 'smtp',
            'newline'   =>"\r\n",
        );
        $CI->load->library('email',$config);
        $CI->email->clear();
        $CI->email->from($config['smtp_user'], $name_sender);
        $CI->email->to($arr_receiver);
        $CI->email->subject($email_title);
        $CI->email->message($email_body);
        $CI->email->send(TRUE);
//        var_dump($this->email->print_debugger(array('headers')));
        //echo $CI->email->print_debugger();
        /* if ($CI->email->send(TRUE)) {
            return TRUE;
        } else {
            if (ENVIRONMENT == 'development') {
                $CI->email->print_debugger(array('headers'));
            }
            return FALSE;
        }*/

    }

    function send_email_curl($param){
        $url = 'https://thor.daybreak.icu/api/email';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($param));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
