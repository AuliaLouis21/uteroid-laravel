<?php
	$dir = "../gambar";
	$name = "";
	if(is_uploaded_file($_FILES['file']['tmp_name'])) {	
		$name = $dir.'/'.$_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'],$name);
		echo "success";
	}
?>