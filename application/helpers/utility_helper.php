<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// feedback

function guard()
{
    if (check_login()) {

    } else {
        redirect('/feedback/login');
    }
}

function guard_admin_manager()
{
    guard();
    $res = false;
    if (($_SESSION['role'] == 'admin') || ($_SESSION['role'] == 'manager')) {
        $res = true;
    }
    if (!$res) {
        redirect('/feedback/class_tuvan');
//            echo 'Bạn không đủ quyền truy cập chức năng này.';
        exit;
    }
}

function check_login()
{
    if (isset($_SESSION['token']) && isset($_SESSION['username'])) {
        $token = $_SESSION['token'];
        $username = $_SESSION['username'];
        $token_check = md5($username . '_feedback_sys_Aug_2019');
        if ($token === $token_check) {
            return true;
        }
        session_destroy();
    }

    return false;
}

function logout()
{
    session_start();
    session_destroy();
    redirect('/feedback/login');
}

// trung bình cộng
function tbc($arr_val,$skip_zero = true,$number_digit = 2){
    if ( (!is_array($arr_val)) || (count($arr_val) == 0) ) return 0;

    $sum = 0;
    $count = 0;
    foreach ($arr_val as $mono_val){
        if ($mono_val == 0){
            if (! $skip_zero) $count ++;
        }else{
            $sum += $mono_val;
            $count ++ ;
        }
    }
    if ($count == 0) return 0;
    return round($sum / $count,$number_digit);
}

function get_array($array)
{
	if (is_array($array)){
      foreach ($array as $a){
         get_array($a);
	  }
	}
    else{
        echo $array;
    }
}
/**
 * type=1: datetime to timestamp
        2: timestamp to datetime
 **/
