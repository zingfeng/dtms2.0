<?php
define('media_path',$_SERVER['DOCUMENT_ROOT'].'/uploads/audio/');
$path = strip_tags(str_replace(array('\'','"'),array('',''),$_GET['path']));
$file = media_path.$path;
$fileSize=filesize($filename);
header('Accept-Ranges: bytes');
header('Cache-Control: max-age=604800');
header('Content-Length: ' . $fileSize);
header('Content-type: audio/mpeg');
readfile($filename);
?>
