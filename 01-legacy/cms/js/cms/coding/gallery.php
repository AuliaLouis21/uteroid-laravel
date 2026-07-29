<?php
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "upload":
			if($_POST['cat']==""){
				$error		= TRUE;
				$err[]		= "Anda Belum Pilih Kategori";
			}
			
			if($_POST['nama']==""){
				$error		= TRUE;
				$err[]		= "Judul Produk Tidak Boleh Kosong";
			}
			
			if($_POST['descript']==""){
				$error		= FALSE;
				$err[]		= "Harga Tidak Boleh Kosong";
			}
			
			$imgfile = $_FILES['img']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['img']['name'] == ""){
				$error		= TRUE;
				$err[]		= "Gambar Tidak Boleh Kosong";
			}
			else if($ext !== "jpg"){
				$error		= TRUE;
				$err[]		= "Format Gambar Harus JPEG";
			}
			
			else if($_FILES['img']['size'] > "2097152" ){
				$error		= TRUE;
				$err[]		= "Gambar Tidak Boleh Melebihi 200Kb";
			}
				
			$slug = $_POST['nama'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			$targetdir = "./../gallery";
			(file_exists($targetdir))?"dir has been created!!":mkdir("$targetdir", 0700);
			
			$n=1;
			$namabaru = "$slug.$ext";
			while(file_exists("$targetdir/$namabaru")){
				$namabaru = "$slug-".$n++.".$ext";			
			}
			
			$slugnya = substr("$namabaru", 0, strrpos("$namabaru", "."));  //hapus ext di jadikan slug	
			
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$errmsg= "<span style=\"float:right;\"><a href=\"javascript:void(0);\">close[X]</a></span><br><b>Sukses</b><br>";
				
				require_once("func/resimg.php");
				$upload = move_uploaded_file($_FILES['img']['tmp_name'], "$targetdir/$namabaru") or die("$errmsg");
				Resize("$targetdir/$namabaru");
				ResizeKecil("$targetdir/$namabaru");
				
				if($upload){
					$inp="INSERT INTO gallery (judul,img,ket,tgl,jam,slug) 
						  VALUES ('".$_POST['nama']."','$namabaru','".$_POST['descript']."','$tgl','$jam','$slugnya')";
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
	}

	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "create":
		
			$gx=NULL;
			$qlg=mysql_query("SELECT * FROM catgallery ORDER BY nama ASC",$konek);
			while($dg=mysql_fetch_array($qlg)){
				$gx.="<option value=\"$dg[0]\">$dg[1]</option>";
			}		
            
			require_once("$includev/$include.c.php");
			break;

		case "edit":
			$ided = mysql_real_escape_string($_GET['id']);
			$qed = mysql_query("SELECT * FROM page WHERE id='$ided' LIMIT 1",$konek);
			$dt = mysql_fetch_array($qed);
			
			$bt="edit";
			require_once("$includev/$include.c.php");
			break;	
			
		default:
			$ql=mysql_query("SELECT * FROM page ORDER by judul ASC",$konek);

			require_once("$includev/$include.r.php");
			break;	
			
	endswitch;
	
?>