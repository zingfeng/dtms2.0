<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class News extends CI_Controller {
	public $module = 'news';
	private $_news_type = 1;
	function __construct() {
		parent::__construct();
		$this->lang->load('backend/news');
		$this->load->setData('title', $this->lang->line('news_title'));

	}
	/*
			public function layout_form() {
				////
		        $this->load->layout('news/layout_form',$data);
	*/
	public function index() {
		if ($this->input->post('delete')) {
			return $this->_action('delete');
		}
		$this->load->setArray(array("isLists" => 1));
		$data = $this->_index();
		// render view
		$this->load->layout('news/list', $data);
	}
	public function add() {
		// load model
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		/*
			if (!$type) {
				return redirect(SITE_URL . '/news/layout_form');
		*/
		$this->load->setArray(array("isForm" => 1));
		// get data
		$data = $this->_add($type);
		$this->load->layout('news/form', $data);
	}
	public function edit($id = 0) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('edit', array('id' => $id));
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('news/form', $data);
	}
	public function copy($id = 0) {
		$id = (int) $id;
		if ($this->input->post('submit')) {
			return $this->_action('add');
		}
		$this->load->setArray(array("isForm" => 1));
		$data = $this->_edit($id);
		if (!$data) {
			show_404();
		}
		$this->load->layout('news/form', $data);
	}
	public function buildtop($position = '') {
		if ($this->input->post('order')) {
			return $this->_action('buildtop');
		}
		$this->load->setArray(array("isLists" => 1, "isForm" => 1));
		$data = $this->_buildtop($position);
		if (!$data) {
			show_404();
		}
		$this->load->layout('news/buildtop', $data);
	}
	public function buildtag($position = '') {
		if ($this->input->post('order')) {
			return $this->_action('buildtag');
		}
		$this->load->setArray(array("isLists" => 1, "isForm" => 1));
		$data = $this->_buildtag($position);
		if (!$data) {
			show_404();
		}
		$this->load->layout('news/buildtag', $data);
	}
	/**
	 * @author: namtq
	 * @todo: Readmore list
	 * @param: array(page, cate, keyword)
	 */
	public function suggest_news() {
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/category_model', 'category');
		$limit = 30;
		$page = (int) ($this->input->get('page') >= 1) ? $this->input->get('page') : 1;
		$cate_id = (int) $this->input->get('cate_id');
		$offset = ($page - 1) * $limit;
		$keyword = trim($this->input->get('keyword'));

		$params = array('limit' => $limit + 1, 'offset' => $offset, 'cate_id' => $cate_id, 'keyword' => $keyword);
		// get array news
		$rows = $this->news->lists($params);
		$showMore = 0;
		if (count($rows) > $limit) {
			$showMore = 1;
			// delete last row
			unset($rows[$limit]);
		}
		if ($rows) {
			// get all cate to check original cate
			// get array cate recursive
			$arrCate = $this->category->get_category(array('type' => $this->_news_type));
			$arrCate = $this->category->recursiveCate($arrCate);
			foreach ($rows as $key => $row) {
				$rows[$key]['original_cate'] = $arrCate[$row['original_cate']]['name'];
			}
		}
		$data = array(
			'rows' => $rows,
			'showMore' => $showMore,
			'cate_id' => $cate_id,
			'keyword' => $keyword,
			'page' => $page,
		);
		if ($this->input->get('dataType') == 'html') {
			$data = $this->load->view('news/suggest_news', $data);
		}
		return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
	}

	public function suggest_documents(){
		$keyword = $this->input->get("term");
        $page = (int) $this->input->get('page');
        $page = ($page > 1) ? $page : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->load->model('admin/news_model','news');
        $params = array('limit' => $limit + 1,'keyword' => $keyword,'offset' => $offset);
        $arrTest = $this->news->lists($params);
        $data = $option = array();
        if (count($arrTest) > $limit) {
            $option['nextpage'] = true;
            unset($arrTest[$limit]);
        }
        foreach ($arrTest as $key => $news) {
            $data[] = array('id' => $news['news_id'], 'text' => $news['title'],'item_id' => $news['news_id']);
        }
        return $this->output->set_output(json_encode(array('status' => 'success','data' => $data,'option' => $option)));
	}

	/**
	 * @author: namtq
	 * @todo: Readmore list
	 * @param: array(page, cate, keyword)
	 */
	public function suggest_tags() {
		$this->load->model('admin/news_model', 'news');
		$limit = 30;
		$page = (int) ($this->input->get('page') >= 1) ? $this->input->get('page') : 1;
		$offset = ($page - 1) * $limit;
		$keyword = trim($this->input->get('keyword'));

		$params = array('limit' => $limit + 1, 'offset' => $offset, 'name' => $keyword);
		// get array news
		$rows = $this->news->get_tags($params);
		$showMore = 0;
		if (count($rows) > $limit) {
			$showMore = 1;
			// delete last row
			unset($rows[$limit]);
		}

		$data = array(
			'rows' => $rows,
			'showMore' => $showMore,
			'keyword' => $keyword,
			'page' => $page,
		);
		if ($this->input->get('dataType') == 'html') {
			$data = $this->load->view('news/suggest_tags', $data);
		}
		return $this->output->set_output(json_encode(array('status' => 'success', 'data' => $data)));
	}
	public function _buildtop($position) {
		$limit = 30;
		$configBlock = $this->config->item('block');
		$configBlock = $configBlock['news_special']['position'];
		$arrPosition = array_keys($configBlock);
		if (!in_array($position, $arrPosition)) {
			$position = $arrPosition[0];
		}
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/category_model', 'category');
		// get latest news
		$latest = $this->news->lists(array('limit' => $limit + 1));
		$showMore = (count($latest) > $limit) ? 1 : 0;
		unset($latest[$limit]);
		// get news special
		$rows = $this->news->get_buildtop(array('position' => $position));
		// get array cate recursive
		$arrCate = $this->category->get_category(array('type' => $this->_news_type));
		$arrCate = $this->category->recursiveCate($arrCate);
		// return
		return array('rows' => $rows, 'latest' => $latest, 'arrCate' => $arrCate, 'position' => $position, 'showMore' => $showMore, 'arrPosition' => $configBlock);
	}
	public function _buildtag($position) {
		$limit = 30;
		$configBlock = $this->config->item('block');
		$configBlock = $configBlock['news_tags']['position'];
		$arrPosition = array_keys($configBlock);
		if (!in_array($position, $arrPosition)) {
			$position = $arrPosition[0];
		}
		$this->load->model('admin/news_model', 'news');
		// get latest news
		$latest = $this->news->get_tags(array('limit' => $limit + 1));
		$showMore = (count($latest) > $limit) ? 1 : 0;
		unset($latest[$limit]);
		// get tags special
		$rows = $this->news->get_buildtag(array('position' => $position));
		// return
		return array('rows' => $rows, 'latest' => $latest, 'arrPosition' => $configBlock, 'showMore' => $showMore, 'position' => $position);
	}
	private function _index() {
		$limit = $this->config->item("limit_item");
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/category_model', 'category');
		// get level of user
		$page = (int) $this->input->get('page');
		$offset = ($page > 1) ? ($page - 1) * $limit : 0;
		$params = array('limit' => $limit + 1, 'offset' => $offset);
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}
		////////////////// FITER /////////
		$params_filter = array_filter(array(
			'keyword' => $this->input->get('title'),
			'publish' => $this->input->get('publish'),
			'cate_id' => $this->input->get('cate_id'),
		), 'filter_item');
		$params = array_merge($params, $params_filter);
		// get data
		$rows = $this->news->lists($params);
		$arrUserId = array();
		foreach ($rows as $key => $row) {
			$arrUserId[] = $row['user_id'];
		}
		$arrUserId = array_unique($arrUserId);
		$this->load->model('admin/users_model', 'users');
		$arrUserData = $this->users->get_users_by_id($arrUserId);

		$arrUsers = array();
		if (!empty($arrUserData)) {
			foreach ($arrUserData as $key => $user) {
				$arrUsers[$user['member_id']] = $user;
			}
		}
		/** PAGING **/
		$config['total_rows'] = count($rows);
		$config['per_page'] = $limit;
		$this->load->library('paging', $config);
		$paging = $this->paging->create_links();
		unset($rows[$limit]);
		// arrCate
		$arrCate = $this->category->get_category(array('type' => $this->_news_type));
		$arrCate = $this->category->recursiveCate($arrCate);

		// set limit
		$this->load->setArray(array("isLists" => 1));
		// set data
		return array('rows' => $rows, 'paging' => $paging, 'arrCate' => $arrCate, 'filter' => $params_filter, 'arrUsers' => $arrUsers);
	}
	private function _add() {
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/category_model', 'category');
		$this->load->model('admin/group_model', 'group');
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_news_type));
		$arrCateRev = $this->category->recursiveCate($arrCate);
		$arrGroup = $this->group->lists();
		return array(
			'arrCate' => $arrCateRev,
			'row' => array(),
			'arrGroup' => $arrGroup,
		);
	}
	private function _edit($id) {
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/group_model', 'group');
		$this->load->model('admin/category_model', 'category');
		// row detail
		$userLevel = $this->permission->get_level_user();
		if ($userLevel == 1) {
			$params['user_id'] = $this->permission->get_user_id();
		}

		$row = $this->news->detail($id, $params);
		if (!$row) {
			return array();
		}
		$row['params'] = json_decode($row['params'], TRUE);
		// get array cate
		$arrCate = $this->category->get_category(array('type' => $this->_news_type));
		$arrCate = $this->category->recursiveCate($arrCate);
		// get news_to_cate
		$arrCateNews = $this->news->get_cate_by_news($id);
		$arrCateId = array();
		foreach ($arrCateNews as $key => $cate) {
			$arrCateId[] = $cate['cate_id'];
		}
		// get news_to_tag
		$arrTag = $this->news->get_tags_by_news($id);
		// get news_image
		$arrImages = $this->news->get_images_by_news($id);
		//get news to class
		$arrGroupByNews = $this->news->get_group_by_news($id);
		$arrGroupId = array();
		foreach ($arrGroupByNews as $key => $group) {
			$arrGroupId[] = $group['class_id'];
		}

		$arrGroup = $this->group->lists();
		return array(
			'arrCate' => $arrCate,
			'arrCateId' => $arrCateId,
			'arrTag' => $arrTag,
			'arrImages' => $arrImages,
			'arrGroupId' => $arrGroupId,
			'arrGroup' => $arrGroup,
			'row' => $row,
		);
	}

	public function suggest_tag() {
		$name = trim($this->input->get("term"));
		$this->load->model('admin/news_model', 'news');
		$rows = $this->news->get_tags(array('name' => $name));
		$result = array();
		foreach ($rows as $row) {
			$result[] = '{"id":"' . $row['tag_id'] . '","label":"' . $row['name'] . '","value":"' . $row['name'] . '"}';
		}
		$this->output->set_output("[" . implode(',', $result) . "]");
	}

	public function _action($action, $params = array()) {
		$this->load->model('admin/news_model', 'news');
		$this->load->model('admin/logs_model', 'logs');
		switch ($action) {
		case 'add':
		case 'edit':
			$this->load->library('form_validation');
			$valid = array(
				array(
					'field' => 'title',
					'label' => $this->lang->line('news_name'),
					'rules' => 'required',
				),
				array(
					'field' => 'original_cate',
					'label' => $this->lang->line('news_original_cate'),
					'rules' => 'is_natural_no_zero',
				),
			);
			$this->form_validation->set_rules($valid);
			if ($this->form_validation->run() == true) {
				$inputParams = array();
				if ($proParams = $this->input->post('params')) {
					foreach ($proParams as $key => $value) {
						if ($value['key'] && $value['value']) {
							$value['key'] = strtolower($value['key']);
							$inputParams[$value['key']] = $value['value'];
						}

					}
				}
				$inputParams = json_encode($inputParams);
				$input['news'] = array(
					'title' => trim($this->input->post('title')),
					'detail' => $this->input->post('detail'),
					'publish' => intval($this->input->post('publish')),
					'original_cate' => intval($this->input->post("original_cate")),
					'publish_time' => (int) convert_datetime($this->input->post('publish_time')),
					'description' => $this->input->post('description'),
					'images' => $this->input->post('images'),
					'images_social' => $this->input->post('images_social'),
					'theme' => $this->input->post('theme'),
					'seo_title' => $this->input->post("seo_title"),
					'seo_keyword' => $this->input->post("seo_keyword"),
					'seo_description' => $this->input->post("seo_description"),
                        'slug_seo' => $this->input->post("slug_seo"),
					'score' => intval($this->input->post('score')),
					'noindex' => intval($this->input->post('noindex')),
					'extra' => $this->input->post('extra'),
					'params' => $inputParams,
				);
				if (!$this->permission->check_permission_backend('publish')) {
					unset($input['news']['publish']);
				}
				if ($this->input->post('tag_exist') || $this->input->post('tag_new')) {
					$input['tags'] = array(
						'tag_exist' => @array_map('intval', $this->input->post('tag_exist')),
						'tag_new' => $this->input->post('tag_new'),
					);
				}
				$input['gallery'] = $this->input->post('gallery');
				$input['category'] = $this->input->post('category');
				$input['group'] = $this->input->post('group');
				if ($action == 'add') {
                        // Check trùng SEO Titleơ
                        if ($this->news->Check_SEO_Title_Exist($this->input->post("seo_title"), $this->input->post("title"))) {
                            if (trim($this->input->post("seo_title")) != '') {
                                $message_check = 'Lưu ý: Tiêu đề SEO của bài viết bị trùng' . '|' . $this->input->post("seo_title") . '|' . $this->input->post("title");
                            } else {
                                $message_check = 'Lưu ý: Bài viết chưa có tiêu đề SEO. Tên bài viết bị trùng';
                            }
                            return $this->output->set_output(json_encode(array('status' => 'error', 'valid_rule' => $this->form_validation->error_array(), 'message' => $message_check)));
                        }

					$result = $this->news->insert($input);
					if ($item_id = $result) {
						$html = $this->load->view('news/form', $this->_add());
					}
				} else {
					if ($this->security->verify_token_post($params['id'], $this->input->post('token'))) {
                            if ($action == 'edit') {
                                // Check trùng SEO Title edit - $params['id']
                                if ($this->news->Check_SEO_Title_Edit($params['id'],$this->input->post("seo_title"), $this->input->post("title"))) {
                                    if (trim($this->input->post("seo_title")) != '') {
                                        $message_check = 'Lưu ý: Tiêu đề SEO của bài viết bị trùng' . '|' . $this->input->post("seo_title") . '|' . $this->input->post("title");
                                    } else {
                                        $message_check = 'Lưu ý: Bài viết chưa có tiêu đề SEO. Tên bài viết bị trùng';
                                    }
                                    return $this->output->set_output(json_encode(array('status' => 'error', 'valid_rule' => $this->form_validation->error_array(), 'message' => $message_check)));
                                }
                            }
						$result = $this->news->update($params['id'], $input);
					}
					if ($result) {
						$item_id = $params['id'];
						$html = $this->load->view('news/form', $this->_edit($params['id']));
					}
				}
				if ($result) {
					// log action
					$this->logs->insertAction(array('action' => $action, 'module' => $this->module, 'item_id' => $item_id));
					// return result
					return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
				}
			} else {
				return $this->output->set_output(json_encode(array('status' => 'error', 'valid_rule' => $this->form_validation->error_array(), 'message' => $this->lang->line("common_update_validator_error"))));
			}
			break;
		case 'delete':
			$arrId = $this->input->post('cid');
			$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
			if (!$arrId) {
				return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
			}
			if (!$this->permission->check_permission_backend('delete')) {
				return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
			}
			$result = $this->news->delete($arrId);

			if ($result) {
				// log action
				$this->logs->insertAction(array('action' => $action, 'module' => $this->module, 'item_id' => $arrId));
				// return result
				$html = $this->load->view('news/list', $this->_index());
				return $this->output->set_output(json_encode(array('status' => 'success', 'html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
			}
			break;
		case 'buildtop':
			$arrId = $this->input->post('cid');
			$position = $this->input->post('position');
			$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;

			$result = $this->news->update_buildtop($arrId, $position);
			if ($result) {
				// log action
				$this->logs->insertAction(array('action' => $action, 'module' => $this->module, 'item_id' => 0));
				// return result
				return $this->output->set_output(json_encode(array('status' => 'success', 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
			}
			break;
		case 'buildtag':
			$arrId = $this->input->post('cid');
			$position = $this->input->post('position');
			$arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
			$result = $this->news->update_buildtag($arrId, $position);
			if ($result) {
				// log action
				$this->logs->insertAction(array('action' => $action, 'module' => $this->module, 'item_id' => 0));
				// return result
				return $this->output->set_output(json_encode(array('status' => 'success', 'result' => $result, 'message' => $this->lang->line("common_update_success"))));
			}
			break;
		default:
			# code...
			break;
		}
		return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
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
}