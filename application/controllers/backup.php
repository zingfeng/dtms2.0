<?php

class Backup{

    public function check_service_live(){
        if (isset($_GET['token']) && ($_GET['token'] === 'LK4Nx2dfgerUvuym5nbdUvuym5nbd') ){
            $this->db->where('site_id',1);
            $this->db->select('*');
            $query = $this->db->get('setting');
            $list_task = $query->result_array();
            $now = time();
            $last_time_live = (int) $list_task[0]['last_time_live_cron_email'];

            $delta_time = $now - $last_time_live;
            if ($delta_time > 200 ){
                echo '0';
                return 0;
                // return false;
            }else{
                echo '1';
                return 1;
            }
        }
    }

// =================================
    public function check_service_markpoint_live(){
        if (isset($_GET['token']) && ($_GET['token'] === 'LK4Nx2dfgerUvuym5dgdfnbdUvuym5nbd') ){
            $this->db->where('site_id',1);
            $this->db->select('*');
            $query = $this->db->get('setting');
            $list_task = $query->result_array();
            $now = time();
            $last_time_live = (int) $list_task[0]['last_time_live_cron_markpoint'];

            $delta_time = $now - $last_time_live;
            if ($delta_time > 200 ){
                echo '0';
                return 0;
                // return false;
            }else{
                echo '1';
                return 1;
            }
        }
    }

    private function check_service_markpoint_live_inner(){
        $this->db->where('site_id',1);
        $this->db->select('*');
        $query = $this->db->get('setting');
        $list_task = $query->result_array();
        $now = time();
        $last_time_live = (int) $list_task[0]['last_time_live_cron_markpoint'];

        $delta_time = $now - $last_time_live;
        if ($delta_time > 1200 ){
            return false;
        }else{
            return true;
        }
    }

