<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends CI_Controller{
    public $module = 'setting';
    function __construct(){
        parent::__construct();
        $this->lang->load('backend/setting');
        $this->load->setData('title',$this->lang->line('setting_title'));
    }
    public function index(){
        if ($this->input->post('submit')){
            return $this->_action('edit');
        }
        $this->load->setArray(array("isForm" => 1));
        $data = $this->_index();
        if (!$data) {
            show_404();
        }
        $this->load->layout('setting/index',$data);
    }
    private function _index() {
        $this->load->model('admin/setting_model','setting');
        // row detail
        $row = $this->setting->detail();
        if (!$row) {
            return array();
        }
        return  array(
            'row' => $row
        );
    }
    public function _action($action, $params = array()) {
        $this->load->model('admin/setting_model','setting');
        $this->load->model('admin/logs_model','logs');
        switch ($action) {
            case 'edit':
                $this->load->library('form_validation');
                $valid = array(
                    array(
                         'field'   => 'email_admin',
                         'label'   => $this->lang->line('setting_email_admin'),
                         'rules'   => 'required'
                    ),
                );
                $this->form_validation->set_rules($valid);
                if ($this->form_validation->run() == true)
                {
                    ////////// GET BRANCH /// 
                    $arrDataBranch = array();
                    if ($arrBranch = $this->input->post('branch')) {
                        foreach ($arrBranch as $key => $branch) {
                            
                            if (is_numeric($branch['id'])) {
                                $arrDataBranch[] = $branch;
                            }
                        }
                    }

                    ////////// GET OFFLINE PLACE ///
                    $arrDataOfflinePlace = array();
                    if ($arrOfflinePlace = $this->input->post('offlineplace')) {
                        foreach ($arrOfflinePlace as $key => $offlineplace) {
                            if (is_numeric($offlineplace['id'])) {
                                $arrDataOfflinePlace[] = $offlineplace;
                            }
                        }
                    }
                    $input['setting'] = array(
                        'email_admin' => $this->input->post('email_admin'),
                        'email_host' => $this->input->post('email_host'),
                        'email_username' => $this->input->post('email_username'),
                        'email_password' => $this->input->post('email_password'),
                        'email_port' => $this->input->post('email_port'),
                        'hotline' => $this->input->post('hotline'),
                        'email_support' => $this->input->post('email_support'),
                        'facebook' => $this->input->post('facebook'),
                        'twitter' => $this->input->post('twitter'),
                        'google' => $this->input->post('google'),
                        'youtube' => $this->input->post('youtube'),
                        'score_table' => $this->input->post('score_table'),
                        'branch' => json_encode($arrDataBranch),
                        'offline_place' => json_encode($arrDataOfflinePlace),
                        'link_speaking' => $this->input->post('link_speaking'),
                        'link_writing' => $this->input->post('link_writing'),

                        'tracking_code_header' => $this->input->post('tracking_code_header',FALSE),
                        'tracking_code_footer' =>  $this->input->post('tracking_code_footer',FALSE),
                        'seo_title' => $this->input->post("seo_title"),
                        'seo_keyword' => $this->input->post("seo_keyword"),
                        'seo_description' => $this->input->post("seo_description")
                    );
                    if ($this->security->verify_token_post(SITE_ID,$this->input->post('token'))) {
                        $result = $this->setting->update($input);    
                    }
                    if ($result) {
                        $html =$this->load->view('setting/index',$this->_index()); 
                    }
                    if ($result) {
                        // log action
                        $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => SITE_ID));
                        // return result
                        return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
                    }
                }
                else{
                    return $this->output->set_output(json_encode(array('status' => 'error','valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
                }
            break;
            default:
                # code...
                break;
        }   
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
    }
}