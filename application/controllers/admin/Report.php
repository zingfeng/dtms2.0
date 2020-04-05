<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller{
    function __construct(){
		parent::__construct();
        $this->load->setData('title','Báo cáo');
	}
	public function users(){
        if ($this->input->post('export_data')) {
            $filename = 'Export-User-'.date('d-m-Y').'.xlsx'; 
            $this->load->library('PHPExcel');
            if ($this->input->post('date_to')) {
                $todate = convert_datetime($this->input->post('date_to'),3);
            }
            else {
                $todate = time();
            }
            if ($this->input->post('date_from')) {
                $fromdate = convert_datetime($this->input->post('date_from'),3);
            }
            else {
                $fromdate = $todate - 24*3600 ;
            }
            // select db
            $this->db->where('date_reg >= ', $fromdate);
            $this->db->where('date_reg <= ', $todate);
            $query = $this->db->get("member");
            $rows = $query->result_array();
            if (empty($rows)) {
                $data['error'] = 'Không có dữ liệu nào';
            }
            else {
                $objPHPExcel = new PHPExcel();
                $i = 1; 
                $baseRow = 2;
                foreach($rows as $key => $row){   
                    $count = $baseRow + $key;
                    if($i == 1){
                        $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$i, "Họ tên")
                        ->setCellValue('B'.$i, "Email")
                        ->setCellValue('C'.$i, "Giới tính")
                        ->setCellValue('D'.$i, "Số điện thoại")
                        ->setCellValue('E'.$i, "Đăng nhập gần nhất")
                        ->setCellValue('F'.$i, "Địa điểm");
                    }
                    $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
                    $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$count, $row['fullname'])
                        ->setCellValue('B'.$count, $row['email'])
                        ->setCellValue('C'.$count, $row['sex'])
                        ->setCellValue('D'.$count, $row['phone'])
                        ->setCellValue('E'.$count, date('H:i:s d/m/Y', $row['last_logined']))
                        ->setCellValue('F'.$count, $row['location']);
                    $i++;
                }
                
                $objPHPExcel->getActiveSheet()->setTitle('Export-User-'.date('d-m-Y'));
                $objPHPExcel->setActiveSheetIndex(0);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                //$objWriter->save($filename);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachement; filename="' . $filename . '"');
                ob_end_clean();
                $objWriter->save('php://output');exit();

            }
            

        }
        $static[] = js('jquery-ui-1.10.0.custom.min.js');
        $static[] = js('jquery-ui-timepicker-addon.js');
        $static[] = link_tag('jquery-ui.css');
        $static[] = link_tag('jquery-ui-timepicker-addon.css');
        $this->load->setArray("footer",$static);
        return $this->load->layout("report/bydate");
	}
    public function test($id=0,$st=0){
        if ($this->input->post('export_data')) {
            $filename = 'Export-Test-'.date('d-m-Y').'.xlsx'; 
            $this->load->library('PHPExcel');
            if ($this->input->post('date_to')) {
                $todate = convert_datetime($this->input->post('date_to'),3);
            }
            else {
                $todate = time();
            }
            if ($this->input->post('date_from')) {
                $fromdate = convert_datetime($this->input->post('date_from'),3);
            }
            else {
                $fromdate = $todate - 24*3600 ;
            }
            // select db
            
            $this->db->select('u.fullname,u.email,u.sex,u.phone,u.location, t.date_up, t.score,test.title,test.share_url');
            $this->db->join('member as u','u.user_id = t.user_id');
            $this->db->join('test','test.test_id = t.test_id');
            $this->db->order_by('t.date_up','DESC');
            $this->db->where('t.date_up >= ', $fromdate);
            $this->db->where('t.date_up <= ', $todate);
            $this->db->group_by('t.user_id');
            $query = $this->db->get("log_test as t");

            $rows = $query->result_array();
            if (empty($rows)) {
                $data['error'] = 'Không có dữ liệu nào';
            }
            else {
                $objPHPExcel = new PHPExcel();
                $i = 1; 
                $baseRow = 2;
                foreach($rows as $key => $row){   
                    $count = $baseRow + $key;
                    if($i == 1){
                        $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$i, "Họ tên")
                        ->setCellValue('B'.$i, "Email")
                        ->setCellValue('C'.$i, "Giới tính")
                        ->setCellValue('D'.$i, "Số điện thoại")
                        ->setCellValue('E'.$i, "Địa điểm")
                        ->setCellValue('F'.$i, "Ngày làm test")
                        ->setCellValue('G'.$i, "Điểm test")
                        ->setCellValue('H'.$i, "Tên bài test")
                        ->setCellValue('I'.$i, "Link");
                    }
                    $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
                    $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$count, $row['fullname'])
                        ->setCellValue('B'.$count, $row['email'])
                        ->setCellValue('C'.$count, $row['sex'])
                        ->setCellValue('D'.$count, $row['phone'])
                        ->setCellValue('E'.$count, $row['location'])
                        ->setCellValue('F'.$count, date('H:i:s d/m/Y', $row['date_up']))
                        ->setCellValue('G'.$count, $row['score'])
                        ->setCellValue('H'.$count, $row['title'])
                        ->setCellValue('I'.$count, BASE_URL.$row['share_url']);
                    $i++;
                }
                
                $objPHPExcel->getActiveSheet()->setTitle('Export-User-'.date('d-m-Y'));
                $objPHPExcel->setActiveSheetIndex(0);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                //$objWriter->save($filename);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachement; filename="' . $filename . '"');
                ob_end_clean();
                $objWriter->save('php://output');exit();
            }
        }
        $static[] = js('jquery-ui-1.10.0.custom.min.js');
        $static[] = js('jquery-ui-timepicker-addon.js');
        $static[] = link_tag('jquery-ui.css');
        $static[] = link_tag('jquery-ui-timepicker-addon.css');
        $this->load->setArray("footer",$static);
        return $this->load->layout("report/bydate");
    }
    public function contact(){
        $data = array();
        if ($this->input->post('export_data')) {
            $filename = 'Export-Contact-'.date('d-m-Y').'.xlsx'; 
            $this->load->library('PHPExcel');
            if ($this->input->post('date_to')) {
                $todate = convert_datetime($this->input->post('date_to'),3);
            }
            else {
                $todate = time();
            }
            if ($this->input->post('date_from')) {
                $fromdate = convert_datetime($this->input->post('date_from'),3);
            }
            else {
                $fromdate = $todate - 24*3600 ;
            }
            // select db
            $this->db->select('*');
            $this->db->order_by('contact_id','DESC');
            $this->db->where('date >= ', $fromdate);
            $this->db->where('date <= ', $todate);
            $query = $this->db->get("contact");
            
            $rows = $query->result_array();
            if (empty($rows)) {
                $data['error'] = 'Không có dữ liệu nào';
            }
            else {
                $this->load->config('data');
                $arrLocation = $this->config->item("location");
                $arrBrand = $this->config->item('brand_location');
                $objPHPExcel = new PHPExcel();
                $i = 1; 
                $baseRow = 2;
                foreach($rows as $key => $row){   
                    $count = $baseRow + $key;
                    if($i == 1){
                        $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$i, "Họ tên")
                        ->setCellValue('B'.$i, "Email")
                        ->setCellValue('C'.$i, "Số điện thoại")
                        ->setCellValue('D'.$i, "Nội dung")
                        ->setCellValue('E'.$i, "Địa điểm")
                        ->setCellValue('F'.$i, "Công việc")
                        ->setCellValue('G'.$i, "Thời gian")
                        ->setCellValue('H'.$i, "Cơ sở")
                        ->setCellValue('I'.$i, "ID")
                        ->setCellValue('J'.$i, "Loại");
                    }
                    $objPHPExcel->getActiveSheet()->insertNewRowBefore($count,1);
                    $objPHPExcel->getActiveSheet(0)
                        ->setCellValue('A'.$count, $row['fullname'])
                        ->setCellValue('B'.$count, $row['email'])
                        ->setCellValue('C'.$count, $row['phone'])
                        ->setCellValue('D'.$count, $row['content'])
                        ->setCellValue('E'.$count, $arrLocation[$row['location']])
                        ->setCellValue('F'.$count, $row['job'])
                        ->setCellValue('G'.$count, date('H:i:s d/m/Y', $row['date']))
                        ->setCellValue('H'.$count, $arrBrand[$row['brand']])
                        ->setCellValue('I'.$count, $row['item_id'])
                        ->setCellValue('J'.$count, $row['type']);
                    $i++;
                }
                
                $objPHPExcel->getActiveSheet()->setTitle('Export-User-'.date('d-m-Y'));
                $objPHPExcel->setActiveSheetIndex(0);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                //$objWriter->save($filename);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachement; filename="' . $filename . '"');
                ob_end_clean();
                $objWriter->save('php://output');exit();
            }
        }
        $static[] = js('jquery-ui-1.10.0.custom.min.js');
        $static[] = js('jquery-ui-timepicker-addon.js');
        $static[] = link_tag('jquery-ui.css');
        $static[] = link_tag('jquery-ui-timepicker-addon.css');
        $this->load->setArray("footer",$static);
        return $this->load->layout("report/bydate",$data);
    }
}