    // ===
    public function abc()
    {
        $this->load->model('Feedback_model', 'feedback');


        $hn = array(
            ['Email: msbanana.qt@gmail.com| SĐT: 0984701121| Ngày sinh : 15/09/1990|Chức vụ: Giáo viên parttime|Điểm TOEIC/IELTS/ĐH: F|Địa chỉ: số 46, ngõ 280/3, phố Lê Trọng Tấn, Khương Mai, Thanh Xuân, Hà Nội|Thời gian công tác: 23/12/2013|Fb: https://www.facebook.com/chip.chip.chip.chip.chip', 'Ms Trang Chuối', 'IELTS'],
            ['Email: thaophamt.dn@gmail.com| SĐT: 01635465828| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 980|Địa chỉ: Tây Sơn,HN|Thời gian công tác: 42522|Fb: ', 'Ms Thu Thảo', 'IELTS'],
            ['Email: ngtdung1509@gmail.com| SĐT: 0038 9706136| Ngày sinh : 1995|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5 ielts|Địa chỉ: Hoàng Văn Thái|Thời gian công tác: 43563|Fb: https://www.facebook.com/trongdung.nguyen.397?fref=ts', 'Mr Trọng Dũng', 'IELTS/ TOEIC'],
            ['Email: nguyenhongatm04@gmail.com| SĐT: 01657964291| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 850|Địa chỉ: Cầu giấy|Thời gian công tác: 42583|Fb: ', 'Ms Hồng', 'TOEIC'],
            ['Email: tranvan2379@gmail.com| SĐT: 0387977089| Ngày sinh : 1999|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Trần Hải Vân', 'TOEIC'],
            ['Email: dangvananh.2610@gmail.com| SĐT: 0963996429| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Hà Đông|Thời gian công tác: 43617|Fb: ', 'Đặng Thị Vân Anh', 'TOEIC'],
            ['Email: trangtrinh1991998@gmail.com| SĐT: 01669954198| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 935|Địa chỉ: Kim Ngưu, HBT, HN|Thời gian công tác: 42826|Fb: ', 'Ms Trịnh Trang', 'GIAO TIẾP'],
            ['Email: dothiduyen5797@gmail.com| SĐT: 0926956996| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Mỹ ĐÌnh|Thời gian công tác: 42887|Fb: ', 'Ms Duyên', 'GIAO TIẾP'],
            ['Email: hanghang3297@gmail.com| SĐT: 0936023603| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 970 Toeic|Địa chỉ: Hoàn Kiếm|Thời gian công tác: 42887|Fb: ', 'Ms Hoàng Hằng', 'TOEIC'],
            ['Email: hyv98812@gmail.com| SĐT: 01678553011| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 975 toeic/8.0 Toeic|Địa chỉ: tôn đức thắng|Thời gian công tác: 42826|Fb: ', 'Ms Bằng Thương', 'IELTS/TOEIC'],
            ['Email: phamtrungntt@gmail.com| SĐT: 0037 8 173 520| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Cầu giấy|Thời gian công tác: 42917|Fb: ', 'Mr Trung', 'GIAO TIẾP'],
            ['Email: mailan.hocvienbaochi@gmail.com| SĐT: 00375 571 767| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: kim mã|Thời gian công tác: 42917|Fb: ', 'Ms Mai Lan', 'GIAO TIẾP'],
            ['Email: trangnha@imap.edu.vn| SĐT: 0911-051-603| Ngày sinh : |Chức vụ: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Phạm Trang Nhã', 'IELTS'],
            ['Email: ninh.dt237@gmail.com| SĐT: 01696383333| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 930 toeic|Địa chỉ: Võ Chí Công, Cầu Giấy, HN|Thời gian công tác: 42979|Fb: ', 'Mr Ninh - Đoàn Duy Tùng', 'TOEIC'],
            ['Email: linhazureg@gmail.com| SĐT: 0971159856| Ngày sinh : |Chức vụ: |Điểm TOEIC/IELTS/ĐH: 945|Địa chỉ: |Thời gian công tác: 42948|Fb: ', 'Ms Thùy Linh', 'TOEIC'],
            ['Email: hoadp.186@gmail.com| SĐT: 0989107199| Ngày sinh : 1995|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 920 toeic/ 7.5 ielts|Địa chỉ: Nguyễn Sơn, Long Biên, HN|Thời gian công tác: 43040|Fb: ', 'Ms Phương Hoa', 'IELTS'],
            ['Email: bachlsgh12091@fpt.edu.vn| SĐT: 01686271995| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 935|Địa chỉ: Minh Khai, Hoàng Mai, HN|Thời gian công tác: 43040|Fb: ', 'Mr Bách', 'TOEIC'],
            ['Email: minhtamdav@gmail.com| SĐT: 0934435875| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 975|Địa chỉ: Chương Dương Độ, Hoàn Kiếm, HN|Thời gian công tác: 43070|Fb: chưa ký hợp đồng', 'Ms Minh Tâm', 'TOEIC'],
            ['Email: jillkaulitz@gmail.com| SĐT: 0984879934| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43040|Fb: ', 'Ms Thu Ngân', 'GIAO TIẾP'],
            ['Email: nganguyen.epu@gmail.com| SĐT: 0981768191| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 930 toeic, 7.5 ielts|Địa chỉ: Hoàng Quốc Việt|Thời gian công tác: 43160|Fb: ', 'Ms Nga Nguyễn', 'IELTS/TOEIC'],
            ['Email: huyentong93@gmail.com| SĐT: 0815322973| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 900|Địa chỉ: Bạch Mai, làm hành chính ở HÀ Đông|Thời gian công tác: 42917|Fb: ', 'Ms Ngọc Huyền', 'TOEIC'],
            ['Email: viethieu3110@gmail.com| SĐT: 00922 046 133| Ngày sinh : 1996|Chức vụ: Giáo viên parttime|Điểm TOEIC/IELTS/ĐH: 8.0 Ielts|Địa chỉ: |Thời gian công tác: 43191|Fb: ', 'Mr Phạm Việt Hiếu', 'IELTS'],
            ['Email: hong.quan182@gmail.com| SĐT: 0974.032.701| Ngày sinh : 1996|Chức vụ: Giáo viên parttime|Điểm TOEIC/IELTS/ĐH: 8.0 Íelts|Địa chỉ: |Thời gian công tác: 43252|Fb: ', 'Mr Hồng Quân', 'IELTS'],
            ['Email: ollielenguyen@gmail.com| SĐT: 0916045561| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: GIAO TIẾP|Thời gian công tác: 43252|Fb: ', 'Ms Hương Ly', 'GIAO TIẾP'],
            ['Email: huyen98xoxo@gmail.com| SĐT: 0866152725| Ngày sinh : 1998|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: GIAO TIẾP|Thời gian công tác: 43252|Fb: ', 'Ms Thu Huyền', 'GIAO TIẾP'],
            ['Email: binhnguyen.hebes@gmail.com| SĐT: 0985626876| Ngày sinh : 1995|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 985|Địa chỉ: TOEIC|Thời gian công tác: 43252|Fb: ', 'Ms Nguyễn Bình', 'TOEIC'],
            ['Email: nikile1989@gmail.com| SĐT: 0987906868| Ngày sinh : 1989|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: TOEIC|Thời gian công tác: 43282|Fb: ', 'Ms Nhung Lê', 'TOEIC'],
            ['Email: hoangthanhnam.dav@gmail.com| SĐT: 0987.355.142| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5 ielts, 8.0 speaking|Địa chỉ: IELTS|Thời gian công tác: 43282|Fb: ', 'Mr Thanh Nam', 'IELTS'],
            ['Email: thu96.hn@gmail.com| SĐT: 01675773975| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: GIAO TIẾP|Thời gian công tác: 43282|Fb: ', 'Ms Hoài Thu', 'GIAO TIẾP'],
            ['Email: lananh10091998@gmail.com| SĐT: 0398982346| Ngày sinh : 1998|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: GIAO TIẾP|Thời gian công tác: 43647|Fb: ', 'Nguyễn Lan Anh', 'GIAO TIẾP'],
            ['Email: luonghang289@gmail.com| SĐT: 01694844966| Ngày sinh : |Chức vụ: Giáo viên Part-time|Điểm TOEIC/IELTS/ĐH: 925|Địa chỉ: TOEIC|Thời gian công tác: 43313|Fb: ', 'Ms Lương Hằng', 'TOEIC'],
            ['Email: trungduccnn@gmail.com| SĐT: 0| Ngày sinh : 1995|Chức vụ: Giáo viên Part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43313|Fb: ', 'Mr Trung Đức', 'IELTS'],
            ['Email: bichthuy29796@gmail.com| SĐT: 0913329796| Ngày sinh : |Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43313|Fb: ', 'Ms Bích Thùy', 'TOEIC'],
            ['Email: trankieumyhumg@gmail.com| SĐT: 0097 378 8255| Ngày sinh : 1995|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5 Ielts|Địa chỉ: |Thời gian công tác: 43344|Fb: ', 'Ms Kiều Mỹ', 'IELTS'],
            ['Email: lethuygiang.mac@gmail.com| SĐT: 0947.000.794| Ngày sinh : |Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 950|Địa chỉ: |Thời gian công tác: 43344|Fb: ', 'Ms Thùy Giang', 'TOEIC'],
            ['Email: vuhuonglinh1205@gmail.com| SĐT: 0358327586| Ngày sinh : |Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Vũ Hương Linh', 'GIAO TIẾP'],
            ['Email: khanhlinhnguyen8195@gmail.com| SĐT: 0072 9388440| Ngày sinh : 1995|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 950|Địa chỉ: |Thời gian công tác: 43374|Fb: ', 'Ms Khánh Linh', 'TOEIC'],
            ['Email: ikerpham2298@gmail.com| SĐT: 00919 317 228| Ngày sinh : 1998|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 940|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Phạm Đạt', 'TOEIC'],
            ['Email: camtuduong1597@gmail.com| SĐT: 0988415597| Ngày sinh : 1997|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: |Thời gian công tác: 43313|Fb: ', 'Ms Cẩm Tú', 'IELTS'],
            ['Email: datbino.139@gmail.com| SĐT: 0867911309| Ngày sinh : 1995|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Lưu Thành Đạt', 'IELTS'],
            ['Email: thuhuongajc34@gmail.com| SĐT: 0983283571| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 975|Địa chỉ: |Thời gian công tác: 43405|Fb: ', 'Ms Thu Hương', 'TOEIC'],
            ['Email: tienthanh1807@gmail.com| SĐT: 0976438553| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 900|Địa chỉ: |Thời gian công tác: 43435|Fb: ', 'Mr Tiến Thành', 'TOEIC'],
            ['Email: anhpq52.hrc@gmail.com| SĐT: 0943065090| Ngày sinh : 1995|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43282|Fb: ', 'Ms Quỳnh Anh Phạm', 'IELTS'],
            ['Email: minhanh5335@gmail.com| SĐT: 0081 5531997| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: kim|Thời gian công tác: 43435|Fb: ', 'Ms Minh Anh', 'IELTS'],
            ['Email: quanglinhboy99@gmail.com| SĐT: 0985784828| Ngày sinh : 1999|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43435|Fb: ', 'Mr Quang Linh', 'GIAO TIẾP'],
            ['Email: hieuphamt63@gmail.com| SĐT: 0986613065| Ngày sinh : 1999|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 960|Địa chỉ: |Thời gian công tác: 43497|Fb: ', 'Mr Trung Hiếu', 'TOEIC'],
            ['Email: manhquach6397@gmail.com| SĐT: 0773357160| Ngày sinh : 1997|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43497|Fb: ', 'Mr Quách Mạnh', 'TOEIC'],
            ['Email: imlinh94@gmail.com| SĐT: 0984562648| Ngày sinh : 1994|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 6.5/885|Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Nguyễn Hoa Mỹ Linh', 'TOEIC'],
            ['Email: haidtk13.tbc@gmail.com| SĐT: 0036 8933389| Ngày sinh : 1992|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5 ielts|Địa chỉ: |Thời gian công tác: 43497|Fb: ', 'Mr Thanh Hải', 'IELTS'],
            ['Email: nguyenthuphuong0896@gmail.com| SĐT: 035 610 1868| Ngày sinh : 1996|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43497|Fb: ', 'Ms Thu Phương', 'TOEIC'],
            ['Email: hieu94hanu@gmail.com| SĐT: 0083 666 1199| Ngày sinh : 1994|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 7.5, 980|Địa chỉ: Long Biên|Thời gian công tác: 43647|Fb: ', 'Nguyễn Trung Hiếu', 'TOEIC'],
            ['Email: toanhsmail@gmail.com| SĐT: 01632008080| Ngày sinh : 1998|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Tố Anh', 'GIAO TIẾP'],
            ['Email: nguyenmanhnguyen.pa@gmail.com| SĐT: 0979739950| Ngày sinh : 1995|Chức vụ: Giáo viên part-time|Điểm TOEIC/IELTS/ĐH: 825|Địa chỉ: |Thời gian công tác: 43497|Fb: ', 'Mr Mạnh Nguyên', 'GIAO TIẾP'],
            ['Email: thutrangtran4068@gmail.com| SĐT: 0968779406| Ngày sinh : 1998|Chức vụ: Giáo viên Part-time|Điểm TOEIC/IELTS/ĐH: 970|Địa chỉ: |Thời gian công tác: 43313|Fb: ', 'Ms Trang Trần', 'TOEIC'],
            ['Email: Hanhquyen278@gmail.com| SĐT: 0098 4814511| Ngày sinh : 1995|Chức vụ: Giáo viên Part-time|Điểm TOEIC/IELTS/ĐH: 945|Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Hạnh Quyên', 'TOEIC'],
            ['Email: bmhuong05@gmail.com| SĐT: 0034 4854165| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Minh Hương', 'TOEIC'],
            ['Email: ivanspham@gmail.com| SĐT: 0933658989| Ngày sinh : 1994|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 8.0 ielts|Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Phạm Duy Phong', 'IELTS'],
            ['Email: nguyenkhanhhuyen42@gmail.com,| SĐT: 0076 3356655| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Khánh Huyền', 'IELTS'],
            ['Email: ngothiquynh1307@gmail.com| SĐT: 0399675869| Ngày sinh : 1998|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Ngô Quỳnh', 'TOEIC'],
            ['Email: duyentranthuy98@gmail.com| SĐT: 0966505382| Ngày sinh : 1998|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Thủy Duyên', 'TOEIC'],
            ['Email: thuychi1696@gmail.com| SĐT: 0345906669| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Thùy Chi', 'TOEIC'],
            ['Email: Nguyenvietanh091295@gmail.com| SĐT: 0091 6017669| Ngày sinh : 1995|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5 ielts|Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Mr Việt Anh', 'IELTS'],
            ['Email: nhungete@gmail.com| SĐT: 0344231439| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Nguyễn Nhung', 'GIAO TIẾP'],
            ['Email: taoanh100@gmail.com| SĐT: 0086 9374616| Ngày sinh : 1994|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43525|Fb: ', 'Ms Tạ Oanh', 'IELTS'],
            ['Email: manhcuong18898@gmail.com| SĐT: 0942025888| Ngày sinh : 1998|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43556|Fb: ', 'Mr Trần Mạnh Cường', 'GIAO TIẾP'],
            ['Email: luongkimchung@gmail.com| SĐT: 0962868124| Ngày sinh : 1989|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 980 Toeic|Địa chỉ: |Thời gian công tác: 43556|Fb: ', 'Mr Kim Chung', 'TOEIC'],
            ['Email: yennhi@imap.edu.vn| SĐT: 0983125969| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43405|Fb: ', 'Ms Yến Nhi', 'TOEIC'],
            ['Email: trinhle1504@gmail.com| SĐT: 0917113739| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Ms Lê Phương Trinh', 'TOEIC'],
            ['Email: phamducvuong1997@gmail.com| SĐT: 0988772883| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.0 ielts|Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Mr Phạm Đức Vượng', 'IELTS'],
            ['Email: lephuong.ppl@gmail.com| SĐT: 0985495940| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Mr Phạm Lê Phương', 'GIAO TIẾP'],
            ['Email: duchd212@gmail.com| SĐT: 0968667136| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Mr Hoàng Hưng Đức', 'IELTS'],
            ['Email: lehaidang823@gmail.com| SĐT: 0961208090| Ngày sinh : 1993|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 8.0 ielts|Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Lê Hải Đăng', 'IELTS'],
            ['Email: nguyenlinhgiang0110@gmail.com| SĐT: 0945293110| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 8.5 ielts|Địa chỉ: |Thời gian công tác: 43556|Fb: ', 'Ms Linh Giang', 'IELTS'],
            ['Email: sululu049@gmail.com| SĐT: 0375181260| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5 ielts|Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Phạm Tuấn Kiệt', 'IELTS'],
            ['Email: thuynga275@gmail.com| SĐT: 0972 850 665| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43586|Fb: ', 'Ms Lại Thúy Nga', 'TOEIC'],
            ['Email: haianhtran96@gmail.com| SĐT: 0788090999| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Trần Hải Anh', 'IELTS'],
            ['Email: nguyentuanphongdt5k6@gmail.com| SĐT: 0359146175| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Nguyễn Tuấn Phong', 'GIAO TIẾP'],
            ['Email: dol_tran@hotmail.co.uk| SĐT: 0965169292| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Trần Tuấn', 'GIAO TIẾP'],
            ['Email: hoangdnl92@gmail.com| SĐT: 0388861492| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 775|Địa chỉ: |Thời gian công tác: 43617|Fb: ', 'Đỗ Nguyễn Lê Hoàng', 'GIAO TIẾP'],
            ['Email: dkhvy10@gmail.com| SĐT: 0(+84) 91 5848751| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Đoàn Khánh Hạ Vy', 'IELTS'],
            ['Email: ltdung0612@gmail.com| SĐT: 0943312982| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Lê Thùy Dung', 'IELTS'],
            ['Email: hongggngoc97@gmail.com| SĐT: 0833414368| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Nguyễn Hồng Ngọc', 'IELTS'],
            ['Email: anhtq.slink@gmail.com| SĐT: 0904648170| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 955|Địa chỉ: Cầu Giấy|Thời gian công tác: 43647|Fb: https://www.facebook.com/quoccanhhh', 'Trần Quốc Anh', 'TOEIC'],
            ['Email: 126anhtuyet@gmail.com| SĐT: 0388406867| Ngày sinh : 1994|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: Hào Nam|Thời gian công tác: 43647|Fb: ', 'Nguyễn Thị Ánh Tuyết', 'IELTS'],
            ['Email: hoanglinhlinhchi@gmail.com| SĐT: 0349812468| Ngày sinh : 1998|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 940|Địa chỉ: Cầu Giấy|Thời gian công tác: 43647|Fb: ', 'Nguyễn Linh Chi', 'TOEIC'],
            ['Email: qtquynhtrang.work@gmail.com trangquan@entergroup.vn| SĐT: 0961142396| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Cầu Giấy|Thời gian công tác: 43647|Fb: ', 'Quản Thị Quỳnh Trang', 'IELTS'],
            ['Email: nguyetminhntn@gmail.com| SĐT: 0944160150| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Nguyễn Thị Nguyệt Minh', 'IELTS'],
            ['Email: thanglenhat@gmail.com| SĐT: 0973788891| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: |Thời gian công tác: 43647|Fb: ', 'Lê Nhật Thắng', 'IELTS'],
            ['Email: khuatvietanh191197@gmail.com| SĐT: 0769017211| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 945, 7.5|Địa chỉ: |Thời gian công tác: 43678|Fb: ', 'Khuất Việt Anh', 'IELTS'],
            ['Email: lelamvn122@gmail.com| SĐT: 0866881302| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Thời gian công tác: 43678|Fb: ', 'Lê Đỗ Hiểu Lâm', 'IELTS'],
            ['Email: phamanh9591@gmail.com| SĐT: 0916382295| Ngày sinh : 1995|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 835|Địa chỉ: Cầu Giấy|Thời gian công tác: 43678|Fb: ', 'Phạm Thị Ngọc Ánh', 'GIAO TIẾP'],
            ['Email: linhnhitran2511@gmail.com| SĐT: 0983672511| Ngày sinh : |Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Nguyễn Đổng Chi|Thời gian công tác: 43678|Fb: ', 'Trần Linh Nhi', 'TOEIC'],
            ['Email: ptlinh1611@gmail.com| SĐT: 0945968676| Ngày sinh : 1990|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Thời gian công tác: |Fb: ', 'Phạm Tố Linh', 'GIAO TIẾP'],
            ['Email: vu.hong.nhung.277@gmail.com| SĐT: 0825963986| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 570 TOEFL|Địa chỉ: Tây Sơn|Thời gian công tác: 43678|Fb: ', 'Vũ Thị Hồng Nhung', 'GIAO TIẾP'],
            ['Email: nhatlinhle0410@gmail.com| SĐT: 0906295285| Ngày sinh : 1997|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Thuỵ Khuê|Thời gian công tác: 43678|Fb: ', 'Lê Nhật Linh', 'TOEIC'],
            ['Email: thuydungpd@gmail.com| SĐT: 0977649391| Ngày sinh : 1993|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5 IELTS|Địa chỉ: Trần Khát Chân|Thời gian công tác: 43678|Fb: ', 'Phạm Đặng Thùy Dung', 'IELTS'],
            ['Email: d.d.k.infinity@gmail.com| SĐT: 0909818896| Ngày sinh : 1996|Chức vụ: Giáo viên partime|Điểm TOEIC/IELTS/ĐH: 7.5, 965|Địa chỉ: |Thời gian công tác: |Fb: ', 'Dương Duy Khánh', 'IELTS'],
        );

//        foreach ($hn as $mono){
//            $info = $mono[0];
////            $info = str_replace('|','<br>',$info);
//            $mono_info  = explode('|',$info);
////            var_dump($mono_info);
//            $email_info = $mono_info[0];
//            $email_info = trim(str_replace('Email: ','',$email_info));
//            unset($mono_info[0]); // remove item at index 0
//            $mono_info = array_values($mono_info);
//            $mono_info_not_email = implode('<br>',$mono_info);
//
//            $name = $mono[1];
//            $pro = strtolower($mono[2]);
////            echo '<p>'.$pro.'</p>';
//            $aland = 0;
//            $giaotiep = 0;
//            $toeic = 0;
//            $ielts = 0;
//            if ( (strpos($pro, 'giao tiếp') !== false) ||(strpos($pro, 'giao tiẾp') !== false)) {
//                $giaotiep = 1;
//            }
//            if (strpos($pro, 'ielts') !== false) {
//                $ielts = 1;
//                $aland = 1;
//            }
//            if (strpos($pro, 'toeic') !== false) {
//                $toeic = 1;
//            }
//            $info = array(
//                'name' => $name,
//                'info' => $mono_info_not_email,
//                'email' => $email_info,
//                'giaotiep' => $giaotiep,
//                'toeic' => $toeic,
//                'ielts' => $ielts,
//                'aland' => $aland,
//                'avatar' => ''
//            );
//            echo '<pre>'; print_r($info); echo '</pre>';
////            $this->feedback->insert_teacher($info);
//        }

        exit;

        $hcm = array(
            ['Nguyễn Thị Thanh Tâm', 'Email: thanhtam.dthcm@imap.edu.vn| SĐT: 0764733010| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 15/21 Đặng Thị Rành, KP4, Phường Linh Tây, Quận Thủ Đức|Khu vực: HCM', 'Đào Tạo'],
            ['Nguyễn Duy Tường', 'Email: duytuong.anhngumshoa@gmail.com| SĐT: 0902504541| Ngày sinh : 15/03/1995|Cơ sở hay dạy: PDL|Điểm TOEIC/IELTS/ĐH: 970|Địa chỉ: chung cư A2, Phan Xích Long, phường 7, quận Phú Nhuận|Khu vực: HCM', 'TOEIC'],
            ['Hoàng Thị Thanh Loan', 'Email: loanhoang6291@gmail.com| SĐT: 0903156462| Ngày sinh : 33391|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 950/7.0|Địa chỉ: 187 Hoàng Hữu Nam, P. Tân Phú, Q.9|Khu vực: HCM', 'Đào Tạo'],
            ['Lê Thụy Ngọc Diễm', 'Email: ngocdiemjob@gmail.com| SĐT: 0938847315| Ngày sinh : 16/11/1988|Cơ sở hay dạy: SVH-PDL|Điểm TOEIC/IELTS/ĐH: 890|Địa chỉ: 623/36B CMT8 F15 Q10|Khu vực: HCM', 'TOEIC'],
            ['Võ Đăng Trình', 'Email: dangtrinhvo@gmail.com| SĐT: 0982055633| Ngày sinh : 32722|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: 980|Địa chỉ: 1050/17 phạm văn đồng, hiệp bình chánh, thủ đức|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Thị Ly', 'Email: Lynguyendqn1995@gmail.com| SĐT: 0386324660| Ngày sinh : 31/10/1995|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 340C/22 Hoàng Văn Thụ, phường 4, Tân Bình|Khu vực: HCM', 'IELTS'],
            ['Trần Huy Thạch', 'Email: rockee_chen@yahoo.com  rockee.chen@gmail.com| SĐT: 0989882860| Ngày sinh : 18/04/1990|Cơ sở hay dạy: BTH|Điểm TOEIC/IELTS/ĐH: HUFLIT|Địa chỉ: đường 4 Cư xá Đô Thành, P4, Q.3|Khu vực: HCM', 'IELTS'],
            ['Tô Gia Hòa', 'Email: togiahoa91@gmail.com| SĐT: 0365901335| Ngày sinh : 33370|Cơ sở hay dạy: PDL|Điểm TOEIC/IELTS/ĐH: 895|Địa chỉ: 110 Trường Sa P.15 Q.Bình Thạnh|Khu vực: HCM', 'TOEIC'],
            ['Đặng Lê Phương Uyên', 'Email: danglephuonguyen@gmail.com| SĐT: 0994999389| Ngày sinh : 14/12/1996|Cơ sở hay dạy: KDV-SVH-KH|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 217 Nguyễn Thái Học, P.Cầu Ông Lãnh, Quận 1|Khu vực: HCM', 'TOEIC'],
            ['Huỳnh Hữu Mạnh', 'Email: huumanhhuynh@gmail.com| SĐT: 0979386959| Ngày sinh : 20/05/1990|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: 960|Địa chỉ: 15 đường 5, khu phố 4, Linh Chiểu, Thủ Đức|Khu vực: HCM', 'TOEIC'],
            ['Võ Thị Yến Nhi', 'Email: phianhwa@gmail.com| SĐT: 0984092388| Ngày sinh : 23/09/1988|Cơ sở hay dạy: BTH-SVH|Điểm TOEIC/IELTS/ĐH: MA|Địa chỉ: 39/4 Hoàng Dư Khương Quận 10|Khu vực: HCM', 'TOEIC-GT'],
            ['Lương Thị Kim Ngân', 'Email: luongkimngan0206@gmail.com| SĐT: 0905538238| Ngày sinh : 20/06/1990|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 206/18 đường 20, quận Gò Vấp|Khu vực: HCM', 'IELTS'],
            ['Trần Thúy Nga', 'Email: tranthuyngaed@gmail.com| SĐT: 0353892392| Ngày sinh : 34399|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 915|Địa chỉ: 6/30 Phạm Văn Đồng, Phường 3, Quận Gò Vấp|Khu vực: HCM', 'TOEIC'],
            ['Lao Văn Minh Nhiên', 'Email: laom@tcd.ie| SĐT: 0938636341| Ngày sinh : 15/01/1985|Cơ sở hay dạy: CH|Điểm TOEIC/IELTS/ĐH: 980|Địa chỉ: 62, đường Võ Công Tồn, phường Tân Quý, quận Tân Phú, Tp. Hồ Chí Minh|Khu vực: HCM', 'TOEIC'],
            ['Từ Kim Loan', 'Email: loan.tk94@gmail.com| SĐT: 0373898926| Ngày sinh : 34679|Cơ sở hay dạy: BTH-ĐBP|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: 126 Lý Nam Đế P.7 Q.11|Khu vực: HCM', 'IELTS'],
            ['Lê Minh Đồng', 'Email: dg.domile@gmail.com| SĐT: 0398456567| Ngày sinh : 33888|Cơ sở hay dạy: PVT-KH|Điểm TOEIC/IELTS/ĐH: 990|Địa chỉ: 42 Trần Thánh Tông, phường 15, quận Tân Bình|Khu vực: HCM', 'TOEIC'],
            ['Ngô Thị Yến Nhi', 'Email: ngoyennhi2411@gmail.com| SĐT: 0936299174| Ngày sinh : 33918|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: 990|Địa chỉ: 813 tỉnh lộ 10, phường Bình Trị Đông B, quận Bình Tân|Khu vực: HCM', 'TOEIC'],
            ['Phạm Đăng Thùy Duyên', 'Email: phamdangthuyduyen@gmail.com| SĐT: 0948177718| Ngày sinh : 34619|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 504 Nguyễn Tất Thành, phường 18, quận 4|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Đình Thanh Trúc', 'Email: thanhtruc.nguyendinh@gmail.com| SĐT: 0989772411| Ngày sinh : 24/11/1990|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: 990|Địa chỉ: 36/30 Tân Mỹ, Phường Tân Thuân Tây, Quận 7, HCM|Khu vực: HCM', 'TOEIC'],
            ['Hoàng Ngọc Nam Phương', 'Email: hoangngocnamphuong@gmail.com| SĐT: 0965162415| Ngày sinh : 35890|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: Luật|Địa chỉ: Chung cư Era Town, đường số 15B, P. Phú Mỹ, Q.7, TP.HCM|Khu vực: HCM', 'GT'],
            ['Nguyễn Ngọc Nam Phương', 'Email: namphuong.nguyenngoc.1512@gmail.com| SĐT: 0374265215| Ngày sinh : 15/12/1998|Cơ sở hay dạy: BTH|Điểm TOEIC/IELTS/ĐH: 965|Địa chỉ: Chung cư D5, đường D5, F25, quận Bình Thạnh|Khu vực: HCM', 'GT-TOEIC'],
            ['Dương Tường Duyên', 'Email: duyenduongtuong111@gmail.com| SĐT: 0366799448| Ngày sinh : 35075|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7 (2016)|Địa chỉ: 15/5 Bùi Thế Mỹ, phường 10, quận Tân Bình|Khu vực: HCM', 'GT'],
            ['Nguyễn Văn Phương', 'Email: vanphuong.dthcm@imap.edu.vn| SĐT: 0968082439| Ngày sinh : 28/10/1992|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Hóc Môn|Khu vực: HCM', 'Đào Tạo'],
            ['Lê Bá Tùng', 'Email: tristan.tbl@gmail.com| SĐT: 0772957150| Ngày sinh : 24/08/1992|Cơ sở hay dạy: SVH-CH|Điểm TOEIC/IELTS/ĐH: 950, 8|Địa chỉ: 384/45 Lý Thái Tổ, phường 10, quận 10|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Ngọc Minh', 'Email: frances.minh@gmail.com| SĐT: 0908801001| Ngày sinh : 23/05/1985|Cơ sở hay dạy: PDL-KH|Điểm TOEIC/IELTS/ĐH: MA|Địa chỉ: 180 Tân Mỹ, Tân Thuận Tây, quận 7|Khu vực: HCM', 'TOEIC-IELTS'],
            ['Nguyễn Thị Y Ban', 'Email: bannguyen1707@gmail.com| SĐT: 00388 555 278| Ngày sinh : 17/07/1994|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: SGU|Địa chỉ: 2A/10 đường số 10, cư xá Gara, phường 13, quận 6|Khu vực: HCM', 'TOEIC'],
            ['Hoàng Đức Trường', 'Email: jakedth162@gmail.com| SĐT: 0931133141| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Khu vực: HCM', 'GT'],
            ['Ngô Khánh Linh', 'Email: Linhngokhanh93@gmail.com| SĐT: 0902648369| Ngày sinh : 34314|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 47/11A đường số 22, phường Phước Long B, quận 9|Khu vực: HCM', 'IELTS'],
            ['Trương Minh Thành', 'Email: tmthanh184@gmail.com| SĐT: 0335906787| Ngày sinh : 18/04/1992|Cơ sở hay dạy: SVH-CH|Điểm TOEIC/IELTS/ĐH: 955|Địa chỉ: 100/50 Nguyễn Ngọc Lộc, phường 14, quận 10|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Ngọc Quỳnh Trâm', 'Email: tramnguyen1307@gmail.com| SĐT: 0387780795| Ngày sinh : 13/07/1994|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: 865|Địa chỉ: 350 Tô Ngọc Vân, phường Tam Phú, Thủ Đức|Khu vực: HCM', 'TOEIC'],
            ['Bành Thái Bảo', 'Email: kenji1340@gmail.com| SĐT: 00935123353  0901632085| Ngày sinh : 30/09/1991|Cơ sở hay dạy: SVH-KH|Điểm TOEIC/IELTS/ĐH: 970|Địa chỉ: xã Bình Hưng, huyện Bình Chánh, TP. HCM|Khu vực: HCM', 'TOEIC-IELTS'],
            ['Nguyễn Ngọc Dũng', 'Email: dzungdav@gmail.com| SĐT: 0965646000| Ngày sinh : 15/07/1991|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: 915, 7|Địa chỉ: Quận 2|Khu vực: HCM', 'TOEIC'],
            ['Trần Trọng Vinh', 'Email: trongvinh.97@gmail.com| SĐT: 0352017783| Ngày sinh : 35776|Cơ sở hay dạy: PVT-PDL|Điểm TOEIC/IELTS/ĐH: 990|Địa chỉ: 105 Bình Quới, phường 27, quận Bình Thạnh|Khu vực: HCM', 'TOEIC-GT'],
            ['Nguyễn Thị Thu Thủy', 'Email: 286thuthuy@gmail.com| SĐT: 0703456306| Ngày sinh : 28/06/1994|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: chung cư K26, Dương Quảng Hàm, Gò Vấp|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Hà Minh Hiếu', 'Email: nguyenhaminhhieu0809@gmail.com| SĐT: 0926762659| Ngày sinh : 35651|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 369 lạc long quân phường 5 quận 11|Khu vực: HCM', 'IELTS'],
            ['Võ Trương Minh Tâm', 'Email: minhtamvotruong@gmail.com| SĐT: 0385754974| Ngày sinh : 14/11/1998|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 776/18A, Nguyễn Kiệm, phường 4, quận Phú Nhuận.|Khu vực: HCM', 'IELTS'],
            ['Đặng Nguyễn Anh Khoa', 'Email: Khodang1902@gmail.com| SĐT: 0703824812| Ngày sinh : 19/02/1996|Cơ sở hay dạy: BTH|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: chung cư Bông Sao, lô A, quận 8|Khu vực: HCM', 'IELTS-GT'],
            ['Lưu Hoàng Tuấn Duy', 'Email: luuhoangtuanduy@gmail.com| SĐT: 0346398903| Ngày sinh : 34853|Cơ sở hay dạy: CH|Điểm TOEIC/IELTS/ĐH: 915/7.5|Địa chỉ: 31-33 đường 21D, phường Bình Trị Đông B, quận Bình Tân|Khu vực: HCM', 'IELTS'],
            ['Phạm Văn Sang', 'Email: phamvansangvuc@gmail.com| SĐT: 0931727793| Ngày sinh : 27/07/1993|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 64 Lý Chính Thắng, quận 3|Khu vực: HCM', 'TOEIC'],
            ['Vũ Nguyễn Minh Huy', 'Email: vunguyenminhhuy@gmail.com| SĐT: 0932675396| Ngày sinh : 35278|Cơ sở hay dạy: CH|Điểm TOEIC/IELTS/ĐH: Nguyễn Tất Thành|Địa chỉ: 82/9 Huỳnh Văn Nghệ, phường 15, Tân Bình|Khu vực: HCM', 'GT'],
            ['Nguyễn Huỳnh Ngọc Trâm', 'Email: tiffany.nguyen1704@gmail.com| SĐT: 0977200072| Ngày sinh : 17/04/1995|Cơ sở hay dạy: BTH|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Tân Phú|Khu vực: HCM', 'GT'],
            ['Định Nguyệt Ánh', 'Email: dinhnguyetanh.ue@gmail.com| SĐT: 0962646239| Ngày sinh : 24/6/1997|Cơ sở hay dạy: SVH|Điểm TOEIC/IELTS/ĐH: 950|Địa chỉ: 200 Xóm Chiếu, phường 15, quận 4|Khu vực: HCM', 'TOEIC'],
            ['Cao Nhật Tuấn', 'Email: caonhattuan@gmail.com| SĐT: 0963436932| Ngày sinh : 34192|Cơ sở hay dạy: BTH-CH|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: 32/63 Quang Trung, phường 10, Gò Vấp|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Lê Thanh Vy', 'Email: thanhvyiuh@gmail.com| SĐT: 0931313896| Ngày sinh : 19/8/1993|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: IUH|Địa chỉ: 458/20/2B Huỳnh Tấn Phát, quận 7|Khu vực: HCM', 'TOEIC'],
            ['Vy Thị Kim Hoa', 'Email: vythikimhoa@gmail.com| SĐT: 0393618744| Ngày sinh : 24/11/1991|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: Nhân Văn|Địa chỉ: 1/50/2 Cư xá Thanh Đa, quận Bình Thạnh, TPHCM|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Thị Yến Nhi', 'Email: yennhinguyen1414@gmail.com| SĐT: 0367769791| Ngày sinh : 14/8/1994|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: UEH, TESOL|Địa chỉ: 161/19 Ni Sư Huỳnh Liên, phường 10, quận Tân Bình|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Ngọc Hải', 'Email: ngochainguyen705@gmail.com| SĐT: 0907051996| Ngày sinh : 34155|Cơ sở hay dạy: ĐBP|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: 304B lô C, cư xá Thanh Đa, phường 27, quận Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Dương Trần Nam', 'Email: trannam22111995@gmail.com| SĐT: 0981190599| Ngày sinh : 22/11/1995|Cơ sở hay dạy: PVT-ĐBP|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: 40/1 Lê Thị Hồng, phường 17, quận Gò Vấp|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Thị Tố Nga', 'Email: ngapk.105@gmail.com| SĐT: 0962569105| Ngày sinh : 29/11/1996|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 780 (2019)|Địa chỉ: 29/5D Thạch Thị Thanh, Tân Định, quận 1|Khu vực: HCM', 'GT'],
            ['Lê Thị Hoài Thương', 'Email: lethihoaithuongpk@gmail.com| SĐT: 0963960639| Ngày sinh : 35285|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 840|Địa chỉ: 55/107A/19 Thành Mỹ, phường 8, Tân Bình|Khu vực: HCM', 'TOEIC'],
            ['Bùi Thị Huyền Trang', 'Email: trangbui851995@gmail.com| SĐT: 0794734294| Ngày sinh : 34916|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 915|Địa chỉ: 36/9 Tăng Bạt Hổ, phường 11, quận Bình Thạnh|Khu vực: HCM', 'TOEIC'],
            ['Hồ Hải Tiến', 'Email: haitienho92@gmail.com| SĐT: 0356905857| Ngày sinh : 15/08/1992|Cơ sở hay dạy: BTH-PVT|Điểm TOEIC/IELTS/ĐH: 970, 7.5|Địa chỉ: 66/28 Nghĩa Thục, phường 5, quận 5|Khu vực: HCM', 'IELTS'],
            ['Trần Anh Phương', 'Email: phuongatrann@gmail.com| SĐT: 0523800919| Ngày sinh : 29/11/1995|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: Strayer University|Địa chỉ: 48/6/9 Tân Hóa, phường 1, quận 11|Khu vực: HCM', 'GT'],
            ['Lê Hồng Phúc', 'Email: phucccc98@gmail.com| SĐT: 0939358144| Ngày sinh : 15/5/1998|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: UEH|Địa chỉ: 263/47A Xóm Chiếu, quận 4|Khu vực: HCM', 'GT'],
            ['Nguyễn Hải Hà', 'Email: johnnguyen383107@gmail.com| SĐT: 0707858828| Ngày sinh : 34766|Cơ sở hay dạy: PVT-PDL|Điểm TOEIC/IELTS/ĐH: 930|Địa chỉ: 1005/9 tổ 3 khu phố 2, phường Đông Hưng Thuận, quận 12|Khu vực: HCM', 'TOEIC-IELTS'],
            ['Trần Đức Minh', 'Email: minhtia04@gmail.com| SĐT: 0904452252| Ngày sinh : 17/11/1989|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: 965|Địa chỉ: 12, đường 19, P. Phước Bình, Q.9, HCM|Khu vực: HCM', 'TOEIC'],
            ['Lý Gia Huy', 'Email: lyhuyhero@gmail.com| SĐT: 0835138712| Ngày sinh : 35288|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 273/69/25 Nguyễn Văn Đậu, phường 11, quận Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Đinh Hà Long', 'Email: longdinhha@gmail.com| SĐT: 0866527595| Ngày sinh : 34917|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 970|Địa chỉ: 405/24/19 Trường Chinh, phường 14, quận Tân Bình|Khu vực: HCM', 'TOEIC'],
            ['Trần Công Thành', 'Email: tcthanhlawst@gmail.com| SĐT: 0932719498| Ngày sinh : 13/2/1994|Cơ sở hay dạy: LVV-SVH-PVT-PDL|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 156/10 đường số 2, phường Tăng Nhơn Phú B, quận 9|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Châu Ngọc Quỳnh', 'Email: quinny.nguyen11@gmail.com| SĐT: 0901351016| Ngày sinh : 32269|Cơ sở hay dạy: CH-PVT|Điểm TOEIC/IELTS/ĐH: 985|Địa chỉ: 79/51 đường Phú Thọ Hòa, phường Phú Thọ Hòa, quận Tân Phú|Khu vực: HCM', 'GT'],
            ['Nguyễn Đức Đạt', 'Email: superdatnguyen@gmail.com| SĐT: 0337099390| Ngày sinh : 19/01/1997|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 6.5|Địa chỉ: 151 Dương Bá Trạc, phường 1, quận 8|Khu vực: HCM', 'IELTS'],
            ['Lê Ái Nhi', 'Email: mclee.jan@gmail.com| SĐT: 0784848082| Ngày sinh : 1989|Cơ sở hay dạy: ĐBP-BTH|Điểm TOEIC/IELTS/ĐH: 800, 7|Địa chỉ: Quận 10|Khu vực: HCM', 'IELTS'],
            ['Phùi Hương Thảo', 'Email: THAOPHUI@OUTLOOK.COM| SĐT: 0978858529| Ngày sinh : 15/02/1986|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 93B/1, Nguyễn Công Hoan, P7. Quận Phú Nhuận|Khu vực: HCM', 'IELTS'],
            ['Đặng Thị Tuyết Nhi', 'Email: dangthituyetnhidhanh2013@gmail.com| SĐT: 0798585201| Ngày sinh : 14/08/1995|Cơ sở hay dạy: PVT|Điểm TOEIC/IELTS/ĐH: Đồng Tháp|Địa chỉ: 79/20/23C Phạm Viết Chánh, phường 19, Bình Thạnh|Khu vực: HCM', 'TOEIC-GT'],
            ['Trần Hữu Danh', 'Email: tranhuudanh2405@gmail.com| SĐT: 0354005004| Ngày sinh : 24/05/1998|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 920, 7|Địa chỉ: 53/54 Trần Khánh Dư, phường Tân Định, quận 1|Khu vực: HCM', 'GT'],
            ['Nguyễn Ngọc Nhi', 'Email: stannyharvey@gmail.com| SĐT: 0773733506| Ngày sinh : 31/12/1997|Cơ sở hay dạy: PVT|Điểm TOEIC/IELTS/ĐH: 8|Địa chỉ: 23 Tú Mỡ, phường 7, quận Gò Vấp|Khu vực: HCM', 'GT'],
            ['Bùi Khánh Trúc', 'Email: buikhanhtruc212@gmail.com| SĐT: 0933211294| Ngày sinh : 21/12/1994|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: 890|Địa chỉ: B7 khu dân cư Tân Thuận Nam, đường Phú Thuận, phường Phú Thuận, quận 7|Khu vực: HCM', 'GT'],
            ['Tất Duy Khải', 'Email: tatduykhai@gmail.com| SĐT: 0786388387| Ngày sinh : 22/11/1994|Cơ sở hay dạy: CH-BTH|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 37/8/2B đường số 6, phường Bình Hưng Hòa A, quận Bình Tân|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Ngọc Diệp', 'Email: Ngocdiepnguyen.ftu@gmail.com| SĐT: 0392680796| Ngày sinh : |Cơ sở hay dạy: CH-PVT|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: |Khu vực: HCM', 'IELTS'],
            ['Liêu Quốc Sơn', 'Email: quocson.lieu@gmail.com| SĐT: 0913985454| Ngày sinh : 33735|Cơ sở hay dạy: KH-PDL-SVH|Điểm TOEIC/IELTS/ĐH: 940, 7.5|Địa chỉ: 58 Hoa Sứ, phường 7, quận Phú Nhuận|Khu vực: HCM', 'TOEIC-IELTS'],
            ['Bùi Tùng Dương', 'Email: tungduongbui.ftu@gmail.com| SĐT: 0904234722| Ngày sinh : 17/06/1995|Cơ sở hay dạy: PVT|Điểm TOEIC/IELTS/ĐH: đang chờ|Địa chỉ: 15 An Nhơn, phường 13, quận Gò Vấp|Khu vực: HCM', 'TOEIC'],
            ['Trần Hoàng Phương', 'Email: phuongtran.1429@gmail.com| SĐT: 0943371719| Ngày sinh : 18/10/1998|Cơ sở hay dạy: PDL|Điểm TOEIC/IELTS/ĐH: 910|Địa chỉ: 59 đường Hồ Thành Biên, phường 4, quận 8|Khu vực: HCM', 'TOEIC-GT'],
            ['Nguyễn Thành Luân', 'Email: kristic238@gmail.com| SĐT: 0938984357| Ngày sinh : 1992|Cơ sở hay dạy: CH-PVT-ĐBP|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: Thủ Đức|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Mai Thảo Chi', 'Email: chirst_chichi19@yahoo.com| SĐT: 0903804929| Ngày sinh : 32915|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 12 đường Phan Huy Thực, phường Tân Kiểng, quận 7|Khu vực: HCM', 'TOEIC-GT'],
            ['Nguyễn Tuấn', 'Email: jamie.key1407@gmail.com| SĐT: 0934074698| Ngày sinh : 14/07/1993|Cơ sở hay dạy: KH|Điểm TOEIC/IELTS/ĐH: Hùng Vương|Địa chỉ: 47/1 đường 59, phường Thảo Điền, quận 2|Khu vực: HCM', 'GT'],
            ['Trương Thị Minh Thư', 'Email: thuminhthu1701@gmail.com| SĐT: 0939722099| Ngày sinh : 17/01/1995|Cơ sở hay dạy: CH-PVT|Điểm TOEIC/IELTS/ĐH: TĐT|Địa chỉ: 118/57/30 liên khu 56, Bình Hưng Hòa B, Bình Tân|Khu vực: HCM', 'TOEIC-GT'],
            ['Hoàng Thị Quỳnh Như', 'Email: nhuhoang.hcm@gmail.com| SĐT: 0902604613| Ngày sinh : 34367|Cơ sở hay dạy: PVT-ĐBP|Điểm TOEIC/IELTS/ĐH: HUTECH|Địa chỉ: 194/4/3 đường Bùi Đình Túy, phường 12, quận Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Huỳnh Hồ Trúc Thanh', 'Email: htthanhhuynh1708@gmail.com| SĐT: 0779169176| Ngày sinh : 17/08/1994|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: TĐT|Địa chỉ: 967/39 Trần Xuân Soạn, quận 7|Khu vực: HCM', 'IELTS'],
            ['Trương Ngọc Phương Trinh', 'Email: truongngocphuongtrinhes.mn@gmail.com| SĐT: 0965170307| Ngày sinh : 17/3/1996|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 885|Địa chỉ: 72/2 Ngô Quyền, phường 5, quận 10|Khu vực: HCM', '0'],
            ['Trần Tú Trinh', 'Email: trantutrinh2708@gmail.com| SĐT: 0833105091| Ngày sinh : 27/08/1993|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 920|Địa chỉ: 24C đường 40, phường Hiệp Bình Chánh, Thủ Đức|Khu vực: HCM', 'TOEIC'],
            ['Trần Thị Mỹ Linh', 'Email: linhtran0010@gmail.com| SĐT: 0904601095| Ngày sinh : 29/8/1994|Cơ sở hay dạy: LVV|Điểm TOEIC/IELTS/ĐH: sư phạm|Địa chỉ: 149 Linh Trung, phường Linh Trung, quận Thủ Đức|Khu vực: HCM', 'TOEIC'],
            ['Phạm Quang Minh', 'Email: andrewpham330@gmail.com| SĐT: 0916551473| Ngày sinh : 1996|Cơ sở hay dạy: PDL-LVV|Điểm TOEIC/IELTS/ĐH: 855, 6.5|Địa chỉ: 125/42/1 Bùi Đình Túy, phường 24, quận Bình Thạnh|Khu vực: HCM', 'TOEIC'],
            ['Phạm Việt Hoàng', 'Email: tp.hpham@gmail.com| SĐT: 0337081420| Ngày sinh : 32671|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: Columbia College Chicago|Địa chỉ: 316A Phan Văn Trị, Q. Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Diệu Anh', 'Email: ndieuanh11@gmail.com| SĐT: 0394866969| Ngày sinh : 14/11/1993|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: 5D Phổ Quang, phường 2, Tân Bình|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Thị Kim Thanh', 'Email: thanh.nguyenthikimvn@gmail.com| SĐT: 0908938190| Ngày sinh : 13/3/1995|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: IELTS 6.5|Địa chỉ: 441/20 Nguyễn Đình Chiểu, phường 5 quận 3|Khu vực: HCM', 'GT'],
            ['Lại Huỳnh Thanh Trúc', 'Email: thanhtruc.laihuynh@gmail.com| SĐT: 0338371551| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 79/51/48 Thống Nhất hường 11 quận Gò Vấp|Khu vực: HCM', 'IELTS'],
            ['Vũ Thanh Thùy', 'Email: thuythanh25@gmail.com| SĐT: 0975448069| Ngày sinh : 25/5/1987|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: ĐHSP, TOEIC 820|Địa chỉ: chung cư Bông Sao, lô B1, 892 Tạ Quang Bửu, phường 5, quận 8|Khu vực: HCM', 'IELTS'],
            ['Phạm Ngọc Linh', 'Email: P.ngoclinh1009@gmail.com| SĐT: 0906540829| Ngày sinh : 34981|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: IELTS 6.5, Law|Địa chỉ: 47/24/4A đường Bùi Đình Túy, phường 24 , quận Bình Thạnh|Khu vực: HCM', 'GT'],
            ['Jim Nguyễn', 'Email: jnguyen.designer@gmail.com| SĐT: 0784023588| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Khu vực: HCM', 'IELTS-GT'],
            ['Trần Phạm Nhật Vinh', 'Email: tpnvinh@gmail.com| SĐT: 0944119191| Ngày sinh : 30/4/1998|Cơ sở hay dạy: PVT-BTH|Điểm TOEIC/IELTS/ĐH: 930|Địa chỉ: 469/41A Nguyễn Kiệm, Phường 9, Quận Phú Nhuận|Khu vực: HCM', 'GT-TOEIC'],
            ['Nguyễn Duy Linh', 'Email: mbpfws@gmail.com| SĐT: 0903999029| Ngày sinh : 32183|Cơ sở hay dạy: BTH-ĐBP|Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: 664/7 Cách Mạng Tháng 8, F5, Quận Tân Bình.|Khu vực: HCM', 'IELTS'],
            ['Phạm Thị Hải Yến', 'Email: Haiyen3112130186@gmail.com| SĐT: 0963422133| Ngày sinh : 25/06/1994|Cơ sở hay dạy: ĐBP-PVT|Điểm TOEIC/IELTS/ĐH: SGU|Địa chỉ: 149 đường Long Sơn Phường Long Bình Quận 9 TPHCM|Khu vực: HCM', 'IELTS'],
            ['Trần Lê Trung Tín', 'Email: tintran29051003@gmail.com| SĐT: 0932360712| Ngày sinh : 1993|Cơ sở hay dạy: SVH|Điểm TOEIC/IELTS/ĐH: 950|Địa chỉ: 526/12/10C Xô viết nghệ tĩnh/f25/q. Bình thạnh|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Tấn Hoàng', 'Email: johnng244@gmail.com| SĐT: 0707720111| Ngày sinh : 24/4/1994|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: RMIT|Địa chỉ: 224/10/10 Ung Văn Khiêm, phường 25, quận Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Kỳ Vinh Hiển', 'Email: kivinhhien@gmail.com| SĐT: 0906924995| Ngày sinh : |Cơ sở hay dạy: CH-PVT|Điểm TOEIC/IELTS/ĐH: TĐT|Địa chỉ: |Khu vực: HCM', 'IELTS'],
            ['Vũ Ngọc Thùy Linh', 'Email: LinhSurynn@gmail.com| SĐT: 0908905203| Ngày sinh : 35196|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 1072/14 Kha Vạn Cân, phường Linh Chiểu, quận Thủ Đức|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Minh Tân', 'Email: edgardnguyen97@gmail.com| SĐT: 0949815017| Ngày sinh : 35530|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 875|Địa chỉ: 342/7 Lý Thường Kiệt, Tân Bình|Khu vực: HCM', 'TOEIC'],
            ['Dương Hồng Hạnh', 'Email: duonghonghanh.ftu@gmail.com| SĐT: 0789707075| Ngày sinh : 21/07/1995|Cơ sở hay dạy: BTH-CH-PVT|Điểm TOEIC/IELTS/ĐH: 7|Địa chỉ: 297/43/39 Phan Huy Ích, phường 14, Gò Vấp, HCM|Khu vực: HCM', 'GT'],
            ['Đỗ Thị Duy Hiền', 'Email: hoadaquy2701@gmail.com| SĐT: 0961461707| Ngày sinh : |Cơ sở hay dạy: SVH-KH|Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Khu vực: HCM', 'TOEIC-GT'],
            ['Trần Thị Thanh Tú', 'Email: tu.fragrancy@gmail.com| SĐT: 0987121278| Ngày sinh : 23/2/1986|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: nhân văn|Địa chỉ: 436B/71B/3 Sư Vạn Hạnh, Phường 12, Quận 10|Khu vực: HCM', 'GT'],
            ['Nguyễn Trọng Thành', 'Email: trong.nt467@gmail.com| SĐT: 0909689324| Ngày sinh : 35526|Cơ sở hay dạy: BTH-CH|Điểm TOEIC/IELTS/ĐH: Hoa Sen (chưa tốt nghiệp)|Địa chỉ: 95/11 Hoàng Bật Đạt, phường 15, quận Tân Bình|Khu vực: HCM', 'GT'],
            ['Phan Nhân Ái', 'Email: phanthuynhanai@gmail.com| SĐT: 0905361695| Ngày sinh : 34643|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 783 Trần Xuân Soạn, quận 7|Khu vực: HCM', 'GT'],
            ['Nguyễn Thu Hà', 'Email: ng.thuha410@gmail.com| SĐT: 0769212678| Ngày sinh : 35165|Cơ sở hay dạy: PVT-CH|Điểm TOEIC/IELTS/ĐH: 920|Địa chỉ: 292/4 Bình Lợi, Phường 13, Quận Bình Thạnh, TP Hồ Chí Minh|Khu vực: HCM', 'TOEIC'],
            ['Nguyễn Bé Dợn', 'Email: bedonnguyenda10av@gmail.com| SĐT: 0961969089| Ngày sinh : 1992|Cơ sở hay dạy: SVH-KH|Điểm TOEIC/IELTS/ĐH: Trà Vinh|Địa chỉ: 117 Lê Đình Thám, Tân Quý, Tân Phú, Tp. HCM|Khu vực: HCM', 'TOEIC'],
            ['Trần Phương Khanh', 'Email: khanhtran289@gmail.com| SĐT: 0794919399| Ngày sinh : 28/9/1995|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 7.5|Địa chỉ: 41 đường 36, phường Linh Đông, quận Thủ Đức|Khu vực: HCM', 'IELTS'],
            ['Lê Ngọc Phương Trinh', 'Email: le37t@mtholyoke.edu| SĐT: 0833777967| Ngày sinh : 13/7/1997|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 31/80 đường Phan Huy Ích, phường 15, quận Tân Bình|Khu vực: HCM', 'IELTS'],
            ['Trần Nguyễn Phương Uyên', 'Email: uyenphuong.nguyen0827@gmail.com| SĐT: 0923876606| Ngày sinh : 27/8/1993|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: 6.5|Địa chỉ: 136/36 Hậu Giang, phường 6, quận 6|Khu vực: HCM', 'GT'],
            ['Lại Thị Hồng Hạnh', 'Email: honghanh.2799@gmail.com| SĐT: 0705588155| Ngày sinh : 35317|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 308/10 Nguyễn Thượng Hiền, Phú Nhuận|Khu vực: HCM', 'TOEIC'],
            ['Trương Hoàng Long', 'Email: hoanglongtruong416@gmail.com| SĐT: 0933772287| Ngày sinh : 35132|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: TOEFL 98/120|Địa chỉ: 377/35 Lê Quang Định, Phường 2, Bình Thạnh|Khu vực: HCM', 'GT'],
            ['Võ Lê Đông Kha', 'Email: voledongkha2011@gmail.com| SĐT: 0365679131| Ngày sinh : 20/11/1995|Cơ sở hay dạy: BTH, ĐBP, CH|Điểm TOEIC/IELTS/ĐH: FTU, IELTS 7|Địa chỉ: 82/54 Đinh Tiên Hoàng, phường 1, Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Hoàng Trần Kiều Chi', 'Email: chihoang2702@gmail.com| SĐT: 0(092) 519- 2696 081-747-5308| Ngày sinh : 27/2/1991|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: CĐKinh Tế đối ngoạiIELTS 5.5 (2015)|Địa chỉ: 91B/105 khu phố 1, phường Tân Phong, Đồng Nai|Khu vực: HCM', 'IELTS'],
            ['Bùi Thị Phượng', 'Email: btp5797@gmail.com| SĐT: 0906284320| Ngày sinh : 35557|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: HUTECH|Địa chỉ: 69/1/16 đường Nguyễn Gia Trí, phường 25, Bình Thạnh|Khu vực: HCM', 'IELTS'],
            ['Nguyễn Hoàng Dung', 'Email: hoangdungnguyen1710@gmail.com| SĐT: 0364694498| Ngày sinh : 17/10/1998|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: UEH|Địa chỉ: 43 đường số 85, phường Tân Quy, quận 7|Khu vực: HCM', 'GT'],
            ['Dương Phương Đông', 'Email: pdong2608@gmail.com| SĐT: 0912260897| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: 62 đường 41, phường Tân Phong, quận 7|Khu vực: HCM', 'GT'],
            ['Trần Nguyễn Ngọc Hoàng Phụng', 'Email: trannnhphung@gmail.com| SĐT: 0779609522| Ngày sinh : 13/4/1995|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: Nông Lâm|Địa chỉ: 14 đường Bác Ái, phường Bình Thọ, quận Thủ Đức|Khu vực: HCM', 'GT'],
            ['Trần Công Hoàng', 'Email: tranconghoang905@gmail.com| SĐT: 0942852905| Ngày sinh : |Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: |Địa chỉ: |Khu vực: HCM', 'GT'],
            ['Nguyễn Thị Quỳnh', 'Email: Quynhnguyen.ftu2@gmail.com| SĐT: 0938947685| Ngày sinh : 30/3/1992|Cơ sở hay dạy: |Điểm TOEIC/IELTS/ĐH: FTU|Địa chỉ: chung cư the estella, đường số 25, block 4B, nhà 1404, phường An Phú, quận 2|Khu vực: HCM', 'IELTS'],
        );
        foreach ($hcm as $mono) {
            $info = $mono[1];
//            $info = str_replace('|','<br>',$info);
            $mono_info = explode('|', $info);
////            var_dump($mono_info);
            $email_info = $mono_info[0];
            $email_info = trim(str_replace('Email: ', '', $email_info));
            unset($mono_info[0]); // remove item at index 0
            $mono_info = array_values($mono_info);
            $mono_info_not_email = implode('<br>', $mono_info);

            $name = $mono[0];
            $pro = strtolower($mono[2]);
//            echo '<p>'.$pro.'</p>';
            $aland = 0;
            $giaotiep = 0;
            $toeic = 0;
            $ielts = 0;
            if ((strpos($pro, 'Đào tạo') !== false) || (strpos($pro, 'đào tạo') !== false)) {
                $aland = 1;
                $giaotiep = 1;
                $toeic = 1;
                $ielts = 1;
            }
            if (strpos($pro, 'ielts') !== false) {
                $ielts = 1;
                $aland = 1;
            }
            if (strpos($pro, 'toeic') !== false) {
                $toeic = 1;
            }
            if (strpos($pro, 'gt') !== false) {
                $giaotiep = 1;
            }
            $info = array(
                'name' => $name,
                'email' => $email_info,
                'info' => $mono_info_not_email,
                'giaotiep' => $giaotiep,
                'toeic' => $toeic,
                'ielts' => $ielts,
                'aland' => $aland,
                'avatar' => ''
            );
            echo '<pre>';
            print_r($info);
            echo '</pre>';
            $this->feedback->insert_teacher($info);
        }

    }

