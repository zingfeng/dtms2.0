<?php
// output_buffering = Off; php.ini
define('api','images');
$fd = dirname(__FILE__);
$appConfig = require("$fd/lib/config.php");

$url = strip_tags($_GET['url']);
list($size,$path) = explode('/',$url,2);
// get path & type
$path = str_replace(array('\'','"'),'',strip_tags($path));
$type = strip_tags($_GET['type']);
// get width / height image
$arrSize = explode('x',$size);
$width = (int)$arrSize[0];
$height = (int)$arrSize[1];
$arrConfig = $appConfig[$type];
if ($type == 'crop') {
    if (!in_array($size, $arrConfig['size'])) {
        exit("Size resize not found");
    }
    $cw = $width;
    $ch = $height;
}
else {
    $cw = ($width == 0) ? $height : $width;
    $ch = ($height == 0) ? $width : $height;
    if ($cw != $ch || !in_array($cw,$arrConfig['size'])){
        exit("Size resize not found");
    }
}
// check original path 
$file = $appConfig['original_path'].$path;
if (!file_exists($file)){
    exit('File org not exits');
}
// set new path
$file_new = $arrConfig['path'].$size.'/'.$path;
////////////////////////////////////
// xac dinh phan mo rong cua file //
////////////////////////////////////
$mimes = array('bmp'=>'image/bmp', 'gif'=>'image/gif', 'jpg'=>'image/jpeg','jpeg'=>'image/jpeg', 'png'=>'image/png');
$ext = strtolower(substr(strrchr($file, "."), 1));
if (!array_key_exists($ext,$mimes)){
    exit('mime not support');
}
$mime = $mimes[$ext];
// get current dir
$path_file_new = dirname ($file_new);
// create dir if not existed
if (!is_dir($path_file_new)) {
    @mkdir($path_file_new,0755,TRUE);
}
/////// CACHE HTTP
$key = md5($file_new);
if (array_key_exists('HTTP_IF_NONE_MATCH',$_SERVER) AND $_SERVER['HTTP_IF_NONE_MATCH'] == $key) {
    header('HTTP/1.1 304 Not Modified');
}
else{
    // neu ko ton tai cache
    if (!file_exists($file_new)){
        $orgSizeArr = getimagesize($file);
        
        /// copy file
        if ($orgSizeArr[0] <= $width || $orgSizeArr[1] <= $height) {
            if (!copy($file,$file_new)) {
                exit ('False copy file');
            }
        }
        else {
            require_once ('lib/images.php');
            $lib = new Images;

            if ($type == 'crop') {
                
                
                $configCrop = array(
                    'allowed_types' => 'gif|jpg|png',
                    'new_image' => $file_new,
                    'quality' => 100,
                    'source_image' => $file,
                    'width' => $width,
                    'height' => $height,
                    'x_axis' => 0,
                    'y_axis' => 0
                );
                // resize before crop
                if ($orgSizeArr[0] != $width && $orgSizeArr[1] != $height) {
                    if ($orgSizeArr[0] / $orgSizeArr[1] - $width / $height < 0) {
                        $configCrop['master_dim'] = 'width';
                        // crop tu giua
                        $configCrop['y_axis'] = (int)($orgSizeArr[1] * $width / $orgSizeArr[0] - $height) / 2;
                    }
                    else {
                        $configCrop['master_dim'] = 'height';
                        $configCrop['x_axis'] = (int)($orgSizeArr[0] * $height / $orgSizeArr[1] - $width) / 2;
                    }    
                    $lib->initialize($configCrop);
                    if ( ! $lib->resize())
                    {
                        exit($lib->display_errors());    
                    }
                    $configCrop['source_image'] = $file_new;
                    //clear all process
                    $lib->clear();
                }
                else {
                    // set position crop
                    if ($orgSizeArr[0] == $width) {
                        $configCrop['x_axis'] = (int)($orgSizeArr[0] * $height / $orgSizeArr[1] - $width) / 2;
                    }
                    else {
                        $configCrop['y_axis'] = (int)($orgSizeArr[1] * $width / $orgSizeArr[0] - $height) / 2;
                    }
                }
                $configCrop = array_merge($configCrop,array(
                        'quality' => 90,
                        'maintain_ratio' => FALSE
                ));
                $lib->initialize($configCrop);
                if (!$lib->crop())
                {
                    exit( $imagelib->display_errors());
                }
            }
            else {
                $configResize = array(
                    'create_thumb' => TRUE,
                    'thumb_marker' => '',
                    'allowed_types' => 'gif|jpg|png',
                    'new_image' => $file_new,
                    'quality' => 90,
                    'source_image' => $file,
                    'maintain_ratio' => true
                );
                if ($width == 0){
                    $configResize['master_dim'] = 'height';
                    $configResize['height'] = $height;
                    $configResize['width'] = $height;
                }
                elseif($height == 0){
                    $configResize['master_dim'] = 'width';
                    $configResize['width'] = $width;
                    $configResize['height'] = $width;
                }
                else{
                    $configResize['width'] = $width;
                    $configResize['height'] = $height;
                    $configResize['master_dim'] = 'auto';
                }
                $lib->initialize($configResize);
                $lib->resize();
            }
            //exit();
            if (!empty($lib->error_msg)){
                exit('have some error');
            }
        }

        
    }
    header("Cache-Control: max-age=72000, must-revalidate");
    header('Etag: '.$key);
    header('Content-Type: '.$mime);
    header("Content-Disposition: filename=f6-".$type.'-'.time().";");
    readfile($file_new);
}