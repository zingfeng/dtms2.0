<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Genqr extends CI_Controller{
    function __construct(){
		parent::__construct();
        $this->load->library('ciqrcode');
	}

    public function index(){
        $data = array();
        if ($params['data'] = $this->input->post('link'))
        {
            $params['level'] = $this->input->post('level') ? $this->input->post('link') : 'H';
            $params['size'] = $this->input->post('size') ? $this->input->post('size') : 4;

            $PNG_TEMP_DIR = $this->config->item('path_upload').'qrcode/';
        
            //html PNG location prefix
            $PNG_WEB_DIR = UPLOAD_URL.'qrcode/'; 

            $filename = 'imap_'.md5($params['level'].'|'.$params['size']).'.png';

            //ofcourse we need rights to create temp dir
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);

            if (isset($params)) { 
                //it's very important!
                // user data
                QRcode::png($params['data'], $PNG_TEMP_DIR.$filename, $params['level'], $params['size'], 2);    
            } else {
                //default data
                echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
                QRcode::png('PHP QR Code', $PNG_TEMP_DIR.$filename, $params['level'], $params['size'], 2);    
            }    
                
            $data['qrcode'] = $PNG_WEB_DIR.$filename;
        }
        $this->load->layout('feedback/genqr', $data, FALSE, 'layout_qr');
    }
}