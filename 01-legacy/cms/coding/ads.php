<?php

	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	switch($_POST['submit']){
		case "upload":
			if($_POST['nama']==""){
				$error[] 		= TRUE;
				$err[] 			= "Judul Tidak Boleh Kosong"; 
			}
			
			if($_POST['info']==""){
				$error[] 		= TRUE;
				$err[] 			= "Info / Keterangan masi kosong"; 
			}			
						
			$imgfile = $_FILES['file']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['file']['name'] == ""){
				$error[]		= TRUE;
				$err[]			= "Gambar Tidak Boleh Kosong";
			}
			
			else if($ext!=="jpg" && $ext!=="png" && $ext!=="gif"){
				$error[]		= TRUE;
				$err[]			= "File Tidak Di Ijinkan k'rna mengancam masa depan anda :D";
			}
			
			else if($_FILES['file']['size'] > "104857600" ){
				$error[]		= TRUE;
				$err[]			= "Gambar Tidak Boleh Melebihi 100 kb";
			}

			$slug = $_POST['nama'];
			$slug = bikinslug($slug);
			
			$q=mysql_query("select id from ads where slug='$slug'",$konek);
			if(mysql_num_rows($q)>0){
				$error[]		= TRUE;
				$err[]			= "Gunakan Judul Lain";
			}
			
			$targetdir = "./../iklan";
			(file_exists($targetdir))?"dir has been created!!":mkdir("$targetdir", 0775);

			if(isset($error)){
				$errmsg = trim("$err");
				$errmsg = implode("<br/ >",$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}else{				
				$tgl = date("Y-m-d");
				$jam = date("h:i:s");
				
				$upload = move_uploaded_file($_FILES['file']['tmp_name'], "$targetdir/$slug.$ext") or die("error");
				
				if($upload){
					$inp="INSERT INTO ads (judul,info,slug,img,tgl,jam) 
						VALUES ('".$_POST['nama']."', '".$_POST['info']."', '$slug', '$slug.$ext', '$tgl', '$jam')";
					$q = mysql_query($inp,$konek)or die(mysql_error());
					if($q){
						$sukses = TRUE;
					}
				}				
			}
			
		break;
		
		case "Delete":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$msgdel = NULL;					
					$dlp=mysql_query("SELECT * FROM ads WHERE id='$delitem'",$konek)or die(mysql_error());							
					if(mysql_num_rows($dlp)>0){
						while($dlpc=mysql_fetch_array($dlp)){						
							unlink("./../iklan/".$dlpc['4'])or die("delete error");
							$ql=mysql_query("DELETE FROM ads WHERE id='$delitem'",$konek)or die(mysql_error());
						}
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}			
		break;
		
	}
	
	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "edit":
			$i = 0;
			$ql = mysql_query("SELECT * FROM ads ORDER BY id DESC",$konek);
			$qlx = mysql_query("SELECT * FROM ads ORDER BY id DESC",$konek);
			$dtx = mysql_fetch_array($qlx);
			
			$bt = "edit";

			require_once("$includev/$include.e.php");
			break;
			
		default:
			$i = 0;
			$ql = mysql_query("SELECT * FROM ads ORDER BY id DESC",$konek);
			
			$bt = "upload";
			require_once("$includev/$include.c.php");
			break;	
			
	endswitch;
?>