    public function def(){
        $this->load->model('Feedback_model', 'feedback');
//        $this->feedback->mark_point_class2('B384');
        $this->__mark_all_class_FORCE('');
    }


    /**
     * NOTE:
     * Chấm điểm lại tất cả các lớp từ đầu, ko dựa vào mẫu đánh dấu
     * @param $type
     */
    private function __mark_all_class_FORCE($type){
        $this->load->model('Feedback_model', 'feedback');
        $this->feedback->mark_point_all_class();
    }

    public function feedback_phone_detail_old(){
        $this->guard();
        $this->guard_admin_manager();
        // md bootstrap
        // Quản lý danh sách lớp
        // Quản lý danh sách giảng viên
        // 1 view
        //
        $this->load->model('Feedback_model', 'feedback');

//        $this->_mark_all_class('');

        $top_class_ielts = $this->feedback->get_top_class_feedback_newest(15, 'ielts');
        $top_class_toeic = $this->feedback->get_top_class_feedback_newest(15, 'toeic');
        $top_class_giaotiep = $this->feedback->get_top_class_feedback_newest(15, 'giaotiep');
        $top_class_aland = $this->feedback->get_top_class_feedback_newest(15, 'aland');

        // lazy code
        $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_newest(100000);
        $array_class_code_feedback_phone = array();
        $array_class_code_feedback_phone_type = array(); // ielts => array()
        for ($i = 0; $i < count($list_feedback_phone_newestSS); $i++) {
            $mono = $list_feedback_phone_newestSS[$i];
            $class_code_mono = $mono['class_code'];
            if (! in_array($class_code_mono,$array_class_code_feedback_phone)){
                array_push($array_class_code_feedback_phone,$class_code_mono);
            }
        }

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $supermono_classcode = $array_class_code_feedback_phone[$i];
            if ($this->feedback->check_class_code_exist($supermono_classcode)){
                $info_class_super = $this->feedback->get_info_class_by_class_code($supermono_classcode);
                $type = $info_class_super['type'];
                if(! isset($array_class_code_feedback_phone_type[$type])){
                    $array_class_code_feedback_phone_type[$type] = array();
                }
                array_push($array_class_code_feedback_phone_type[$type],$supermono_classcode);
            }
        }