function convert_datetime($str,$type = 1)
{
    if(empty($str)){
        return NULL;
    }
    switch ($type){
        case 1:
        list($date, $time) = explode(' ', $str);
        list($day, $month, $year) = explode('/', $date);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        break;
        case 2:
        $timestamp = date('Y-m-d H:i:s', $str);
        break;
        case 3:

        list($year , $month , $day) = explode('-', $str);
        $timestamp = mktime(0, 0, 0, $month, $day, $year);
        break;
        case 4:
        $timestamp = date('d/m/Y',$str);
        break;
        default:
        $timestamp = time();
    }
    return $timestamp;
}
function replace_test_link($share_url,$type) {
    if (is_numeric($type)) {
        switch ($type) {
            case 1:
                $share_url = str_replace('/test/', '/test/listening/', $share_url);
                break;
            case 2:
                $share_url = str_replace('/test/', '/test/reading/', $share_url);
                break;
            case 3:
                $share_url = str_replace('/test/', '/test/writing/', $share_url);
                break;
            case 4:
                $share_url = str_replace('/test/', '/test/speaking/', $share_url);
                break;
            default:
                # code...
                break;
        }
    }
    else {
        $share_url = str_replace('/test/', '/test/'.$type.'/', $share_url);
    }
    
    return $share_url;

    
}
function set_array()
{
	$arr = func_get_args();
	foreach ($arr as $arr){
		if (is_array($arr)){
			foreach ($arr as $key => $value){
				$row[$key] = $value;
			}
		}
		else{
			$row[$arr] = null;
		}
	}
	return $row;
}
function price_format($number,$type = 1)
{
    if ($number == '')
	{
		return 0;
	}

	// Remove anything that isn't a number or decimal point.
	$number = trim(preg_replace('/([^0-9\.])/i', '', $number));
    if ($type == 1){
        return number_format($number, 0, ',', '.');
    }
}
function filter_vn($str)
{
    $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
    ,"ế","ệ","ể","ễ",
    "ì","í","ị","ỉ","ĩ",
    "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
    ,"ờ","ớ","ợ","ở","ỡ",
    "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
    "ỳ","ý","ỵ","ỷ","ỹ",
    "đ",
    "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
    ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
    "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
    "Ì","Í","Ị","Ỉ","Ĩ",
    "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
    ,"Ờ","Ớ","Ợ","Ở","Ỡ",
    "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
    "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
    "Đ");

    $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
    ,"a","a","a","a","a","a",
    "e","e","e","e","e","e","e","e","e","e","e",
    "i","i","i","i","i",
    "o","o","o","o","o","o","o","o","o","o","o","o"
    ,"o","o","o","o","o",
    "u","u","u","u","u","u","u","u","u","u","u",
    "y","y","y","y","y",
    "d",
    "A","A","A","A","A","A","A","A","A","A","A","A"
    ,"A","A","A","A","A",
    "E","E","E","E","E","E","E","E","E","E","E",
    "I","I","I","I","I",
    "O","O","O","O","O","O","O","O","O","O","O","O"
    ,"O","O","O","O","O",
    "U","U","U","U","U","U","U","U","U","U","U",
    "Y","Y","Y","Y","Y",
    "D");
    return str_replace($marTViet,$marKoDau,$str);
}
function clear_file_name($str) {
    $str = trim(filter_vn($str));
    $str = str_replace(" ","_",$str);
    $str = preg_replace("/[^a-z0-9\.\_\-]/", "", strtolower($str));
    return $str;
}   
function set_alias_link($str){
	$string = trim(filter_vn($str));
    $string = cut_text($string,170);
    $string = str_replace(array("\"",'”',"'","!","@","#","$","%","^","&","*","(",")"),"",$string);
	$string = preg_replace("`\[.*\]`U","",$string);
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);

	return strtolower(trim($string, '-'));
}
function clear_cache($fd = array()){
    $CI = &get_instance();
    $CI->load->helper('file');
    $path =  APPPATH.'cache/';
    if (!empty($fd)){
        foreach ($fd as $fd){
            delete_files($path.$fd,TRUE,2);
        }
    }
    else{
        delete_files($path,TRUE,2);
    }
}
function cut_text($text,$chars = 100){
    if (strlen($text) < $chars){
        return $text;
    }
    $text = trim($text);
    $text = substr( $text, 0, $chars );
	$text = substr( $text, 0, strrpos( $text, ' ' ) );
    return $text.' ...';
}
function send_mail($to,$subject,$message){
    $CI = &get_instance();
    // 
    // get config email server
    $emailServer = $CI->config->item('email_server');
    $count = count($emailServer);
    $randInt = rand(0,$count-1);
    $emailServer = $emailServer[$randInt];

    // load library
    $config = array(
        'smtp_host' => $emailServer['host'],
        'smtp_user' => $emailServer['email'],
        'smtp_pass' => $emailServer['password'],
        'smtp_port' => $emailServer['port'],
        'mailtype' => 'html',
        'protocol' => 'smtp',
        'newline'   =>"\r\n",
    );
    $CI->load->library('email',$config);
    $CI->email->clear();
    $CI->email->from($config['smtp_user'], 'Aland');
    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($message);
    $CI->email->send(TRUE);
    echo $CI->email->print_debugger();
    if ($CI->email->send(TRUE)) {
        return TRUE;
    } else {
        if (ENVIRONMENT == 'development') {
            $CI->email->print_debugger(array('headers'));
        }
        return FALSE;
    }
}
function media_show($filename,$size = ''){
    $CI = &get_instance();
    $x = explode('.', $filename);
    $type =  end($x);
    $filename = ltrim($filename,'/');
    switch ($type){
        case 'swf':
            $out = '<embed ';
            if ($height > 0) {$out.= " height=\"$height\" ";}
            if ($width > 0) {$out.= ' width="'.$width.'" ';}
            $out.=  'type="application/x-shockwave-flash" src="'.base_url().'uploads/images/'.$filename.'" style="" quality="high" wmode="transparent" allowscriptaccess="always">';
        break;
        default:
        $out = '<img src="'. getimglink($filename,$size) . '">';
    }
    return $out;
}
function debug($data){
    $out = '<div class="debug" style="position: fixed; right: 0; bottom: 0; width: 500px; height: 200px; z-index: 99999; overflow: scroll; background: #000000; color: #FFF">';
    if (is_array($data)){
        $out .= '<pre>'. htmlspecialchars(print_r($data,true)). "</pre>\n";
    }
    else{
        $out .= var_dump($data);
    }
    $out .= '</div>';
    echo $out;
}
/**
 * @param: type: 1 (widthx0); 2 (0xheight); 3: crop
 */
