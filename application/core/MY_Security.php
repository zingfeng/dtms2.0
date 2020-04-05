<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class MY_Security extends CI_Security{
    protected function _remove_evil_attributes($str, $is_image)
	{
		// All javascript event handlers (e.g. onload, onclick, onmouseover), style, and xmlns
		$evil_attributes = array('on\w*', 'xmlns', 'formaction');

		if ($is_image === TRUE)
		{
			/*
			 * Adobe Photoshop puts XML metadata into JFIF images,
			 * including namespacing, so we have to allow this for images.
			 */
			unset($evil_attributes[array_search('xmlns', $evil_attributes)]);
		}
		do {
			$count = 0;
			$attribs = array();

			// find occurrences of illegal attribute strings without quotes
			preg_match_all('/('.implode('|', $evil_attributes).')\s*=\s*([^\s>]*)/is', $str, $matches, PREG_SET_ORDER);

			foreach ($matches as $attr)
			{

				$attribs[] = preg_quote($attr[0], '/');
			}

			// find occurrences of illegal attribute strings with quotes (042 and 047 are octal quotes)
			preg_match_all("/(".implode('|', $evil_attributes).")\s*=\s*(\042|\047)([^\\2]*?)(\\2)/is",  $str, $matches, PREG_SET_ORDER);

			foreach ($matches as $attr)
			{
				$attribs[] = preg_quote($attr[0], '/');
			}

			// replace illegal attribute strings that are inside an html tag
			if (count($attribs) > 0)
			{
				$str = preg_replace("/<(\/?[^><]+?)([^A-Za-z<>\-])(.*?)(".implode('|', $attribs).")(.*?)([\s><])([><]*)/i", '<$1 $3$5$6$7', $str, -1, $count);
			}

		} while ($count);

		return $str;
	}
	/**
     * @author: namtq
     * @todo: Generate token key
     * @param: string_id
     */
	public function generate_token_post($id) {
		$CI = get_instance();
		if(is_array($id)) {
			$id = implode('_', $id);
		}
		return md5($CI->config->item('token_key_random') . $id);
	}
	/**
     * @author: namtq
     * @todo: verify token key
     * @param: string_id, string verify
     */
	public function verify_token_post($id,$str) {
		$CI = get_instance();
		if(is_array($id)) {
			$id = implode('_', $id);
		}
		$strVerify = md5($CI->config->item('token_key_random') . $id);
		return ($strVerify == $str) ? TRUE : FALSE;
	}
}