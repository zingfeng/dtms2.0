<?php
function img($src = '', $index_page = FALSE)
{
	if ( ! is_array($src) )
	{
		$src = array('src' => $src);
	}

	// If there is no alt attribute defined, set it to an empty string
	if ( ! isset($src['alt']))
	{
		$src['alt'] = '';
	}

	$img = '<img';

	foreach ($src as $k=>$v)
	{

		if ($k == 'src' AND strpos($v, '://') === FALSE)
		{
			$CI =& get_instance();

			if ($index_page === TRUE)
			{
				$img .= ' src="'.$CI->config->site_url($v).'"';
			}
			else
			{
				$img .= ' src="'.$CI->config->item('img').$v.'"';
			}
		}
		else
		{
			$img .= " $k=\"$v\"";
		}
	}

	$img .= '/>';

	return $img;
}
function swf($src = '', $index_page = FALSE)
{
	if ( ! is_array($src) )
	{
		$src = array('src' => $src);
	}
	// If there is no alt attribute defined, set it to an empty string

	$swf = '<embed type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" quality="high"';

	foreach ($src as $k=>$v)
	{

		if ($k == 'src' AND strpos($v, '://') === FALSE)
		{
			$CI =& get_instance();

			if ($index_page === TRUE)
			{
				$swf .= ' src="'.$CI->config->site_url($v).'"';
			}
			else
			{
				$swf .= ' src="'.$CI->config->item('img').$v.'"';
			}
		}
		else
		{
			$swf .= " $k=\"$v\"";
		}
	}

	$swf .= '/>';

	return $swf;
}
function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
{
	$CI =& get_instance();

	$link = '<link ';

	if (is_array($href))
	{
		foreach ($href as $k=>$v)
		{
			if ($k == 'href' AND strpos($v, '://') === FALSE)
			{
				/*if ($index_page === TRUE)
				{
					$link .= 'href="'.$CI->config->site_url($CI->config->item('theme').'/'.$v).'" ';
				}
				else
				{*/
					$link .= 'href="'.$CI->config->item('css').$v.'" ';
				//}
			}
			else
			{
				$link .= "$k=\"$v\" ";
			}
		}

		$link .= "/>";
	}
	else
	{
		if ( strpos($href, '://') !== FALSE)
		{
			$link .= 'href="'.$href.'" ';
		}
		elseif ($index_page === TRUE)
		{
			$link .= 'href="'.$CI->config->site_url($CI->config->item('css').$href).'" ';
		}
		else
		{
			$link .= 'href="'.$CI->config->item('css').$href.'" ';
		}

		$link .= 'rel="'.$rel.'" type="'.$type.'" ';

		if ($media	!= '')
		{
			$link .= 'media="'.$media.'" ';
		}

		if ($title	!= '')
		{
			$link .= 'title="'.$title.'" ';
		}

		$link .= '/>';
	}


	return $link;
}
function js($src,$index_page = FALSE)
{
	if ( ! is_array($src) )
	{
		$src = array('src' => $src);
	}
	$js = '<script';

	foreach ($src as $k=>$v)
	{

		if ($k == 'src' AND strpos($v, '://') === FALSE)
		{
			$CI =& get_instance();

			if ($index_page === TRUE)
			{
				$js .= ' src="'.$CI->config->site_url($CI->config->item('js').$v).'"';
			}
			else
			{
				$js .= ' src="'.$CI->config->item('js').$v.'"';
			}
		}
		else
		{
			$js .= " $k=\"$v\"";
		}
	}

	$js .= '></script>';

	return $js;
}