function getimglink($path,$size = '',$type = 0){
    $CI = &get_instance();
//    if(ip2long($_SERVER['REMOTE_ADDR']) % 10 <= 3) {
//        $upload_url = 'https://static1.aland.edu.vn/uploads/';
//    }elseif(ip2long($_SERVER['REMOTE_ADDR']) % 10 <= 6){
//        $upload_url = 'https://static2.aland.edu.vn/uploads/';
//    }else{
        $upload_url = UPLOAD_URL;
//    }
//    $upload_url = 'https://www.aland.edu.vn/';
//
    $path = $upload_url.'images/userfiles/'.trim($path,'/');

    // $path = UPLOAD_URL.'images/userfiles/'.'su_gia/gv2.jpg';
    if (!$size) {
        return $path;
    }

    $strsize = ($type == 3) ? $CI->config->item("crop") : $CI->config->item("resize");
    $size = $strsize[$size];
    if (!$size) {
        return $path;
    }
    $rep = '';
    $command = 'resize';
    switch($type){
        case 1:
        $size[1] = 0;
        break;
        case 2:
        $size[0] = 0;
        break;
        case 3:
        $command = 'crop';
    }
    return str_replace('/userfiles/', '/'.$command.'/'.$size[0].'x'.$size[1].'/', $path) ;
}

/**
* @param: array('lang' => int, url => str)
* @author: namtq
*/
function redirect_seo($params,$location,$code) {
    $CI = &get_instance();
    if ($params['lang']) {
        $arrLang = $CI->config->item("multilang");
        foreach ($arrLang as $key => $value) {
            if ($value == $params['lang'])  {

                if ($CI->config->item("default_lang") == $key) {
                    redirect(BASE_URL.'/'. trim($params['url'],'/'),$location, $code); 
                }
                else {
                    redirect(BASE_URL.'/'.$key.'/'. trim($params['url'],'/'),$location, $code); 
                }
                
            }
        }
        
    }
}
function getFileLink($path,$type = 'sound') {
    switch ($type) {
        case 'sound':
        case 'sound_user':
            $arr = array('2017','2016','2018');
            foreach ($arr as $arr) {
                if (strpos($path, $arr)) {
                    return 'https://cdn.anhngumshoa.com/uploads/sound/'.trim($path,'/');
                }
            }
            return (strpos($path, '://') === TRUE) ? $path : UPLOAD_URL.$type.'/'.trim($path,'/');
            break;
        case 'file':
            $path = UPLOAD_URL.'files/'.trim($path,'/');
            return $path;
            break;
        
        default:
            # code...
            break;
    }
}

function filter_item($var){
  return ($var !== NULL && $var !== FALSE && $var !== '');
}

function translate_answer($int){
    $alphabet = range('A', 'Z');
    return $alphabet[$int - 1];
}

function gramar_check($user_answer, $gramaly){
    if(empty($user_answer)){
        return NULL;
    }
    $result = array();
    foreach ($user_answer as $question_id => $answer) {
        $length_other = 0;
        if(isset($gramaly[$question_id]) && $gramaly[$question_id]){
            foreach ($gramaly[$question_id] as $index => $gramar) {
                $offset = $length_other + $gramar['offset'];
                $new_content = '<span class="your-task__text-false" data-toggle="popover" title="Error '.$gramar['type'].'" data-content="Better: ';
                foreach ($gramar['better'] as $item) {
                    $new_content .= $item.'; ';
                }
                $new_content = rtrim($new_content, '; ');
                $new_content .= '">'.$gramar['bad'].'</span>';
                $length_other = $length_other + strlen($new_content) - strlen($gramar['bad']);
                $answer = substr_replace($answer,$new_content,$offset,$gramar['length']);
            }
        }
        $result[$question_id] = $answer;
    }
    return $result;
}

function generateHtmlCommentBlock($data_content)
{
    return  '<section class="comment" id="comment_block"></section><div class="comment-interact" data-content=\''.json_encode($data_content).'\' ></div>';
}

