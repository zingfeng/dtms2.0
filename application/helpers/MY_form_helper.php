<?php
// add extra
function form_hidden($name, $value = '', $recursing = FALSE, $extra = '')
{
	static $form;

	if ($recursing === FALSE)
	{
		$form = "\n";
	}

	if (is_array($name))
	{
		foreach ($name as $key => $val)
		{
			form_hidden($key, $val, TRUE);
		}
		return $form;
	}

	if ( ! is_array($value))
	{
		$form .= '<input type="hidden" name="'.$name.'" value="'.form_prep($value, $name).'" '.$extra.'/>'."\n";
	}
	else
	{
		foreach ($value as $k => $v)
		{
			$k = (is_int($k)) ? '' : $k;
			form_hidden($name.'['.$k.']', $v, TRUE);
		}
	}

	return $form;
}
// change default
function form_textarea($data = '', $value = '', $extra = '')
{
	$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'cols' => '40', 'rows' => '5');

	if ( ! is_array($data) OR ! isset($data['value']))
	{

		$val = $_POST[$data] ? $_POST[$data] : $value;
	}
	else
	{
		$val = $data['value'];
		unset($data['value']); // textareas don't use the value attribute
	}

	$name = (is_array($data)) ? $data['name'] : $data;
	return "<textarea "._parse_form_attributes($data, $defaults).$extra.">".form_prep($val, $name)."</textarea>";
}
// dropdown default
function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
{
	$post = str_replace('[]','',$name);
	if ( ! is_array($selected))
	{
		$selected = array($selected);
	}

	// If no selected state was submitted we will attempt to set it automatically
	//if (count($selected) === 0)
	//{
		// If the form name appears in the $_POST array we have a winner!
		if (isset($_POST[$post]))
		{
			if (is_array($_POST[$post])){
				$selected = $_POST[$post];
			}
			else{
				$selected = array($_POST[$post]);
			}
		}

	//}

	if ($extra != '') $extra = ' '.$extra;

	$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

	$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

	foreach ($options as $key => $val)
	{
		$key = (string) $key;

		if (is_array($val) && ! empty($val))
		{
			$form .= '<optgroup label="'.$key.'">'."\n";

			foreach ($val as $optgroup_key => $optgroup_val)
			{
				$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
			}

			$form .= '</optgroup>'."\n";
		}
		else
		{
			$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

			$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
		}
	}

	$form .= '</select>';

	return $form;
}
function form_checkbox($data = '', $value = '', $checked = FALSE, $extra = '')
{
	$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

	if (is_array($data) AND array_key_exists('checked', $data))
	{
		$checked = $data['checked'];

		if ($checked == FALSE)
		{
			unset($data['checked']);
		}
		else
		{
			$data['checked'] = 'checked';
		}
	}

	if ($checked == TRUE || $checked == $value)
	{
		$defaults['checked'] = 'checked';
	}
	else
	{
		unset($defaults['checked']);
	}
	if (isset($_POST[$data]) && $_POST[$data] == $value){
		$defaults['checked'] = 'checked';
	}
	if (count($_POST) > 0 && !isset($_POST[$data])){
		unset($defaults['checked']);
	}

	return "<input "._parse_form_attributes($data, $defaults).$extra." />";
}
function form_detail($data,$value,$config = array()){

    $out = '';
    $default_config = array('height' => '400','toolbar' => 'Custom');
    $config = array_merge($default_config,$config);
    $CI = &get_instance();
    if (!defined('CKEDITOR_LOAD')){
        $out .= '<script type="text/javascript" src="'.BASE_URL.'/3rd/ckeditor/ckeditor.js"></script>';
        define("CKEDITOR_LOAD","loaded");
    }
    if ($CI->input->post($data)){
        $value = $CI->input->post($data);
    }
    $out .= form_textarea($data,$value);
    $out .= '<script type="text/javascript">';

    if (!empty($config)){
        $cfg .= '{';
        $i = 1;
        foreach ($config as $key => $value){
            //$out .= 'CKEDITOR.config.'.$key.' = \''.$value.'\';';
            if ($i > 1) {
                $cfg .= ' , ';
            }
            $cfg .= $key.' : \''.$value.'\'';
            $i ++;
        }
        $cfg .= '}';
    }
    //$out .= 'CKEDITOR.config.baseHref = \''.base_url().'ckeditor/\';';
    $out .= '$("document").ready(function(){CKEDITOR.replace( \''.$data.'\' , '. $cfg .');});';
	$out .= '</script>';
    return $out;
    //CKEDITOR.config.baseHref = \''.$CI->config->item('api').'images/resize/0_0/userfiles/\';
}

function set_value($field, $default = '', $escape = TRUE)
{
	$CI =& get_instance();

	$value = (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
		? $CI->form_validation->set_value($field, $default)
		: $CI->input->post($field, FALSE);
    if(FALSE){
        return html_escape($value === NULL ? $default : $value);
    } else {
        return $value === NULL ? $default : $value;
    }
}