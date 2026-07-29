<?php
	function page($include, $slug){
		if($include==$slug){
			$embuh = "id=\"current\"";
		}else{
			$embuh = NULL;
		}
		
		return $embuh;
	}
?>