function getDeltaTimeTillNow($time,$option = null)
{
    // - tính deltatime
    $now = time();
    $time_old = (int) $time;
    $delta_time = $now - $time_old; // đơn vị second

    switch (true)
    {
        case ($delta_time <60): // giây
            $delta_time_express = $delta_time. " giây trước";
            break;
        case ($delta_time <60*60): // phút
            $minute = round($delta_time/60,0);
            $delta_time_express = $minute. " phút trước";
            break;
        case ($delta_time <60*60*24): // giờ
            $hour = round($delta_time/(60*60),0);
            $delta_time_express = $hour. " giờ trước";
            break;
        case ($delta_time <60*60*24*7): // ngày - để tối đa là 7 ngày
            $day = round($delta_time/(60*60*24),0);
            $delta_time_express = $day. " ngày trước";
            break;
        default:
            if ($option == 'day')
            {
                $delta_time_express = date("d/m/Y", $time);
            }else{
                $delta_time_express = date(" H:i:s - d/m/Y", $time);
            }
            break;
    }
    return $delta_time_express;
}

function toNumber($dest)
{
    if ($dest)
        return ord(strtolower($dest)) - 96;
    else
        return 0;
}

function getAvatarLink($avarta){
    if (is_null($avarta)){
        return 'https://www.aland.edu.vn/uploads/images/avarta/avarta_default.png' ;
    }else{
        return 'https://www.aland.edu.vn/uploads/images/avarta/crop/'.$avarta ;
    }
}

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..
    return false;
}

// =========== feedback

function feedback_instruct(){
    // ===== Full version
    $info_basic = array(
        // 'type' => 'ruler',
        'id_quest' => 12,
        'question' => array('',' style="" '),
        'left_text' => 'Rất kém',
        'right_text' => 'Rất tốt',
        'levels' => array(
            // value => text
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ),
    );
    echo creat_feedback_question_ruler($info_basic);

    // ===== Short Version
    $info_plus = array(
        'id_quest' => 12,
        'question' => array('This is question content',' style="" '),
    );
    echo creat_feedback_question_ruler_fast($info_plus);

    // ===== Creat by List
    $list_question = array(
        'Về Giảng viên' => array(
            'Trình độ chuyên môn',
            'Phương pháp giảng dạy',
        ),

        'Về Giáo trình và Slides' => array(
            'Bố cục trình bày',
            'Mức độ kiến thức',
        ),
    );
    creat_feedback_list_question_ruler($list_question);

    // ===== Select Question

    $info = array(
        'id_quest' => 34,
        'question' => array('',' style="" '),
        'label_fisrt' => 'Chọn', // label selected - disable // - default: '' ->> ko hiển thị
        'levels' => array(
            // value => text
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
        ),
    );

    echo creat_feedback_question_select($info);

    // =====

    $info_plus = array(
        'id_quest' => 34,
        'question' => array('',' style="" '),
    );
    echo creat_feedback_question_select_fast($info_plus);

    // ===== Text Question
    $info =  array(
        'id_quest' => 56,
        'rows' => 5,
        'question' => array('',' style="" '),
    );
    echo creat_feedback_question_text($info);

    // ===== Radio Question
    $info =  array(
        'id_quest' => 102,
        'question' => array('',' style="" '),
        'levels' => array(
            // value => text
            1 => 'Có',
            0 => 'Không',
        ),
    );
    echo creat_feedback_question_radio($info);

}

// =========== RULER QUESTION ======================

function creat_feedback_question_ruler($info){
    $left_text = $info['left_text'];
    $right_text = $info['right_text'];
    $levels =  $info['levels'];
    $id_quest =  $info['id_quest'];

    $html_radio = '';

    foreach ($levels as $value => $text) {
        $html_radio .=
            '<div class="select_area" onclick="ClickElement(\'radio_feedback_'.$id_quest.'_option_'.$value.'\')" >
                <p class="title_ruler">'.$text.'</p>
                <div class="div_mono_radio_feedback">
                    <input content="'.$info['question'][0].'" type="radio" id="radio_feedback_'.$id_quest.'_option_'.$value.'" value="'.$value.'" class="radio_feedback_ruler radio_feedback radio_feedback_'.$id_quest.'" name="radio_feedback_'.$id_quest.'" >
                </div>
            </div>';
    }

    $html =
    '<div class="container div_quest" type="ruler" id_quest="'.$id_quest.'" content_quest="'.$info['question'][0].'" >
        <p class="quest_title" id="quest_title_'.$id_quest.'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>
        <div class="row" style="text-align: center;">
            <div class="title_ruler_div">
                <p class="title_ruler" style="visibility: hidden">*</p>
                <p class="feedback_ruler">'.$left_text.'</p>
            </div>
            '.$html_radio.'
            <div class="title_ruler_div">
                <p class="title_ruler" style="visibility: hidden">*</p>
                <p class="feedback_ruler">'.$right_text.'</p>
            </div>
        </div>
    </div>';

    return $html;
}

