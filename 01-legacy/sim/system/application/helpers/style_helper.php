<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('stylesheet_tag')) {
	function stylesheet_tag() {
		$result = '<link rel="stylesheet" type="text/css" media="screen" href="'. base_url().'resources/style/style.css'.'"/>';
		return $result;
	}
}

if(! function_exists('login_stylesheet_tag')) {
	function login_stylesheet_tag() {
		return '<link rel="stylesheet" media="screen" type="text/css" href="'.base_url().'resources/style/login.css"/>';
	}
}
if(! function_exists('jquery_ui_stylesheet_tag')) {
	function jquery_ui_stylesheet_tag() {
		$result = '<link rel="stylesheet" type="text/css" media="screen" href="'. base_url().'resources/jqueryui/css/smoothness/jquery-ui-1.7.2.custom.css'.'"/>';
		return $result;
	}
}

if(! function_exists('jquery_ui_tag')) {
	function jquery_ui_tag() {
		return '<script type="text/javascript" src="'.base_url().'resources/jqueryui/js/jquery-ui-1.7.2.custom.min.js"></script>';
	}
}

if(!function_exists('jquery_autocomplete_tag')) {
	function jquery_autocomplete_tag() {
		$script = '<script type="text/javascript" src="'.base_url().'resources/autocomplete/autocomplete.js"></script>';
		$css = '<link type="text/css" media="screen" rel="stylesheet" href="'.base_url().'resources/autocomplete/autocomplete.css"/>';
		return $script . $css;
	}
}

if(! function_exists('jquery_tag')) {
	function jquery_tag() {
		return '<script type="text/javascript" src="'.base_url().'resources/jqueryui/js/jquery-1.3.2.min.js"></script>';
	}
}
if(!function_exists('javascript_ajax_tag')) {
	function javascript_ajax_tag() {
		return '<script type="text/javascript" src="'.base_url().'resources/scripts/ajax.js"></script>';
	}
}
	
if(!function_exists('javascript_util_tag')) {
	function javascript_util_tag() {
		return '<script type="text/javascript" src="'.base_url().'resources/scripts/util.js"></script>';
	}
}
if(!function_exists('jquery_blockui_tag')) {
	function jquery_blockui_tag() {
		return '<script type="text/javascript" src="'.base_url().'resources/blockui/blockui.js"></script>';
	}
}

if(!function_exists('jquery_blockui_image_tag')) {
	function jquery_blockui_image_tag() {
		return '<img src="'.base_url().'resources/blockui/busy.gif" />';
	}
}
