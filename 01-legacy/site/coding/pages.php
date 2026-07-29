<?php
	$slug = mysqli_real_escape_string($konek,$_GET['p']);
	$ql = mysqli_query($konek,"SELECT * FROM page WHERE slug = '$slug' LIMIT 1");
	$dt = mysqli_fetch_array($ql);

	#------------------------
	$title = ucwords($dt[1]);
	
	define("_Title_","$title | Utero Advertising");
	
	require("$dirview/header.php");
	require("$dirview/$include/$include_files[$include]");
	require("$dirview/footer.php");
?>