function creat_feedback_question_ruler_fast($info_plus){
    $info_basic = array(
        'type' => 'ruler',
        'question' => array('This is question content',' style="" '),
        'left_text' => 'Rất kém',
        'right_text' => 'Rất tốt',
        'levels' => array(
            //value => text
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ),
    );
    $info_full = array_merge($info_basic,$info_plus);

    return creat_feedback_question_ruler($info_full);
}

function creat_feedback_list_question_ruler($list_info, $id_quest_start){
    foreach ($list_info as $title_group => $detail_group) {
        echo '<h3 class="title_group_quest">'.$title_group.'</h3>';
        for ($i = 0; $i < count($detail_group); $i++) {
            $detail_1_quest = $detail_group[$i];
            $info_plus = array(
                'id_quest' => $id_quest_start,
                'question' => array($detail_1_quest,' style="" '),
            );
            echo creat_feedback_question_ruler_fast($info_plus);
            $id_quest_start ++;
        }
    }
}

// =========== SELECT QUESTION

function creat_feedback_question_select($info){
    $label_first = '';
    if ($info['label_fisrt'] !== ''){
        $label_first = '<option selected disabled value="">'.$info['label_fisrt'].'</option>';
    }
    $html_option = '';
    foreach ($info['levels'] as $value => $text){
        $html_option .= '<option value="'.$value.'">'.$text.'</option>';
    }

    $html =
    '<div class="container div_quest" style="padding-top:5px; padding-bottom: 5px;" type="select" id_quest="'.$info['id_quest'].'"  content_quest="'.$info['question'][0].'" >
        <p class="quest_title" id="quest_title_'.$info['id_quest'].'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>
        <div class="row" >                       
            <div class="form-group" style="">'.
//                    <label '.$info['question'][1].' for="" >'.$info['question'][0].'</label>
                    '<select class="form-control select_quest_feedback_select"   name="" id="feedback_quest_select'.$info['id_quest'].'">'.$label_first.$html_option.'
                    </select>
            </div>
        </div>
    </div>';
    return $html;
}

function creat_feedback_question_select2($info){
    $label_first = '';
    if ($info['label_fisrt'] !== ''){
        $label_first = '<option selected disabled value="">'.$info['label_fisrt'].'</option>';
    }
    $html_option = '';
    foreach ($info['levels'] as $value => $text){
        $html_option .= '<option value="'.$value.'">'.$text.'</option>';
    }

    $html =
        '<div class="container div_quest" style="padding-top:5px; padding-bottom: 5px;" type="select" id_quest="'.$info['id_quest'].'"  content_quest="'.$info['question'][0].'" >
        <div class="row" >  
            <div class="col col-sm-9" >
                    <p class="quest_title" id="quest_title_'.$info['id_quest'].'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>

            </div>
            <div class="col col-sm-3" >
                    <div class="form-group" style="">'.
                            '<select class="form-control select_quest_feedback_select"   name="" id="feedback_quest_select'.$info['id_quest'].'">'.$label_first.$html_option.'
                            </select>
                    </div>
            </div>                           
            
        </div>
    </div>';
    return $html;
}

function creat_feedback_question_select_fast($info_plus){
    $info_basic = array(
        'label_fisrt' => 'Chọn', // label selected - disable // - default: '' ->> ko hiển thị
        'levels' => array(
            // value => text
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
        ),
    );
    $info_full = array_merge($info_basic,$info_plus);
    return creat_feedback_question_select($info_full);
}

function creat_feedback_question_select_fast2($info_plus){
    $info_basic = array(
        'label_fisrt' => 'Chọn', // label selected - disable // - default: '' ->> ko hiển thị
        'levels' => array(
            // value => text
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
        ),
    );
    $info_full = array_merge($info_basic,$info_plus);
    return creat_feedback_question_select2($info_full);
}


function creat_feedback_list_question_select_fast($info_list,$id_quest_start){
    for ($i = 0; $i < count($info_list); $i++) {
        $info_plus = array(
            'id_quest' => $id_quest_start,
            'question' => array($info_list[$i],' style="" '),
        );
        echo creat_feedback_question_select_fast($info_plus);
        $id_quest_start ++;
    }
}

