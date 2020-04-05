<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vote extends CI_Controller{
	private $error = array();
    public $option = array();
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/vote');
		$this->load->setData('title',$this->lang->line('vote_title'));
	}
    public function index(){
        $limit = 50;

		$this->load->model('admin/vote_model','vote');
		if ($this->input->post('delete') && $this->input->post('cid') && $this->permission->check_permission_backend(array('function'=>'delete')))
		{
			$this->vote->delete();
            $this->session->set_userdata('success','delete');
		}
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset = ($page - 1) * $limit;
		$data['row'] = $this->vote->lists(array('limit' => $limit+1,'offset' => $offset));
		/** PAGING **/
		$config['total_rows'] = count($data['row']);
  		$config['per_page'] = $limit;
  		$this->load->library('paging',$config);
  		$data['paging'] = $this->paging->create_links();
		unset($data['row'][$limit]);

		$this->load->layout('vote/list',$data);
	}
	public function add($type = 1){
        // load model
		$this->load->model('admin/vote_model','vote');
		if ($this->input->post('vote_submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                $this->vote->insert();
                $this->session->set_userdata('success','add');
                redirect('vote/add');
			}
		}
		$row = set_array('title',array('answer' => array()));
		$data = $this->_form($row);
		$this->load->layout('vote/form',$data);
	}
    public function edit($id = 0){
        $id = intval($id);
        if ($id <= 0){
			show_404();
		}
        //load model
		$this->load->model('admin/vote_model','vote');
		$row = $this->vote->detail($id);
		if (empty($row)){
			show_404();
		}
        if ($this->input->post('vote_submit')){
			$this->_validation();
			if ($this->form_validation->run() == true)
			{
                $this->vote->update($id);
                $this->session->set_userdata('success','edit');
			    redirect(base64_decode($this->input->get("refer")));
			}
		}
        // get category
		$data = $this->_form($row);
        $data['row'] = $row;
		$this->load->layout('vote/form',$data);
	}
    public function updateanswer(){
        $checkajax = $this->permission->check_ajax_backend(array('class' => 'vote','function' => array('add','edit')));
        if ($checkajax !== TRUE) {
            return $this->output->set_output(json_encode($checkajax));
        }
        $name = $this->input->post("name");
        $id = (int) $this->input->post("answerid");
        if ($id == 0 || !$name) {
            $this->output->set_output(json_encode(array('result' => 'error','rev' => 'Data error')));
        }
        $this->load->model('admin/vote_model','vote');
        $input = array(
            'answer_id' => $id,
            'name' => $name
        );
        $this->vote->updateanswer($input);
        $this->output->set_output(json_encode(array('result' => 'success')));
    }
    public function deleteanswer(){
        $checkajax = $this->permission->check_ajax_backend(array('class' => 'vote','function' => array('add','edit')));
        if ($checkajax !== TRUE) {
            return $this->output->set_output(json_encode($checkajax));
        }
        $id = (int) $this->input->post("answerid");
        if ($id == 0) {
            $this->output->set_output(json_encode(array('result' => 'error','rev' => 'Data error')));
        }
        $this->load->model('admin/vote_model','vote');
        $input = array(
            'answer_id' => $id,
        );
        $this->vote->deleteanswer($input);
        $this->output->set_output(json_encode(array('result' => 'success')));
    }
    private function _validation(){
		$this->load->library('form_validation');
		$valid = array(
			array(
                 'field'   => 'title',
                 'label'   => $this->lang->line('vote_name'),
                 'rules'   => 'required'
              )
		);
  		$this->form_validation->set_rules($valid);
	}
    private function _form($row = array()){
        $this->load->helper('form');
        // add static
		$data['title'] = form_input('title',set_value('title',$row['title']));
        $data['answer'] = form_input('answer[]',set_value('answer[]'),'placeholder="'.$this->lang->line("vote_answer").'"');
		$data['submit'] = form_submit('vote_submit',$this->lang->line('common_save'));
        $data['row_answer'] = $row['answer'];
        return $data;
	}
}