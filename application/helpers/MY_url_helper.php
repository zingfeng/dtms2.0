<?php
function current_url()
{
	$CI =& get_instance();
	return base_url().$CI->uri->uri_string();
}
function site_url($uri = '')
{
    if (strpos($uri,'://')){
       return $uri;
    }
	$CI =& get_instance();
	return $CI->config->site_url($uri);
}
?>