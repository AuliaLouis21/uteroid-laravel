<?php
		
	//ambil image dari posting
	function str_img_src($html) {
		if (stripos($html, '<img') !== false) {
			$imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
			preg_match($imgsrc_regex, $html, $matches);
			unset($imgsrc_regex);
			unset($html);
			if (is_array($matches) && !empty($matches)) {
				return $matches[2];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function noimg($text){
		$match = preg_replace('#(<[/]?img.*>)#U', "", $text);
		$match = str_replace("<p>","",$match);
		return $match;
	}	
	
	function tagimg($img, $alt){
		echo "<img src=\"$img\" alt=\"$alt\"/>";
	}
	
	function fnValidateAlphanumeric($string)
	{
		return preg_match('/[^a-zA-Z0-9\s]/', '', $string);
	}
	
	function isValidEmail($email){
		return preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $email);
	}
	
	function amankan($var){
    global $konek;

    $add = addslashes($var);
    $add = mysqli_real_escape_string($konek, $add);

    return $add;
}

function perhuruf($huruf){
    global $konek;

    return mysqli_query(
        $konek,
        "SELECT * FROM catproduk WHERE nama LIKE '$huruf%'"
    );
}
?>