        // ======== Lấy điểm của lớp
        $arr_info_class = array(); // class_code => class_info

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $su_per_class_code = $array_class_code_feedback_phone[$i];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }

        $arr_new_feedback_form = array_merge($top_class_ielts,$top_class_toeic,$top_class_giaotiep,$top_class_aland);

        for ($i = 0; $i < count($arr_new_feedback_form); $i++) {
            $su_per_class_info = $arr_new_feedback_form[$i];
            $su_per_class_info_live = json_decode($su_per_class_info,true);
            $su_per_class_code = $su_per_class_info_live[1];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }

        //  [0] => ["ielts","Pre707"]

//        echo '<pre>'; print_r($array_class_code_feedback_phone_type); echo '</pre>'; exit;

        // =========== end lazy code

        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');
        $list_feedback_newest = array_slice($list_feedback_newest, 0, 200); // 100 feed back mới nhất



        $list_feedback_phone_newest = $this->feedback->get_list_feedback_phone_newest(500);

//        echo '<pre>'; print_r($list_feedback_newest); echo '</pre>';
//        echo '<pre>'; print_r($list_feedback_phone_newest); echo '</pre>';
//        exit;

        $info = $this->feedback->get_all_info_system();


        $teacher_info = $this->feedback->get_list_info_teacher();
        $arr_techer_id_to_teacher_info = array();
        for ($i = 0; $i < count($teacher_info); $i++) {
            $mono_teacher_info = $teacher_info[$i];
            $arr_techer_id_to_teacher_info[$mono_teacher_info['teacher_id']] = $mono_teacher_info;
        }
        $location_info = $this->feedback->get_list_location();
        $arr_location_id_to_location_info = array();
        for ($i = 0; $i < count($location_info); $i++) {
            $mono_location_info = $location_info[$i];
            $arr_location_id_to_location_info[$mono_location_info['id']] = $mono_location_info;
        }


        $info_giaotiep = $this->feedback->get_all_info_system_by_type('giaotiep');
        $info_toeic = $this->feedback->get_all_info_system_by_type('toeic');
        $info_ielts = $this->feedback->get_all_info_system_by_type('ielts');
        $info_aland = $this->feedback->get_all_info_system_by_type('aland');
        $data = array(
            'list_feedback_newest' => $list_feedback_newest, // feedback form
            'list_feedback_phone_newestSS' => $list_feedback_phone_newestSS,
            'array_class_code_feedback_phone_type' => $array_class_code_feedback_phone_type,
            'arr_info_class' => $arr_info_class,
            'info_giaotiep' => $info_giaotiep,
            'info_toeic' => $info_toeic,
            'info_ielts' => $info_ielts,
            'info_aland' => $info_aland,
            'arr_location_id_to_location_info' => $arr_location_id_to_location_info,
            'arr_techer_id_to_teacher_info' => $arr_techer_id_to_teacher_info,
        );
        $data = array_merge($data, $info);

        $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback');
    }

    public function fix_email()
    {
        $this->load->model('Feedback_model', 'feedback');

        // hyv98812@gmail.com
        $arrr = $this->feedback->get_list_class_info_by_time($type = '', array(
            'min_opening' => '2019/6/1',
            'max_opening' => '2019/12/31',
        ));
        echo '<pre>';
        print_r($arrr);
        echo '</pre>';


    }

    public function class_2()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.

        $this->guard();
        $this->guard_admin_manager();

        $this->_mark_all_class('');
        $this->load->model('Feedback_model', 'feedback');
        $class_info_raw = $this->feedback->get_list_class_info();
        $class_info_raw = array_reverse($class_info_raw);
        $class_info = array();

        foreach ($class_info_raw as $item) {
            $point = $item['point'];
            $id_location = $item['id_location'];
            $type = $item['type'];
            $list_teacher_live = json_decode($item['list_teacher'], true);


            if (isset($_GET['min']) && (is_numeric($_GET['min']))) {
                $min = (float)$_GET['min'];
                if ($point < $min) {
                    continue;
                }
            }

            if (isset($_GET['max']) && (is_numeric($_GET['max']))) {
                $max = (float)$_GET['max'];
                if ($point > $max) {
                    continue;
                }
            }

            if (isset($_GET['location'])) {
                $location = $_GET['location'];
                $location = json_decode($location, true);
                if (!in_array($id_location, $location)) {
                    continue;
                }
            }

            if (isset($_GET['type'])) {
                $type_filter = $_GET['type'];
                $type_filter = json_decode($type_filter, true);
                if (!in_array($type, $type_filter)) {
                    continue;
                }
            }

            if (isset($_GET['teacher'])) {
                $teacher_filter = $_GET['teacher'];
                $teacher_filter = json_decode($teacher_filter, true);

                $led = false;
                for ($i = 0; $i < count($list_teacher_live); $i++) {
                    $mono_id_teacher = (string)$list_teacher_live[$i];
                    if (in_array($mono_id_teacher, $teacher_filter)) {
                        $led = true;
                    }
                }
                if (!$led) continue;
            }

            // ============ get list area

            if (isset($_GET['area'])) {
                $area = $_GET['area'];
                $area = json_decode($area, true);

                $list_id_location_filter = array();
                foreach ($area as $area_mono) {
                    $res_location = $this->feedback->get_list_location($area_mono);
                    foreach ($res_location as $item_location) {
                        $id_location_this = $item_location['id'];
                        array_push($list_id_location_filter, $id_location_this);
                    }
                }

                if (!in_array($id_location, $list_id_location_filter)) {
                    continue;
                }
            }

            array_push($class_info, $item);
        }

        foreach ($class_info as &$mono_class_info) {
            $time_start = $mono_class_info['time_start'];
            $time_end = $mono_class_info['time_end'];
            $mono_class_info['time_start_client'] = date('Y-m-d' . '\T' . "H:i", $time_start); // 2000-01-01T00:00:00
            $mono_class_info['time_end_client'] = date('Y-m-d' . '\T' . "H:i", $time_end);
            $mono_class_info['number_feedback_form'] = $this->feedback->get_number_feedback_form_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_slide'] = $this->feedback->get_number_feedback_slide_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_phone'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code']);
        }

        $teacher_info = $this->feedback->get_list_info_teacher();
        $location_info = $this->feedback->get_list_location();


        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $data = array(
            'class_info' => $class_info,
            'teacher_info' => $teacher_info,
            'location_info' => $location_info,
            'teacher_id_to_name' => $teacher_id_to_name,
        );

