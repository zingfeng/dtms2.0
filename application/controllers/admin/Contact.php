<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact extends CI_Controller{
    public $module = 'contact';
    function __construct(){
		parent::__construct();
		$this->lang->load('backend/contact');
		$this->load->setData('title',$this->lang->line('contact_title'));
	}
    public function index(){
        if ($this->input->post('delete'))
        {
            return $this->_action('delete');
        }
        $this->load->setArray(array("isLists" => 1));
        $data = $this->_index();
        // render view
        $this->load->layout('contact/list',$data);
    }
    public function edit() {
        if ($this->input->post('submit')){
            return $this->_action('edit');
        }
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_update_validator_error"))));
    }
    public function _index(){
        $limit = $this->config->item("limit_item");
        $this->load->model('admin/contact_model','contact');  
        $this->load->model('admin/setting_model','setting');       
        // get paging
        $page = (int) $this->input->get('page');
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;
        $params = array('limit' => $limit + 1,'offset' => $offset);
        ////////////////// FITER /////////
        $params_filter = array_filter(array(
            'fullname' => $this->input->get('fullname'),
            'status' => $this->input->get('status'),
            'type' => $this->input->get('type'),
            'from_date' => ($fromdate = $this->input->get('from_date')) ? convert_datetime($fromdate) : (time() - 6*30*3600*24), // 6 thang
            'to_date' => ($todate = $this->input->get('to_date')) ? convert_datetime($todate) : time()
        ),'filter_item');
        $params = array_merge($params,$params_filter);
        // get array contact
        $rows = $this->contact->lists($params);
        // get branch and offline_place
        $arrSetting = $this->setting->detail();
        $arrBranch = json_decode($arrSetting['branch'],TRUE);
        foreach ($arrBranch as $key => $branch) {
            $arrBranchData[$branch['id']] = $branch['name'];
        }
        $arrOfflinePlace = json_decode($arrSetting['offline_place'], TRUE);

        if ( (is_array($arrOfflinePlace) )&& count($arrOfflinePlace) > 0){
            foreach ($arrOfflinePlace as $key => $offline_place) {
                $arrOfflinePlaceData[$offline_place['id']] = $offline_place['name'];
            }
        }



        /** PAGING **/
        $config['total_rows'] = count($rows);
        $config['per_page'] = $limit;
        $this->load->library('paging',$config);
        $paging = $this->paging->create_links();
        unset($rows[$limit]);
        // set data
        return array('rows' => $rows, 'paging' => $paging, 'filter' => $params_filter, 'arrBranch' => $arrBranchData, 'arrOfflinePlace' => $arrOfflinePlaceData);
    }
    public function _action($action, $params = array()) {
        $this->load->model('admin/contact_model','contact');
        $this->load->model('admin/logs_model','logs');
        switch ($action) {
            case 'edit':
            case 'delete':

                // get cid
                $arrId = $this->input->post('cid');
                $arrId = (is_array($arrId)) ? array_map('intval', $arrId) : (int) $arrId;
                if (!$arrId) {
                    return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_delete_min_select"))));
                }
                if ($action == 'edit') {
                    if (!$this->permission->check_permission_backend('edit')){
                        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
                    }
                    $result = $this->contact->update_status($arrId);   
                }
                else {
                    if (!$this->permission->check_permission_backend('delete')){
                        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_access_denied"))));
                    }
                    $result = $this->contact->delete($arrId);
                }  
                if ($result) {
                    // log action
                    $this->logs->insertAction(array('action' => $action,'module' => $this->module, 'item_id' => $arrId));
                    // return result
                    $html = $this->load->view('contact/list',$this->_index()); 
                    return $this->output->set_output(json_encode(array('status' => 'success','html' => $html, 'result' => $result, 'message' => $this->lang->line("common_delete_success"))));
                }
            break;
            default:
                # code...
                break;
        }   
        return $this->output->set_output(json_encode(array('status' => 'error', 'message' => $this->lang->line("common_no_row_update"))));
    }

    public function subscribe(){
        $this->load->setArray(array("isLists" => 1));
        $data = $this->_subscribe();
        // render view
        $this->load->layout('contact/list_sub', $data);
    }
    public function _subscribe(){
        $limit = $this->config->item("limit_item");
        $this->load->model('admin/contact_model','contact');        
        // get paging
        $page = (int) $this->input->get('page');
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;
        $params = array('limit' => $limit + 1,'offset' => $offset);
        $rows = $this->contact->subscribe($params);
        /** PAGING **/
        $config['total_rows'] = count($rows);
        $config['per_page'] = $limit;
        $this->load->library('paging',$config);
        $paging = $this->paging->create_links();
        unset($rows[$limit]);
        // set data
        return array('rows' => $rows, 'paging' => $paging);
    }

    /**
     * @todo: Export danh sách liên hệ
     **/
    public function export()
    {
        $this->load->model('admin/contact_model', 'contact');
        $this->load->model('admin/setting_model', 'setting');
        ////////////////// FITER /////////
        $params = array_filter(array(
            'fullname' => $this->input->get('fullname'),
            'status' => $this->input->get('status'),
            'type' => $this->input->get('type'),
            'from_date' => ($fromdate = $this->input->get('from_date')) ? convert_datetime($fromdate) : (time() - 6 * 30 * 3600 * 24), // 6 thang
            'to_date' => ($todate = $this->input->get('to_date')) ? convert_datetime($todate) : time()
        ), 'filter_item');
        $rows = $this->contact->export($params);
        $filename = 'Export-' . date('d-m-Y');
        $arr_title = array(
            "ID", // 0
            "Họ tên", // 1
            "Email", // 2
            "Nội dung", // 3
            "Điện thoại", // 4
            "Trạng thái", //5
            "Thời gian đăng ký", // 6
            "user_id", //7
            "Kiểu", // 8
            "Địa chỉ", //9
            "Công việc", // 10
            "Chi nhánh", //11
            "Địa điểm Offline", // 12
            "Ngày sinh", //13
            "Khu vực sống", // 14
            "URL đăng ký", //15
        );

        $this->db->select('branch, offline_place');
        $query = $this->db->get('setting');
        $res = $query->result_array();

        $arr_branch = $res[0]['branch'];
        $arr_branch_live = json_decode($arr_branch, true);
        $arr_brand_id_to_text = array();
        for ($i = 0; $i < count($arr_branch_live); $i++) {
            $dgjldfg = (int)$arr_branch_live[$i]['id'];
            $arr_brand_id_to_text[$dgjldfg] = $arr_branch_live[$i]['name'];
        }

        $offline_place = $res[0]['offline_place'];
        $offline_place_live = json_decode($offline_place, true);
        $offline_place_id_to_text = array();
        for ($i = 0; $i < count($offline_place_live); $i++) {
            $dgjldfg = (int)$offline_place_live[$i]['id'];
            $offline_place_id_to_text[$dgjldfg] = $offline_place_live[$i]['name'];
        }

        // Lọc 1 số dữ liệu sử dụng ID trong hệ thống
        // Mô tả function theo layer - Mask Value by Rule

        $arr_data = array($arr_title);
        for ($i = 0; $i < count($rows); $i++) {
            // MASK UP ID Location, branch, offline Place
            $arr_values = array_values($rows[$i]);

            $time = (int)$arr_values[6];
            $arr_values[6] = date('H:i:s - d/m/Y', $time);

            $arr_form_type_text = array(
                3  => 'Đăng ký làm test',
                1  => 'Đăng ký tư vấn',
                4  => 'Đăng ký tham gia offline',
                5  => 'Đăng ký nhận tài liệu',
            );
            $type_form = (int)$arr_values[8];

            if (isset($arr_form_type_text[$type_form]))
            {
                $arr_values[8] = $arr_form_type_text[$type_form];
            }


            $id_branch = (int)$arr_values[11];
            if (isset($arr_brand_id_to_text[$id_branch])) {
                $arr_values[11] = $arr_brand_id_to_text[$id_branch];
            }

            $id_offline_place = (int)$arr_values[12];
            if (isset($offline_place_id_to_text[$id_offline_place])) {
                $arr_values[12] = $offline_place_id_to_text[$id_offline_place];
            }

            array_push($arr_data, $arr_values);
        }

        // Sắp xếp mẫu đầu ra - thứ tự các col
        $arr_index_select = array(0, 11, 6, 1, 4, 15, 13, 2, 3, 8, 9, 12, 14, 10);
        $arr_data_show = $this->_selectCols_from_Table($arr_index_select, $arr_data);

//        echo '<pre>';
//        print_r($arr_data_show);
//        echo '<pre>';
//        exit;
        $this->_Arr_To_Excel_File_XLSX('Sheet1', $arr_data_show, true, $filename, true);
    }

    private function _Arr_To_Excel_File_XLSX($name_Sheet, $data_array, $set_first_row_title, $filename, $download)
    {
        $this->load->library('PHPExcel');
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle($name_Sheet);

        if ($set_first_row_title == true) {
            $number_column = count($data_array[0]);
            $column_letter_in_the_end_Row = $this->_getColumnLetter($number_column);
            $excel->getActiveSheet()->getStyle("A1:" . $column_letter_in_the_end_Row . "1")->getFont()->setBold(true);
        }

        $excel->getActiveSheet()->fromArray($data_array, null, 'A1');

        if ($download == true) {
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
        } else {
            PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save($filename . '.xlsx');
        }

    }

    private function _getColumnLetter($index_colum)
    {

        $index_colum = intval($index_colum);
        if ($index_colum <= 0) return '';

        $letter = '';

        while ($index_colum != 0) {
            $p = ($index_colum - 1) % 26;
            $index_colum = intval(($index_colum - $p) / 26);
            $letter = chr(65 + $p) . $letter;
        }

        return $letter;

    }

    /**
     * Hàm này lấy các cột của 1 mảng nhiều chiều theo thứ tự được order
     * @param $arr_index_select
     * @param $arr_data
     * @return mixed
     */
    private function _selectCols_from_Table($arr_index_select, $arr_data)
    {
        // Đổi chiều PHP array multi dimension
        $arr_res = array();
        $arr_mono = array();
        for ($i = 0; $i < count($arr_data); $i++) {
            array_push($arr_res, $arr_mono);
        }

        for ($i = 0; $i < count($arr_data); $i++) {
            $mono = $arr_data[$i];
            for ($k = 0; $k < count($arr_index_select); $k++) {
                $select_index = $arr_index_select[$k];
                array_push($arr_res[$i], $mono[$select_index]);
            }
        }
        return $arr_res;

    }

    /**
     * Hàm này lấy các hàng của 1 mảng nhiều chiều theo thứ tự được order
     * @param $arr_index_select
     * @param $arr_data
     * @return mixed
     */
    private function _selectRows_from_Table($arr_index_select, $arr_data)
    {
        $arr_res = array();
        if (is_array($arr_index_select)) {
            for ($i = 0; $i < count($arr_index_select); $i++) {
                if (isset($arr_data[$i])) {
                    array_push($arr_res, $arr_data[$i]);
                }
            }
        }
        return $arr_res;
    }


}