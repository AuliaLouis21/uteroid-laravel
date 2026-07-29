<?php

	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	switch($_POST['submit']){
		case "upload":
			if($_POST['nama']==""){
				$error[] 		= TRUE;
				$err[] 			= "Nama Tidak Boleh Kosong"; 
			}
						
			$imgfile = $_FILES['file']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['file']['name'] == ""){
				$error[]		= TRUE;
				$err[]			= "file Tidak Boleh Kosong";
			}
			
			else if($ext=="dat" || $ext=="avi" || $ext=="mpg" || $ext=="vob"){
				$error[]		= TRUE;
				$err[]			= "File Tidak Di Ijinkan karna mengancam masa depan anda :D";
			}
			
			else if($_FILES['file']['size'] > "1073741824" ){
				$error[]		= TRUE;
				$err[]			= "Gambar Tidak Boleh Melebihi 100 Mb";
			}

			$slug = $_POST['nama'];
			$slug = bikinslug($slug);
			
			$q=mysql_query("select id from dataupload where slug='$slug'",$konek);
			if(mysql_num_rows($q)>0){
				$error[]		= TRUE;
				$err[]			= "Gunakan Nama Lain";
			}
			
			$targetdir = "./../xdata";
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
					$inp="INSERT INTO dataupload (nama,slug,ext,tgl,jam) 
						VALUES ('".$_POST['nama']."', '$slug', '$ext', '$tgl', '$jam')";
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
					$dlp=mysql_query("SELECT * FROM dataupload WHERE id='$delitem'",$konek)or die(mysql_error());							
					if(mysql_num_rows($dlp)>0){
						while($dlpc=mysql_fetch_array($dlp)){						
							unlink("./../xdata/".$dlpc['2'].".".$dlpc['3'])or die("delete error");
							$ql=mysql_query("DELETE FROM dataupload WHERE id='$delitem'",$konek)or die(mysql_error());
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
		case "create":
			$i = 0;
			$ql = mysql_query("SELECT * FROM dataupload ORDER BY id DESC",$konek);
			
			require_once("$includev/$include.c.php");
			break;
			
		default:
			$i = 0;
			$ql = mysql_query("SELECT * FROM dataupload ORDER BY id DESC",$konek);
			
			require_once("$includev/$include.c.php");
			break;	
			
	endswitch;
?>