function creat_feedback_list_question_select_fast2($info_list,$id_quest_start){
    for ($i = 0; $i < count($info_list); $i++) {
        $info_plus = array(
            'id_quest' => $id_quest_start,
            'question' => array($info_list[$i],'font-size:medium '),
        );
        echo creat_feedback_question_select_fast2($info_plus);
        $id_quest_start ++;
    }
}


// =========== TEXT QUESTION

function creat_feedback_question_text($info){
    if (! is_numeric($info['rows'])){
        $info['rows'] = 3;
    }

    $html =
        '<div class="container div_quest div_quest_text" type="text" id_quest="'.$info['id_quest'].'" content_quest="'.$info['question'][0].'"  >
            <p class="quest_title" id="quest_title_'.$info['id_quest'].'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>
            <div class="row" style="text-align: center;">                       
                <div class="form-group" style="">
                        <textarea class="form-control textarea_text_quest_feedback" rows="'.$info['rows'].'" id="feedback_quest_text'.$info['id_quest'].'"></textarea>
                </div>
            </div>
        </div>';
    return $html;


}

function creat_feedback_question_text2($info){
    if (! is_numeric($info['rows'])){
        $info['rows'] = 3;
    }

    $html =
        '<div class="container div_quest div_quest_text" type="text" id_quest="'.$info['id_quest'].'" content_quest="'.$info['question'][0].'"  >
            <p class="quest_title" id="quest_title_'.$info['id_quest'].'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>
            <div class="row" style="text-align: center;">                       
                <div class="form-group" style="margin: 5px 15px;">
                        <textarea class="form-control textarea_text_quest_feedback" rows="'.$info['rows'].'" id="feedback_quest_text'.$info['id_quest'].'"></textarea>
                </div>
            </div>
        </div>';
    return $html;


}

function creat_feedback_list_question_text($list_info, $id_quest_start){
    for ($i = 0; $i < count($list_info); $i++) {
        $info =  array(
            'id_quest' => $id_quest_start,
            'rows' => 5,
            'question' => array($list_info[$i],' style="" '),
        );
        echo creat_feedback_question_text($info);
        $id_quest_start ++ ;
    }
}

function creat_feedback_list_question_text2($list_info, $id_quest_start){
    for ($i = 0; $i < count($list_info); $i++) {
        $info =  array(
            'id_quest' => $id_quest_start,
            'rows' => 5,
            'question' => array($list_info[$i],' font-size:medium '),
        );
        echo creat_feedback_question_text2($info);
        $id_quest_start ++ ;
    }
}




// =========== RADIO QUESTION

function creat_feedback_question_radio($info){
    $radio = '';
    foreach ( $info['levels'] as $value => $text ) {
       $radio .=
           '<div class="form-group radio_div_feedback"   style="">
                <div class="radio">
                    <label><input id="feedback_quest'.$info['id_quest'].'" type="radio" name="feedback_quest'.$info['id_quest'].'" value="'.$value.'">'.$text.'</label>
                </div>
           </div>';
   }
    $html =
        '<div class="container div_quest" type="radio" id_quest="'.$info['id_quest'].'" content_quest="'.$info['question'][0].'"  >
        <p class="quest_title" id="quest_title_'.$info['id_quest'].'" style="'.$info['question'][1].'">'.$info['question'][0].'</p>
        <div class="row" >                       
            '.$radio.'
        </div>
    </div>';
    return $html;


}

function creat_feedback_list_question_radio($info_list,$id_quest_start){
    for ($i = 0; $i < count($info_list); $i++) {
        $mono = $info_list[$i];
        $info =  array(
            'id_quest' => $id_quest_start,
            'question' => array($mono,' style="" '),
            'levels' => array(
                // value => text
                1 => 'Có',
                0 => 'Không',
            ),
        );
        echo creat_feedback_question_radio($info);
        $id_quest_start ++;
    }
}

function creat_feedback_list_question_radio_MORE_LEVELS($info_list){
    for ($i = 0; $i < count($info_list); $i++) {
        $info = $info_list[$i];
        echo creat_feedback_question_radio($info);
    }
}


function Dump_Arr_preTag($var){
    echo '<pre>'; print_r($var); echo '</pre>';
}



function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}