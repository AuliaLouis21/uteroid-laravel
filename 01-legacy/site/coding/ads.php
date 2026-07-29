<?php
	if(isset($_GET['v'])){
		$slug = mysqli_real_escape_string($_GET['v']);
		$ql = mysqli_query($konek,"SELECT * FROM ads WHERE slug='$slug' LIMIT 1");
		$dt=mysqli_fetch_array($ql);	
		
		$q=mysqli_query($konek,"SELECT * FROM posts LIMIT 5");
		mysqli_query($konek,"update ads set akses=akses+1 where slug='$slug'");
		
		$title = $dt['1'];
		define("_Title_","News : $title | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include.detil.php");
		require("$dirview/footer.php");		
	}
?>