<?php
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "upload":
			if($_POST['cat']==""){
				$error[]		= TRUE;
				$err[]		= "Anda Belum Pilih Kategori";
			}
			
			if($_POST['nama']==""){
				$error[]		= TRUE;
				$err[]		= "Judul Produk Tidak Boleh Kosong";
			}
			
			if($_POST['descript']==""){
				$error[]		= FALSE;
				$err[]		= "Harga Tidak Boleh Kosong";
			}
			
			$imgfile = $_FILES['img']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['img']['name'] == ""){
				$error[]		= TRUE;
				$err[]		= "Gambar Tidak Boleh Kosong";
			}
			else if($ext !== "jpg"){
				$error[]		= TRUE;
				$err[]		= "Format Gambar Harus JPEG";
			}
			
			else if($_FILES['img']['size'] > "2097152" ){
				$error[]		= TRUE;
				$err[]		= "Gambar Tidak Boleh Melebihi 200Kb";
			}
				
			$slug = $_POST['nama'];
			$slug = bikinslug($slug);
			
			$targetdir = "./../gallery";
			(file_exists($targetdir))?"dir has been created!!":mkdir("$targetdir", 0775);
			
			$n=1;
			$namabaru = "$slug.$ext";
			while(file_exists("$targetdir/$namabaru")){
				$namabaru = "$slug-".$n++.".$ext";			
			}
			
			$slugnya = substr("$namabaru", 0, strrpos("$namabaru", "."));  //hapus ext di jadikan slug	
			
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$errmsg= "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>Error</b><br>";
				
				require_once("func/resimg.php");
				$upload = move_uploaded_file($_FILES['img']['tmp_name'], "$targetdir/$namabaru") or die("$errmsg");
				Resize("$targetdir/$namabaru");
				ResizeKecil("$targetdir/$namabaru");
				
				if($upload){
					$inp="INSERT INTO pictgal (judul,img,ket,tgl,jam,slug,cat) 
						  VALUES ('".$_POST['nama']."','$namabaru','".$_POST['descript']."','$tgl','$jam','$slugnya','".$_POST['cat']."')";
					$q = mysql_query($inp,$konek)or die(mysql_error());
					if($q){
						$sukses = TRUE;
						$errmsg= "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>Sukses</b><br>";
						#echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"1; url=./?cms=gallery\">";
					}
				}
			}else{
				$errmsg = implode("<br/ >",$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "Add New Album":
			if($_POST['nama']==""){
				$error		= TRUE;
				$err[]		= "Nama Kategori Tidak Boleh Kosong";
			}
			if($_POST['descript']==""){
				$error		= TRUE;
				$err[]		= "Keterangan Tidak Boleh Kosong";
			}
			
			$slug = $_POST['nama'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			if(!isset($error)){
				$inp="INSERT INTO albumpic (nama,
										 	slug,
											descript) VALUES ('".$_POST['nama']."',
														  	  '$slug',
															  '".$_POST['descript']."')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode('<br>',$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "Delete Product Type":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$ql=mysql_query("DELETE FROM `jnsproduk` WHERE `id`='$delitem' LIMIT 1",$konek);
					if($ql){
						$msg[] = "$delitem deleted";
						$msgdel = implode('<br>',$msg);
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "Delete Album":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$msgdel = NULL;
					#$dl=mysql_query("SELECT * FROM albumpic WHERE id='$delitem'",$konek)or die(mysql_error());
					$ql=mysql_query("DELETE FROM albumpic WHERE id='$delitem'",$konek)or die(mysql_error());
					#while($alb = mysql_fetch_array($dl)){
						#$alb = mysql_fetch_array($dl);
						#$msgdel=$delitem." Deleted <br>";
					#}
					
					$dlp=mysql_query("SELECT * FROM pictgal WHERE `cat`='$delitem'",$konek)or die(mysql_error());							
					if(mysql_num_rows($dlp)>0){
						while($dlpc=mysql_fetch_array($dlp)){						
							#$msg[] = "$delitem deleted";
							#$msgdel = implode('<br>',$msg);
							unlink("./../gallery/".$dlpc['2'])or die("delete error");
							unlink("./../gallery/thumb/rk_".$dlpc['2'])or die("delete error");
							unlink("./../gallery/img/r_".$dlpc['2'])or die("delete error");
							$ql=mysql_query("DELETE FROM `pictgal` WHERE `cat`='$delitem'",$konek)or die(mysql_error());
						}
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}			
		break;
		
		//--------------------------------------------------------------------		
		
		case "upload audio":			
			if($_POST['nama']==""){
				$error[]		= TRUE;
				$err[]		= "Judul Produk Tidak Boleh Kosong";
			}
			
			if($_POST['descript']==""){
				$error[]		= FALSE;
				$err[]		= "keterangan Tidak Boleh Kosong";
			}
			
			$imgfile = $_FILES['aud']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['aud']['name'] == ""){
				$error[]		= TRUE;
				$err[]		= "file Tidak Boleh Kosong";
			}
			else if($ext !== "mp3" && $ext !== "wav"){
				$error[]		= TRUE;
				$err[]		= "Format Gambar Harus mp3 atau wav";
			}
			
			else if($_FILES['aud']['size'] > "10737418240" ){
				$error[]		= TRUE;
				$err[]		= "File Tidak Boleh Melebihi 10Mb";
			}
				
			$slug = $_POST['nama'];
			$slug = bikinslug($slug);
			
			$targetdir = "./../audio";
			(file_exists($targetdir))?"dir has been created!!":mkdir("$targetdir", 0775);
			
			$n=1;
			$namabaru = "$slug.$ext";
			while(file_exists("$targetdir/$namabaru")){
				$namabaru = "$slug-".$n++.".$ext";			
			}
			
			$slugnya = substr("$namabaru", 0, strrpos("$namabaru", "."));  //hapus ext di jadikan slug	
			
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$errmsg= "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>Error</b><br>";
				
				$upload = move_uploaded_file($_FILES['aud']['tmp_name'], "$targetdir/$namabaru") or die("$errmsg");
				
				if($upload){
					$inp="INSERT INTO audgal (judul,ket,aud,tgl,jam,slug)
						  VALUES ('".$_POST['nama']."','".$_POST['descript']."','$namabaru','$tgl','$jam','$slugnya')";
					$q = mysql_query($inp,$konek)or die(mysql_error());
					if($q){
						$sukses = TRUE;
						$errmsg= "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>Sukses</b><br>";
						#echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"1; url=./?cms=gallery\">";
					}
				}
			}else{
				$errmsg = implode("<br/ >",$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
		break;
		
		//--------------------------------------------------------------------

		case "Delete Audio":
			foreach($_POST['del'] as $delitem){
				$qs=mysql_query("SELECT * FROM audgal WHERE `id`='$delitem'",$konek)or die(mysql_error());
				$d=mysql_fetch_array($qs);
				
				$ql=mysql_query("DELETE FROM audgal WHERE `id`='$delitem'",$konek)or die(mysql_error());
				if($ql){
					unlink("./../audio/".$d['3'])or die("delete error");
					$msg[] = "$delitem deleted";
					$msgdel = implode('<br>',$msg);
				}
			}
		break;	

		//--------------------------------------------------------------------	
		
		case "add video":
			if($_POST['nama']==""){
				$error[]		= TRUE;
				$err[]			= "Title Tidak Boleh Kosong";
			}
			
			if($_POST['descript']==""){
				$error[]		= TRUE;
				$err[]			= "Keterangan Tidak Boleh Kosong";
			}
			
			if($_POST['vid']==""){
				$error[]		= TRUE;
				$err[]			= "Video Tidak Boleh Kosong";
			}
			
			if(isset($error)){
				$errmsg = implode('<br>',$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}else{
				$slug	= bikinslug($_POST['nama']);				
				$tgl 	= date("Y-m-d");
				$jam 	= date("h:i:s");
				
				$q=mysql_query("INSERT INTO vidgal (judul,ket,vid,tgl,jam,slug) 
								VALUES ('".$_POST['nama']."', '".$_POST['descript']."', '".$_POST['vid']."', '$tgl', '$jam', '$slug')",$konek)or die(mysql_error());
			}
			
		break;
		
		//--------------------------------------------------------------------			

		case "Delete":
			foreach($_POST['del'] as $delitem){
				$ql=mysql_query("DELETE FROM vidgal WHERE `id`='$delitem'",$konek)or die(mysql_error());
				if($ql){
					$msg[] = "$delitem deleted";
					$msgdel = implode('<br>',$msg);
				}
			}
		break;
		
		//--------------------------------------------------------------------

		case "Delete Images":
			foreach($_POST['del'] as $delitem){
				$qs=mysql_query("SELECT * FROM pictgal WHERE `id`='$delitem'",$konek)or die(mysql_error());
				$img=mysql_fetch_array($qs);
				
				$ql=mysql_query("DELETE FROM pictgal WHERE `id`='$delitem'",$konek)or die(mysql_error());
				if($ql){
					unlink("./../gallery/".$img['2'])or die("delete error");
					unlink("./../gallery/thumb/rk_".$img['2'])or die("delete error");
					unlink("./../gallery/img/r_".$img['2'])or die("delete error");
					$msg[] = "$delitem deleted";
					$msgdel = implode('<br>',$msg);
				}
			}
		break;
	}	

	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "audio":
			$i = 0;
			$qv = mysql_query("SELECT * FROM audgal ORDER BY id DESC",$konek);
			
			require_once("$includev/$include.aud.php");
		break;		
		
		case "vid":
			$i = 0;
			$qv = mysql_query("SELECT * FROM vidgal ORDER BY id DESC",$konek);
			
			require_once("$includev/$include.vid.php");
		break;
		
		case "cat":
			$ql = mysql_query("SELECT * FROM albumpic ORDER BY nama ASC",$konek);
			$empty = (mysql_num_rows($ql) < "1")?"Maaf Data Masih Kosong":NULL;
			
			require_once("./func/count.php");
			require_once("$includev/$include.cat.php");
		break;	
			
		default:
			$i=0;
			$ql = mysql_query("SELECT * FROM pictgal ORDER BY id DESC");
			
		
			$gx=NULL;
			$qlg=mysql_query("SELECT * FROM albumpic ORDER BY nama ASC",$konek);
			while($dg=mysql_fetch_array($qlg)){
				$gx.="<option value=\"$dg[0]\">$dg[1]</option>";
			}		
            
			require_once("$includev/$include.c.php");
		break;
			
	endswitch;
	
?>