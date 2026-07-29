<?php

	$qw =  "SELECT a.* FROM produk a
			INNER JOIN catproduk b ON a.cat = b.id
			INNER JOIN jnsproduk c ON b.id = c.cat
			INNER JOIN image d ON a.id = d.produkid
			ORDER BY id DESC LIMIT 9";
		
	$ql = mysqli_query($konek,$qw);
	$empty = (!$ql || mysqli_num_rows($ql) < 1)?"Maaf Data Masih Kosong":NULL;
	
	$qlr = mysqli_query($konek,"SELECT * FROM produk ORDER BY rand() LIMIT 10");
	$i = 0;

	#load theme---------------------
	
	define("_Title_","Utero Advertising | Idea And Concept Factory");
	
	require("$dirview/header.php");
	require("$dirview/$include/$include_files[$include]");
	require("$dirview/footer.php");
?>