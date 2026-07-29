<?php
//file coding
		$p=0;
		$picture=mysqli_query($konek,"SELECT a.* , b.nama, b.slug FROM pictgal a INNER JOIN albumpic b ON a.cat = b.id ORDER BY a.tgl DESC LIMIT 6");
		
		$v=0;
		$video=mysqli_query($konek,"SELECT * FROM vidgal ORDER BY id DESC LIMIT 6");	
		require_once("$func/youtube.class.php");
		$yvid = new YouTube();
		
		$a=0;
		$audio=mysqli_query($konek,"SELECT * FROM audgal ORDER BY id DESC LIMIT 3");		

		#------------------------	
		define("_Title_","Gallery | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include_files[$include]");
		require("$dirview/footer.php");
?>