//        echo '<pre>';
//        print_r($class_info);
//        echo '</pre>';
//        exit;

        $this->load->layout('feedback/class', $data, false, 'layout_feedback');
    }

    // cái này cho feedback_paper cũ để tổng hợp cuối năm
    public function class_3()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.

        $this->guard();

        $class_code = array('Pre2639', 'Pre2635', 'Pre2638', 'Pre2575A', 'pre2575B', 'A1882', 'A1833B', 'Pre2578', 'A1881B', 'Pre2577', 'A1830A');
        $this->db->where_in("class_code",$class_code);
        $this->db->select('*');
        $query = $this->db->get('feedback_class');
        $class_info = $query->result_array();

        $this->load->model('Feedback_model', 'feedback');

        foreach ($class_info as &$mono_class_info) {
            $mono_class_info['point'] = $this->feedback->mark_point_class_paper($mono_class_info['class_code']);
            $time_start = $mono_class_info['time_start'];
            $time_end = $mono_class_info['time_end'];
            $mono_class_info['time_start_client'] = date('Y-m-d' . '\T' . "H:i", $time_start); // 2000-01-01T00:00:00
            $mono_class_info['time_end_client'] = date('Y-m-d' . '\T' . "H:i", $time_end);
            $mono_class_info['number_feedback_form'] = $this->feedback->get_number_feedback_form_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_slide'] = $this->feedback->get_number_feedback_slide_by_class_code($mono_class_info['class_code']);
            $mono_class_info['number_feedback_phone'] = $this->feedback->get_number_feedback_phone_by_class_code($mono_class_info['class_code']);
        }

        $teacher_info = $this->feedback->get_list_info_teacher();
        $location_info = $this->feedback->get_list_location();

        $teacher_id_to_name = array();
        for ($k = 0; $k < count($teacher_info); $k++) {
            $id_teacher = $teacher_info[$k]['teacher_id'];
            $teacher_id_to_name[$id_teacher] = $teacher_info[$k]['name'];
        }

        $data = array(
            'class_info' => $class_info,
            'teacher_info' => $teacher_info,
            'location_info' => $location_info,
            'teacher_id_to_name' => $teacher_id_to_name,
        );

        $this->load->layout('feedback/class', $data, false, 'layout_feedback_tuvan');
    }

    public function feedback_phone_detail(){
        guard();
        guard_admin_manager();

        $del = false;
        if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
            $del = true;
        }

        $this->load->model('Feedback_model', 'feedback');
        if(count($_REQUEST) > 0) {
            if (isset($_REQUEST['starttime'])) {
                $starttime = strtotime(strip_tags($_REQUEST['starttime']));
            }

            if (isset($_REQUEST['endtime'])) {
                $endtime = strtotime(strip_tags($_REQUEST['endtime']));
            }

            if (isset($_REQUEST['class'])) {
                $class_code = strip_tags($_REQUEST['class']);
            }

            if (isset($_REQUEST['location'])) {
                $location = $_REQUEST['location'];
                $location = json_decode($location, true);
            }

            if (isset($_REQUEST['area'])) {
                $area = $_REQUEST['area'];
                $area = json_decode($area, true);
            }
            // lazy code
            $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_filter(1000, $starttime, $endtime, $class_code, $area, $location);
        } else {
            $list_feedback_phone_newestSS = $this->feedback->get_list_feedback_phone_newest(1000);
        }


        $array_class_code_feedback_phone = array();
        $array_class_code_feedback_phone_type = array(); // ielts => array()
        for ($i = 0; $i < count($list_feedback_phone_newestSS); $i++) {
            $mono = $list_feedback_phone_newestSS[$i];
            $class_code_mono = $mono['class_code'];
            if (! in_array($class_code_mono,$array_class_code_feedback_phone)){
                array_push($array_class_code_feedback_phone,$class_code_mono);
            }
        }

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $supermono_classcode = $array_class_code_feedback_phone[$i];
            if ($this->feedback->check_class_code_exist($supermono_classcode)){
                $info_class_super = $this->feedback->get_info_class_by_class_code($supermono_classcode);
                $type = $info_class_super['type'];
                if(! isset($array_class_code_feedback_phone_type[$type])){
                    $array_class_code_feedback_phone_type[$type] = array();
                }
                array_push($array_class_code_feedback_phone_type[$type],$supermono_classcode);
            }
        }

        // ======== Lấy điểm của lớp
        $arr_info_class = array(); // class_code => class_info

        for ($i = 0; $i < count($array_class_code_feedback_phone); $i++) {
            $su_per_class_code = $array_class_code_feedback_phone[$i];
            if (isset($arr_info_class[$su_per_class_code])){continue; }
            $arr_info_class[$su_per_class_code] = $this->feedback->get_info_class_by_class_code($su_per_class_code);
        }


        $list_feedback_newest = $this->feedback->get_list_feedback_paper('', '', 'time_end');
        $list_feedback_newest = array_slice($list_feedback_newest, 0, 200); // 100 feed back mới nhất


        $teacher_info = $this->feedback->get_list_info_teacher();
        $arr_techer_id_to_teacher_info = array();
        for ($i = 0; $i < count($teacher_info); $i++) {
            $mono_teacher_info = $teacher_info[$i];
            $arr_techer_id_to_teacher_info[$mono_teacher_info['teacher_id']] = $mono_teacher_info;
        }
        $location_info = $this->feedback->get_list_location();
        $arr_location_id_to_location_info = array();
        for ($i = 0; $i < count($location_info); $i++) {
            $mono_location_info = $location_info[$i];
            $arr_location_id_to_location_info[$mono_location_info['id']] = $mono_location_info;
        }

        $data = array(
            'list_feedback_newest' => $list_feedback_newest, // feedback form
            'list_feedback_phone_newestSS' => $list_feedback_phone_newestSS,
            'array_class_code_feedback_phone_type' => $array_class_code_feedback_phone_type,
            'arr_info_class' => $arr_info_class,
            'location_info' => $location_info,
            'arr_location_id_to_location_info' => $arr_location_id_to_location_info,
            'arr_techer_id_to_teacher_info' => $arr_techer_id_to_teacher_info,
            'del' => $del,
        );

        $this->load->layout('feedback/feedback_phone_detail', $data, false, 'layout_feedback');
    }
}
