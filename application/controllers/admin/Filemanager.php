<?php
class Filemanager extends CI_Controller {
	private $error = array();
	private $directory = '';
    private $uploadurl = '';
    private $type = '';
    private $userimage = 'userfiles/';
    public function __construct(){
	   parent::__construct();
       $this->lang->load('backend/filemanager');
       switch($this->input->get('type')){
            case 'file':
            case 'url':
            $this->directory = $this->config->item('path_upload').'files/';
            $this->uploadurl = UPLOAD_URL.'files/';
            $this->type = 'file';
            break;
            case 'video':
            $this->directory = $this->config->item('path_upload').'video/';
            $this->uploadurl = UPLOAD_URL.'video/';
            $this->type = 'video';
            break;
            case 'sound':
            $this->directory = $this->config->item('path_upload').'sound/';
            $this->uploadurl = UPLOAD_URL.'audio/';
            $this->type = 'sound';
            break;
            case 'flash':
            $this->directory = $this->config->item('path_upload').'flash/';
            $this->uploadurl = UPLOAD_URL.'files/';
            $this->type = 'flash';
            break;
            default:
            $this->directory = $this->config->item('path_upload').'images/'.$this->userimage;
            $this->uploadurl = UPLOAD_URL.'images/'.$this->userimage;
            $this->type = 'image';
		}

	}
	public function index() {
		$data['theme'] = $this->config->item('img').'filemanager/';
		if ($this->input->get('field')) {
			$data['field'] = $this->input->get('field');
		} else {
			$data['field'] = '';
		}
        $data['directory'] = $this->uploadurl;
        $data['type'] = $this->type;
        $data['formname'] = $this->input->get("CKEditor");
        $data['callback'] = $this->input->get("callback");
        $data['dom'] = $this->input->get("dom");

        // fck form
        $fck = $this->input->get('CKEditorFuncNum');
		if (is_string($fck)) {
			$data['fckeditor'] = $fck;
		} else {
			$data['fckeditor'] = false;
		}
		$this->load->view('common/filemanager',$data,FALSE);
	}
	public function directory() {
		$json = array();
		$this->load->helper('directory');
        $folder = $this->input->get('id');
        $type = $this->input->get('type');

		if ($folder) {
			if ($folder === 'root') {
				$folder = '';
			}
            if ($folder != ''){
                $folder = rtrim(str_replace('../', '', $folder),'/').'/';
            }
            $dir = rtrim($this->directory.$folder);
			$directories = directory_map($dir ,1,false,TRUE);
			if (!empty($directories)) {
                $i = 0;

                
				foreach ($directories as $directory) {
					$directory = rtrim($directory, DIRECTORY_SEPARATOR);
				    $realpath = $dir. $directory;
                    if (is_dir($realpath)){
                    	$json[$i]['id'] = $folder.$directory;
    					$json[$i]['text'] = basename($directory);
    					$children = directory_map($realpath,1,false,TRUE);
    					if ($children)  {
    						$json[$i]['children'] = true;
    					}
    					$i++;
                    }
				}
			}
		}
		else {
			$json[0]['id'] = 'root';
			$json[0]['text'] = $type;
			$json[0]['children'] = (directory_map($this->directory,1,false,TRUE)) ? true : false;

		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
	public function files() {
		$json = array();
		$directory = $this->input->post('directory');
		$directory = ($directory == 'root') ? '' : $directory;
        $dir = str_replace('../', '', $directory);
		if ($dir) {
			$directory = $this->directory . $dir;
		} else {
			$directory = $this->directory;
		}
        $path_icon = $this->config->item('theme').'images/filemanager/icon/';
		$type = $this->input->get('type');
        $conf = $this->config->item("uploadconf");

        switch ($type) {
            case 'flash':
            $allowed = $conf['flash']['allowed_types'];
            break;
            case 'file':
		    $allowed = $conf['files']['allowed_types'];
		    break;
		    case 'video':
		    $allowed = $conf['video']['allowed_types'];
            break;
            case 'sound':
		    $allowed = $conf['sound']['allowed_types'];
            break;
            default:
            $allowed = $conf['images']['allowed_types'];
		}
        $allowed = explode('|',$allowed);
        $this->load->helper('file');
        $files = get_dir_file_info($directory,TRUE);
        //var_dump($files); 
        //usort($files, array('Filemanager','sortfile'));

        
//        echo $this->directory;
//        echo $directory;
//         var_dump($files); die;
		//$files = glob(rtrim($directory, '/') . '/*');
		if ($files) {
			usort($files, array($this,'sort_file'));
            $j = 0;
			foreach ($files as $data) {
                $file = $data['name'];
				if (is_file($data['server_path'])) {
					$tmp = explode(".",$file);
					$ext = end($tmp);
				} else {
					$ext = '';
				}
				if (in_array(strtolower($ext), $allowed)) {
					$size = $data['size'];
					$i = 0;

					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);

					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
                    $filepath = ($dir) ? $dir.'/'.$file : $file;
					$json[$j] = array(
						'file'     => $filepath,
						'filename' => basename($file),
						'size'     => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
					);
                    if ($type == 'image'){
                        $json[$j]['thumb'] = getimglink($filepath,'size1');
                    }
                    else{
                        $json[$j]['thumb'] = $path_icon.str_replace('.','',$ext).'.png';
                    }
                    $j ++;
				} 
			}
		}
		$this->output->set_output(json_encode($json));
	}

	public function create() {
		$json = array();
		$folder = $this->input->post('directory');
		$folder = ($folder == 'root') ? '' : $folder;
		if ($folder !== FALSE) {
            $name = $this->input->post('name');
			$name = strtolower(str_replace(array('\'','"',' ','../'),'_',$name));
            if (!preg_match('#([a-zA-Z0-9]+)#is', $name))
            {
                $json['error'] = $this->lang->line('fmag_error_valid_name');
            }
            if ($name != '') {
				$directory = rtrim($this->directory . str_replace('../', '', $folder), '/');

				if (!is_dir($directory)) {
					$json['error'] = $this->lang->line('fmag_error_directory');
				}
				$directory = $directory.'/'.$name;
				if (file_exists($directory)) {
					$json['error'] = $this->lang->line('fmag_error_exists');
				}
			} else {
				$json['error'] = $this->lang->line('fmag_error_name');
			}
		} else {
			$json['error'] = $this->lang->line('fmag_error_directory');
		}
		if (!isset($json['error'])) {
			if (@mkdir($directory  , 0755)) {
				$json = array('id' => trim($folder.'/'.$name,'/'),'name' => $name);
			}
			else {
				$json = array('error' => $this->lang->line("fmag_error_permission"));
			}	
		}

		$this->output->set_output(json_encode($json));
	}

	public function delete() {
		$json = array();
        $path = $this->input->post('path');
        $path = explode(',',$path);
		if (!empty($path)) {
            $i = 0;
            foreach ($path as $p){
                $pp = str_replace('../', '', html_entity_decode($p, ENT_QUOTES, 'UTF-8'));
    			$pth = rtrim($this->directory . $pp, '/');
    			$realp[$i]['realpath'] = $pth;
                $realp[$i]['path'] = $pp;
                if (!file_exists($pth)) {
    				$json['error'] = $this->lang->line('fmag_error_select'); break;
    			}
    			if ($pth == rtrim($this->directory, '/')) {
    				$json['error'] = $this->lang->line('fmag_error_delete'); break;
    			}
                $i ++;
            }
		} else {
			$json['error'] = $this->lang->line('fmag_error_select');
		}
		if (!isset($json['error'])) {
            $this->load->helper("images");
            foreach ($realp as $realp){

                if (is_file($realp['realpath'])) {
                    $realpath = ($this->type == 'image') ? $this->userimage.$realp['path'] : $realp['path'];
				    images_delete($realpath,$this->type);
        		} elseif (is_dir($realp['realpath'])) {
        			$this->recursiveDelete($realp['realpath']);
        		}
            }
			$json['success'] = $this->lang->line('fmag_text_delete');
		}

		$this->output->set_output(json_encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}

		if (!$handle) {
			return false;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}

		closedir($handle);

		rmdir($directory);

		return true;
	}

	public function move() {
		$this->load->language('backend/filemanager');

		$json = array();
		$from = $this->input->post('from');
        $to = $this->input->post('to');
		if ($from != '') {
			$from = (is_array($from)) ? $from : explode(',',$from);
            foreach ($from as $from){
                $fr = ltrim($from,"/");
                if (strpos($to,$from) !== FALSE){
                    $json['error'] = $this->lang->line('fmag_access_denied_move'); break;
                }
    			$fr = rtrim(str_replace('../', '', $fr), '/');
                $rootfile[] = $fr;
                $fr = $this->directory . $fr;
    			if (!file_exists($fr)) {
    				$json['error'] = $this->lang->line('fmag_error_missing'); break;
    			}
    			if ($fr.'/' == $this->directory) {
    				$json['error'] = $this->lang->line('fmag_error_default'); break;
    			}
                if (file_exists($to . '/' . basename($fr))) {
				    $json['error'] = $this->lang->line('fmag_error_exists'); break;
                }
                $fromarr[] = $fr;

            }
			$to = rtrim($this->directory . str_replace('../', '', $to), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->lang->line('fmag_error_move');
			}


		} else {
			$json['error'] = $this->lang->line('fmag_error_directory');
		}
		if (!isset($json['error'])) {
		    foreach ($fromarr as $fromarr){
                rename($fromarr, $to . '/' . basename($fromarr));
		    }
			// xoa cac file thumb
            $this->load->helper("images");
            foreach ($rootfile as $rootfile){
                images_delete($this->userimage.$rootfile);
            }

			$json['success'] = $this->lang->line('fmag_text_move');
		}

		$this->output->set_output(json_encode($json));
	}

	public function copy() {
		$json = array();
		$arrFrom = $this->input->post('from');
		$to = $this->input->post('to');


        if ($arrFrom && $to) {
        	$arrFrom = (is_array($arrFrom)) ? $arrFrom : explode(',',$arrFrom);
			$to = ($to == 'root') ? '' : $to;
            if (!preg_match('#([a-zA-Z0-9]+)#is', $to))
            {
                $json['error'] = $this->lang->line('fmag_error_valid_name');
            }
			$to = rtrim($this->directory . str_replace('../', '', html_entity_decode($to, ENT_QUOTES, 'UTF-8')), '/');
            foreach ($arrFrom as $key => $from) {
            	$from = rtrim($this->directory . str_replace('../', '', html_entity_decode($from, ENT_QUOTES, 'UTF-8')), '/');
				$fileName = (strpos($from, '/') !== FALSE) ? substr(strrchr($from, "/"), 1) : $from;
				

				if (!file_exists($from) || !file_exists($to) || $from == $to) {
					$json['error'] = $this->lang->line('fmag_error_copy');
				}
				$ext = '';
				if (is_file($from)) {
					if (strpos($from, '.') !== FALSE) {
						$fileName = strstr($fileName, '.', true);
						$ext = strrchr($from, '.');
					}						
				}
				// check xem vi tri copy da ton tai file do chua. neu ton tai roi rename  file
				$json['debug'][] = $to.'/'.$fileName;
				$fileName = file_exists($to.'/'.$fileName.$ext) ? $fileName . '_copied_'.rand(100000,99999).'_'.time().$ext : $fileName.$ext;
				$fileName = $to.'/'.$fileName;
				if (file_exists($fileName)) {
					$json['error'] = $this->lang->line('fmag_error_exists');
				}
				if ($json['error']) {
					break;
				}
				$arrData[] = array('from' => $from, 'to' => $fileName);
            }
			
		} else {
			$json['error'] = $this->lang->line('fmag_error_select');
		}
		if (!isset($json['error'])) {
			foreach ($arrData as $key => $data) {
				if (is_file($data['from'])) {
					copy($data['from'], $data['to']);
				} else {
					$this->recursiveCopy($data['from'], $data['to']);
				}	# code...
			}
			$json['success'] = $this->lang->line('fmag_text_copy');
		}

		$this->output->set_output(json_encode($json));
	}

	function recursiveCopy($source, $destination) {
		$directory = opendir($source);

		@mkdir($destination);

		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir($source . '/' . $file)) {
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file);
				} else {
					copy($source . '/' . $file, $destination . '/' . $file);
				}
			}
		}

		closedir($directory);
	}

	public function folders() {
        $this->load->helper('directory');
        $out = '<option value="">'.$this->lang->line('fmag_root_folder').'</option>';
        $dir = directory_map($this->directory,0,false,true);
        $out .= $this->recursiveFolders($dir);
        $this->output->set_output($out);
	}

	protected function recursiveFolders($dir,$level = '',$level_val = '') {
        $out = '';
        foreach ($dir as $key => $val){
            if (is_array($val)){
                $out .= '<option value="'.$level.$key.'">'.$level_val.$key.'</option>';
                if (!empty($val))
                $out .= $this->recursiveFolders($val,$level.$key.'/',$level_val.'--');
            }
		}
        return $out;
	}

	public function rename() {
		$json = array();
        $path = $this->input->post('path');
        $name = clear_file_name($this->input->post('name'));
        $name = str_replace(array('\'','"',' ','../'),'',$name);
        if (!preg_match('#([a-zA-Z0-9]+)#is', $name))
        {
            $json['error'] = $this->lang->line('fmag_error_valid_name');
        }
		if ($path !== false AND $name !== false) {
			if (strlen($name) > 100){
                $json['error'] = $this->lang->line('fmag_error_rename');
			}
			$folder = rtrim( str_replace('../', '', html_entity_decode($path, ENT_QUOTES, 'UTF-8')), '/');
			$old_name = $this->directory.$folder;
			$orgFolder = (strpos($folder, '/') !== FALSE) ? dirname($folder) : '';
			if (!file_exists($old_name) || $old_name == $this->directory) {
				$json['error'] = $this->lang->line('fmag_error_name');
			}

			if (is_file($old_name)) {
				$ext = (strpos($name, '.') === FALSE) ? strrchr($old_name, '.') : '';
			} else {
				$ext = '';
			}

			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($name, ENT_QUOTES, 'UTF-8') . $ext);

			if ($old_name != $new_name && file_exists($new_name)) {
				$json['error'] = $this->lang->line('fmag_error_exists');
			}
		}

		if (!isset($json['error'])) {
			if ($old_name != $new_name) {
				rename($old_name, $new_name);
				// delete thumb
				$this->load->helper("images");
	            images_delete($this->userimage.$folder);
			}
			$json = array('path' => trim($orgFolder.'/'.$name.$ext,'/'), 'name' => $name.$ext);
		}

		$this->output->set_output(json_encode($json));
	}
	public function upload() {

		$json = array();
		$dir = str_replace('../', '', html_entity_decode($this->input->post('directory'), ENT_QUOTES, 'UTF-8'));
        $type = $this->input->get('type');
        $configDefault = array(
        	'file_ext_tolower' => TRUE,
        	'remove_spaces' => TRUE
        );
		if ($dir) {
			$dir = ($dir == 'root') ? '' : $dir;
		    $conf = $this->config->item("uploadconf");
            switch ($type) {
                case 'url':
                case 'file':
                    $config = $conf['files'];
                    break;
                case 'flash':
                    $config = $conf['flash'];
                    break;
                case 'video':
                    $config = $conf['video'];
                    break;
                case 'sound':
                    $config = $conf['sound'];
                    break;
                default:
                    $config = $conf['images'];
            }
            $config['upload_path'] = $this->directory.$dir;
            unset($config['file_name']);
            // merge config
            $config = array_merge($configDefault,$config);
    		// load library
    		$this->load->library('upload', $config);
    		$json['error'] = "";
    		$arrDataUpload = $this->upload->do_multi_upload('image');
    		if (!$arrDataUpload) {
    			$json['error'] = 'Error ! Do not choose image upload';
    		}
    		else {
    			// resize image
    			if ($arrDataUpload['data'] && $type == 'image') {
	    			$maxsize = $config['autoresize'];
	    			foreach ($arrDataUpload['data'] as $key => $imageInfo) {
	    				if ($imageInfo['image_width'] > $maxsize || $imageInfo['image_height'] > $maxsize) {
	    					$this->resizeImage($imageInfo,$maxsize);
	    				}
	    			}
	    		}
	    		if ($arrDataUpload['error']) {
	    			$json['error'] = 'Error '.implode(', ', $arrDataUpload['error']);
	    		}
    		}
    		
		} else {
			$json['error'] = $this->lang->line('fmag_error_directory');
		}
		if (!$json['error']) {
			$json['success'] = $this->lang->line('fmag_text_uploaded');
		}
		$this->output->set_output(json_encode($json));
	}

	public function fast_upload(){
		$type = $this->input->get("type");
		$json = array();
		$dir = date('Y/m/d');
		$responseType = $this->input->get("responseType");
        switch($type){
            case 'file':
            case 'url':
            $directory = $this->config->item('path_upload').'files/';
            $uploadurl = UPLOAD_URL.'files/'.$dir;
            break;
            case 'flash':
            $directory = $this->config->item('path_upload').'flash/';
            $uploadurl = UPLOAD_URL.'files/'.$dir;
            break;
            default:
            $directory = $this->config->item('path_upload').'images/'.$this->userimage;
            $uploadurl = UPLOAD_URL.'images/'.$this->userimage.$dir;
		}
		$path_upload = $directory.$dir;
		if (!is_dir($path_upload)) {
			@mkdir($path_upload,0755,TRUE);
		}
  	    $conf = $this->config->item("uploadconf");
        switch ($type) {
            case 'url':
            case 'file':
                $config = $conf['files'];
                break;
            case 'flash':
                $config = $conf['flash'];
                break;
            default:
                $config = $conf['images'];
        }
        $config['upload_path'] = $directory.$dir;
        unset($config['file_name']);
		$this->load->library('upload', $config);
		$number = (int) $this->input->get('CKEditorFuncNum');
		if (!$this->upload->do_upload('upload')) {
			$error = $this->upload->display_errors("","\n");
		}
		else {
			$data = $this->upload->data();
			// check to resize
			if ($type == 'image') {
				$maxsize = $config['autoresize'];
				if ($data['image_width'] > $maxsize || $data['image_height'] > $maxsize) {
					$this->resizeImage($data,$maxsize);
				}
			}
			
			$url = $uploadurl .'/'. $data['file_name'];
			switch ($responseType) {
				case 'json':
					$output = json_encode(array(
						'fileName' => $data['file_name'],
						"uploaded" => 1,
						"url" => $url
					));
					break;
				default:
					$output = '<script type="text/javascript">
window.parent.CKEDITOR.tools.callFunction("'.$number.'","' . $url .'", "");
</script>';
					break;
			}
		}
		if ($error) {
			switch ($responseType) {
				case 'json':
					$output = json_encode(array(
						'error' => array('number' => $number, 'message' => $error),
						"uploaded" => 0
					));
					break;
				default:
					$output = '<script type="text/javascript">
		    window.parent.CKEDITOR.tools.callFunction("'.$number.'", "", "'.$error.'");
		</script>';
					break;
			}
			
		}
		return $this->output->set_output($output);
	}
	function sort_file($a, $b) {
	    return $b['date'] - $a['date'];
	}
	function resizeImage($imageInfo,$maxsize) {
		$this->load->library('image_lib');
		$config = array(
			'image_library' => 'gd2',
			'source_image' => $imageInfo['full_path'],
			'create_thumb' => FALSE,
			'maintain_ratio' => TRUE,
			'thumb_marker' => '',
			'new_image' => $imageInfo['full_path'],
			'width'         => $maxsize,
			'height'       => $maxsize
		);
		if ($imageInfo['image_width'] > $imageInfo['image_height']) {
			$config['master_dim'] = 'width';
		}
		else {
			$config['master_dim'] = 'height';
		}
		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}



}
?>