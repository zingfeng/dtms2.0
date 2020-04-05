<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class MY_Pagination {

	var $prefix				= ''; // A custom prefix added to the path.
	var $suffix				= ''; // A custom suffix added to the path.
	var $total_rows			= ''; // Total number of items (database results)
	var $per_page			= 10; // Max number of items you want shown per page
	var $num_links			=  3; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page			=  1; // The current page being viewed
	var $first_link			= '<i class="fa fa-angle-double-left">« Trang đầu</i>';
	var $next_link			= FALSE;
	var $prev_link			= FALSE;
	var $last_link			= '<i class="fa fa-angle-double-left">Cuối Cùng »</i>';
	var $uri_segment		= 3;
	var $full_tag_open		= '<div id="pagination">';
	var $full_tag_close		= '</div>';
	var $first_tag_open		= '';
	var $first_tag_close	= '';
	var $last_tag_open		= '';
	var $last_tag_close		= '';
	var $first_url			= ''; // Alternative URL for the First Page.
	var $cur_tag_open		= '<a href="javascript:;" class="active current">';
	var $cur_tag_close		= '</a>';
	var $next_tag_open		= '';
	var $next_tag_close		= '';
	var $prev_tag_open		= '';
	var $prev_tag_close		= '';
	var $num_tag_open		= '';
	var $num_tag_close		= '';
	var $page_query_string	= FALSE;
	var $query_string_segment = 'page';
	var $display_pages		= TRUE;
	var $anchor_class		= '';
    var $total_page         = 1;
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		if ($this->anchor_class != '')
		{
			$this->anchor_class = 'class="'.$this->anchor_class.'" ';
		}
        
		log_message('debug', "Pagination Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
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

	// --------------------------------------------------------------------

	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */
	function create_links($param = 'page')
	{
        $param = $this->query_string_segment;
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0 OR $this->total_rows < $this->per_page)
		{
			return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);
		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}
        $this->total_page = $num_pages;
		// Determine the current page number.
		$CI =& get_instance();
        /* if ($this->first_link == ''){
           $this->first_link = $CI->lang->line('common_paging_first_link');   
        }
        if ($this->last_link == ""){
            $this->last_link = $CI->lang->line('common_paging_last_link');
        }
        if ($this->next_link == ''){
           $this->next_link = $CI->lang->line('common_paging_next_link');   
        }
        if ($this->prev_link == ""){
            $this->prev_link = $CI->lang->line('common_paging_prev_link');
        }*/
		$full_url = current_url();
        $array = $CI->input->get(NULL);
        //// unset param lang
        unset($array['lang']);
        ////
        $out = '';
        // kiem tra xem trong chuoi get da co page chua
        if (empty($array) || !array_key_exists($param,$array)){
            $curent_page = 1;
        }
        else{
            $curent_page = $array[$param];
        }
        $this->cur_page = $curent_page;   
		$this->num_links = (int)$this->num_links;
		if ($this->num_links < 1)
		{
			show_error('Your number of links must be a positive number.');
		}
		$start = (($curent_page - $this->num_links) > 1) ? $curent_page - ($this->num_links - 1) : 1;
		$end   = (($curent_page + $this->num_links) < $num_pages) ? $curent_page + $this->num_links : $num_pages;
        $output = '';

		// Render the "First" link
		if  ($this->first_link !== FALSE AND $curent_page > ($this->num_links + 1))
		{
			$first_url = ($this->first_url == '') ? $full_url : $this->first_url;
			$output .= $this->first_tag_open.'<a class="pagination_btn" title="'.$CI->lang->line('common_page_first').'" '.$this->anchor_class.'href="'.$first_url.'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  ($this->prev_link !== FALSE AND $curent_page != 1)
		{
			$i = $curent_page - 1;
			if ($i == 0 && $this->first_url != '')
			{
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}
			else
			{
				$i = ($i == 0) ? '' : $this->prefix.$i.$this->suffix;
                if ($i == 1){
                    unset($array[$param]);   
                }
                else{
                    $array[$param] = $i;    
                }
                $link = (empty($array)) ? $full_url : $full_url.'/?'.http_build_query($array);
                //$link = $full_url.'/?'.http_build_query($array);                                
				$output .= $this->prev_tag_open.'<a '.$this->anchor_class.'href="'.$link.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
			}

		}

		// Render the pages
		if ($this->display_pages !== FALSE)
		{
			// Write the digit links
			for ($loop = $start -1; $loop <= $end; $loop++)
			{
				$i = $loop;
                $array[$param] = $i;
                if ($i == 1){
                    $a = $array;
                    unset($a[$param]);
                    $link = (empty($a)) ? $full_url : $full_url.'/?'.http_build_query($a);
                    
                }
                else{
                    $link = $full_url.'/?'.http_build_query($array);
                }
				if ($i >= 1)
				{
					if ($curent_page == $loop)
					{
						$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
					}
					else
					{
						$n = ($i == 0) ? '' : $i;

						if ($n == '' && $this->first_url != '')
						{
							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$this->first_url.'">'.$loop.'</a>'.$this->num_tag_close;
						}
						else
						{
							$n = ($n == '') ? '' : $this->prefix.$n.$this->suffix;

							$output .= $this->num_tag_open.'<a '.$this->anchor_class.'href="'.$link.'">'.$loop.'</a>'.$this->num_tag_close;
						}
					}
				}
			}
		}

		// Render the "next" link
		if ($this->next_link !== FALSE AND $curent_page < $num_pages)
		{
            $array[$param] = $curent_page + 1;
            $link = $full_url.'/?'.http_build_query($array);
			$output .= $this->next_tag_open.'<a class="pagination_btn" '.$this->anchor_class.'href="'.$link.'"><i class="fa fa-angle-double-left">'.$this->next_link.'</i></a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if ($this->last_link !== FALSE AND ($curent_page + $this->num_links) < $num_pages)
		{
			$array[$param] = $num_pages;
            $link = $full_url.'/?'.http_build_query($array);
			$output .= $this->last_tag_open.'<a class="pagination_btn" '.$this->anchor_class.'href="'.$link.'"><i class="fa fa-angle-double-right">'.$this->last_link.'</i></a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */