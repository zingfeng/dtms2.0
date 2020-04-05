<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Exenstion File Uploading Class
 */

class MY_Upload extends CI_Upload {

	public function do_multi_upload( $field = 'userfile', $return_info = TRUE ){
		$files = $_FILES;
	    $cpt = count ( $_FILES [$field] ['name'] );
	    $return = FALSE;
	    for($i = 0; $i < $cpt; $i ++) {

	        $_FILES [$field] ['name'] = clear_file_name($files [$field] ['name'] [$i]);
	        $_FILES [$field] ['type'] = $files [$field] ['type'] [$i];
	        $_FILES [$field] ['tmp_name'] = $files [$field] ['tmp_name'] [$i];
	        $_FILES [$field] ['error'] = $files [$field] ['error'] [$i];
	        $_FILES [$field] ['size'] = $files [$field] ['size'] [$i];

	        if ($this->do_upload($field)) {
	   			$return['data'][] = $this->data();
	        }
	        else {
	        	$return['error'][] = 'pic'.$i.': '.strip_tags($this->display_errors());
	        }
	    }
	    return $return;
	}
	public function display_multi_errors($open = '<p>', $close = '</p>')
	{
		$error = '';
		if (count($this->error_msg) > 0) {
			foreach ($this->error_msg as $key => $value) {
				$error .= $open . "Pic " . ($key + 1) . ": ". $value.$close;
			}
		}
		return $error;
	}
}

?>