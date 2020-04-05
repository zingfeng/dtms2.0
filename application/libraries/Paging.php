<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paging {
	var $total_rows			= 0; // Total number of items (database results)
	var $per_page			= 10; // Max number of items you want shown per page
    var $next_text =  '<i class="fa fa-forward" aria-hidden="true"></i>';
    var $prev_text = '<i class="fa fa-backward" aria-hidden="true"></i>';
    var $first_text = '<i class="fa fa-fast-backward" aria-hidden="true"></i>';
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		log_message('debug', "Pagination Class Initialized");
	}
	function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
    function create_links($param = 'page'){
        $CI = &get_instance();
        $full_url = current_url();
        $array = $CI->input->get(NULL);
        $out = '';
        // kiem tra xem trong chuoi get da co page chua
        $curent_page = (!$array[$param]) ? 1 : $array[$param];
        // first link
        if ($curent_page >= 2){
            unset($array[$param]);
            $uri = http_build_query($array);
            if ($uri != ''){
                $uri = $full_url.'/?'.$uri;
            }
            else{
                $uri = $full_url;
            }
            if ($curent_page == 2){
                $out .= '<a data-toggle="tooltip" data-placement="top" title="'.$CI->lang->line('common_page_prev').'" href="'.$uri.'"><div class = "paging_prev">'.$this->prev_text.'</div></a>';
            }
            else{
                $out .= '<a data-toggle="tooltip" data-placement="top" title="'.$CI->lang->line('common_page_first').'" href = "'.$uri.'"><div class = "paging_first">'.$this->first_text.'</div></a>';
            }
        }
        $full_url = $full_url.'/?';
        if ($curent_page > 2){
            $array[$param] = $curent_page - 1;
            $uri = http_build_query($array);
            $uri = $full_url.$uri;
            $out .= '<a data-toggle="tooltip" data-placement="top" title="'.$CI->lang->line('common_page_prev').'" href="'.$uri.'"><div class = "paging_prev">'.$this->prev_text.'</div></a>';
        }
        if ($this->total_rows > $this->per_page){
            $array[$param] = $curent_page + 1;
            $uri = http_build_query($array);
            $uri = $full_url.$uri;
            $out .= '<a data-toggle="tooltip" data-placement="top" title="'.$CI->lang->line('common_page_next').'" href="'.$uri.'"><div class = "paging_next">'.$this->next_text.'</div></a>';
        }
        if ($out) {
            $out = '<div class="paging_next_prev">'.$out.'</div>';
        }
        return $out;
    }
 }