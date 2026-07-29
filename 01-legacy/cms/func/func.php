<?php
    function bikinslug($string) {
		$slug = strtolower(trim($string));
		$slug = preg_replace("/([[:space:]]|-)+/", "-", $slug);
		$slug = preg_replace("/[^a-z0-9-]/", "-", $slug);
		$slug = preg_replace("/-+/", "-", $slug);
		$slug = preg_replace("[(-$)]", "", $slug);
		$slug = preg_replace("/^[-]/","", $slug);
		
		return $slug;
    }
	
	function amankan($var){
		$add = mysql_real_escape_string($var);
		
		return $add;
	}
	
	function fnValidateUrl($url){
		return preg_match('/^(http(s?):\/\/|ftp:\/\/{1})((\w+\.){1,})\w{2,}$/i', $url);
	}
	
	function isValidEmail($email){
		return preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $email);
	}
	
	function noimg($text){
		$match = preg_replace('#(<[/]?img.*>)#U', "", $text);
		$match = str_replace("<p>","",$match);
		return $match;
	}		
?>