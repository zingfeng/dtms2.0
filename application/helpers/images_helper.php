<?php
function images_delete($path,$type = 'images'){
    $CI = &get_instance();

    switch ($type){
        case 'flash':
        $file = $CI->config->item('path_upload').'flash/'.$path;
        break;
        case 'files':
        case 'file':
        $file = $CI->config->item('path_upload').'files/'.$path;
        break;
        default:
        $file = $CI->config->item('path_upload').'images/'.$path;
    }
    //echo $file;
    @unlink($file);
    if ($type == 'images' || $type == 'image'){
        $link = substr($file,0,strrpos  ($file,'/') + 1);
        $filename = substr(strrchr($file, "/"), 1);
        $arr = $CI->config->item('resize');
        foreach ($arr as $arr){
            $file1 = $link.'thumb_'.$arr[0].'x'.$arr[1].'_'.$filename;
            $file2 = $link.'thumb_0x'.$arr[1].'_'.$filename;
            $file3 = $link.'thumb_'.$arr[0].'x0_'.$filename;
            //echo $file_new;
            @unlink($file1);
            @unlink($file2);
            @unlink($file3);
        }
    }
}
/**
 * name_prefix: tien to dau tien cho ten
 * path: folder chua
 */
function images_upload($field = 'userfile',$config = array(),$type = 'images'){
    if (!$_FILES[$field]['tmp_name']){
        return array('error' => '','success' => '');
    }
    $CI = &get_instance();
    $file_name = date('His_dmY_').rand(100000,999999);
    $path = ($config['path']) ? $config['path'] : date('Y/m/d');
    $path = trim($path,'/');
    $dir = $path.'/';
    $conf = $CI->config->item("uploadconf");

    switch ($type){
        case 'flash':
        $path = rtrim($CI->config->item('path_upload').'flash/'.$path,'/').'/';
        $config_default = $conf['flash'];
        break;
        case 'files':
        $path = rtrim($CI->config->item('path_upload').'files/'.$path,'/').'/';
        $config_default = $conf['files'];
        break;
        default:
        $path = rtrim($CI->config->item('path_upload').'images/'.$path,'/').'/';
        $config_default = $conf['images'];
    }
    if (!is_dir($path)){
        mkdir($path,0755,true);
    }
    $config_default['upload_path'] = $path;
    $config = (!empty($config)) ? array_merge($config_default,$config) : $config_default;

    //var_dump($config); die;
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if ( ! $CI->upload->do_upload($field))
	{
		return array('error' => $CI->upload->display_errors(),'success' => '');
	}
	else
	{
        $data = $CI->upload->data();
		$url = ltrim($dir.$data['file_name'],'/');
        $path = $path.$data['file_name'];
        if (!empty($config['watermark'])){
            images_watermark($path,$config['watermark']);
        }
        return array('error' => '','success' => $url);
	}
}
function images_watermark($path,$newconfig = ''){
    $CI = &get_instance();
    $config['source_image'] = $path;
    $config['wm_overlay_path'] = FCPATH.'/theme/frontend/default/images/wartermark.png';
    $config['wm_type'] = 'overlay';
    //$config['wm_text'] = 'bonbanhhaiphong.com.vn';
    //$config['wm_font_path'] = './system/fonts/Vnariabi.ttf';
    //$config['wm_font_size'] = '12';
    //$config['wm_font_color'] = '842431';
    //$config['wm_shadow_color'] = '111111';
    //$config['wm_shadow_distance'] = '2';
    $config['wm_vrt_alignment'] = 'middle';
    $config['wm_hor_alignment'] = 'center';
    $config['wm_padding'] = '0';
    $config['wm_opacity'] = '20';

    $config = (is_array($newconfig)) ?  array_merge($config,$newconfig): $config;
    $CI->load->library('image_lib',$config);
    $CI->image_lib->watermark();
}