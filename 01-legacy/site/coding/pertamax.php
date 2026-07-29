<?php
	//$ql = mysqli_query("SELECT * FROM produk WHERE promo='0' ORDER BY id DESC LIMIT 9",$konek); // tampil data promo saja sementara di disable
	$qw =  "SELECT a.* FROM produk a
			INNER JOIN catproduk b ON a.cat = b.id
			ORDER BY a.id DESC LIMIT 12";
		
	$ql = mysqli_query($konek,$qw);
	$empty = (!$ql || mysqli_num_rows($ql) < 1)?"Maaf Data Masih Kosong":NULL;
	
	$qlr = mysqli_query($konek,"SELECT * FROM produk ORDER BY rand() LIMIT 10");
	$i = 0;
	
	$qpro = "SELECT a.* FROM produk a
			INNER JOIN catproduk b ON a.cat = b.id
			INNER JOIN image d ON a.id = d.produkid
			WHERE promo = '1'";
			
	$qls = mysqli_query($konek,$qpro);
	//$dts = mysqli_fetch_array($qls);
	
	//------------------------------------------------------------------
	define("_Title_","Utero Advertising | Idea And Concept Factory");
	
	require("$dirview/header.php");
	require("$dirview/$include/$include_files[$include]");
	require("$dirview/footer.php");
?>