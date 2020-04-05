<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 1: Check 1 - 0
 * 2: LIST CHECK BLANK
 */
function tmp_check_status($st, $type = 1){
    if ($type == 2){
        $st = ($st == '') ? 0 : 1;
    }
    if ($st < 1){
        $ext = '<span class="status"><i class="fa fa-times" aria-hidden="true"></i></span>';
	}
	else{
        $ext = '<span class="status"><i class="fa fa-check" aria-hidden="true"></i></span>';
	}
    return $ext;
}

function super_tmp_check_status($st){
    $ext = '';
    if ($st == 1){
        $ext = '<span class="status"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Yêu cầu chấm điểm</span>';
    }

    if ($st == 2){
        $ext = '<span class="status"><i class="fa fa-check" aria-hidden="true"></i> Đã chấm điểm</span>';
    }
    return $ext;
}

function tmp_qfull_type($type){
    switch ($type) {
        case 1:
            return 'Full';
            break;
        case 2:
            return 'Mini';
            break;
        case 3:
            return 'Skill';
            break;
        default:
            break;
    }
}
function get_target_comment($row){
    $result = "";
    switch ($row['type']) {
        case 1:         //Bài học
            $result .= '[Unit] <a target="_blank" href="'.$row['class_url'].'">'.$row['class_title'].'</a>';
            break;
        case 0 :        //Khóa học
            $result .= '[Course] <a target="_blank" href="'.$row['course_url'].'">'.$row['course_title'].'</a>';
            break;
        default:        //Tin tức
            $result .= '[News] <a target="_blank" href="'.$row['news_url'].'">'.$row['news_title'].'</a>';
            break;
    }
    return $result;
}