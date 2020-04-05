<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expert extends CI_Controller{
    function __construct(){
		parent::__construct();
        $this->lang->load('frontend/module');
	}
    public function detail($id){
        $id = (int) $id;
        $this->load->model('expert_model','expert');
        $detail = $this->expert->detail($id);
        if (empty($detail)){
            show_404();
        }
        // check valid url
        $url = $this->uri->uri_string();
        if ($url != trim($detail['share_url'],'/')){
            redirect(SITE_URL .  $detail['share_url']);
        }
        // set data
        $data = array(
            'expertDetail' => $detail,
        );
        // set meta and config //
        $this->config->set_item("breadcrumb",array(array('name' => $detail['name'])));
        $this->config->set_item("menu_select",array('expert' => $id));
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
        $this->load->layout('expert/detail',$data);
    }
}