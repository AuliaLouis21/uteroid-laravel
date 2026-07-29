<?php
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "publish":
			if($_POST['judul']==""){
				$error 		= TRUE;
				$err[] = "Judul Tidak Boleh Kosong"; 
			}		
			if($_POST['isinya']==""){
				$error 		= TRUE;
				$err[]	= "Isi Post Tidak Boleh Kosong";
			}

			$slug = $_POST['judul'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$inp="INSERT INTO posts (judul,
										 isi,
										 tgl,
										 jam,
										 slug,
										 cat) VALUES ('".$_POST['judul']."',
													  '".$_POST['isinya']."',
													  '$tgl',
													  '$jam',
													  '$slug',
													  '1')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode("<br/ >",$err);
				#$errmsg = explode("#", $errmsg);
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "post promo":
			if($_POST['judul']==""){
				$error 		= TRUE;
				$err[] = "Judul Tidak Boleh Kosong"; 
			}
			if($_POST['cat'] != "2"){
				$error 		= TRUE;
				$err[]		= "Silahkan Pilih Kategori Yang Telah Di Buat";
			}
	
			if($_POST['isinya']==""){
				$error 		= TRUE;
				$err[]		= "Isi Post Tidak Boleh Kosong";
			}

			$slug = $_POST['judul'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$inp="INSERT INTO posts (judul,
										 isi,
										 tgl,
										 jam,
										 slug,
										 cat) VALUES ('".$_POST['judul']."',
													  '".$_POST['isinya']."',
													  '$tgl',
													  '$jam',
													  '$slug',
													  '2')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode("<br/ >",$err);
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "edit":
			if($_POST['judul']==""){
				$error 		= TRUE;
				$err[] 		= "Judul Tidak Boleh Kosong"; 
			}		
			if($_POST['isinya']==""){
				$error 		= TRUE;
				$err[]		= "Isi Post Tidak Boleh Kosong";
			}

			$slug = $_POST['judul'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$ided = mysql_real_escape_string($_GET['id']);
				$inp="UPDATE posts SET judul ='".$_POST['judul']."', isi='".$_POST['isinya']."', slug='$slug' WHERE id='$ided' LIMIT 1";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
					header("location:./?cms=posts");
				}
			}else{
				$errmsg = implode("<br/ >",$err);
				#$errmsg = explode("#", $errmsg);
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "Add Category":
			if($_POST['nama']==""){
				$error		= TRUE;
				$err[]		= "Nama Kategori Tidak Boleh Kosong";
			}
			if($_POST['descript']==""){
				$error		= TRUE;
				$err[]		= "Nama Kategori Tidak Boleh Kosong";
			}
			
			$slug = $_POST['nama'];
			$slug = strtolower($slug);
			$slug = ereg_replace('([[:space:]]|-)+', '-', $slug);
			$slug = ereg_replace('([^a-z0-9-]|-+$|^-+)', '', $slug);
			$slug = str_replace("--", "-", $slug);
			
			if(!isset($error)){
				$inp="INSERT INTO category (nama,
										 	descript,
										 	slug) VALUES ('".$_POST['nama']."',
													      '".$_POST['descript']."',
														  '$slug')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode('<br>',$err);
			}			
		break;
		
		case "Delete Post":
			foreach($_POST['del'] as $delitem){
				$ql=mysql_query("DELETE FROM `posts` WHERE `id`='$delitem'",$konek)or die(mysql_error());
				if($ql){
					$msg[] = "$delitem deleted";
					$msgdel = implode('<br>',$msg);
				}
			}
		break;
		
		case "Delete Category":
			foreach($_POST['del'] as $delitem){
				$ql=mysql_query("DELETE FROM `category` WHERE `id`='$delitem'",$konek);
				if($ql){
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
		case "create":
			$ql = mysql_query("SELECT * FROM category ORDER BY nama ASC",$konek);
			$empty = (mysql_num_rows($ql) < "1")?"Maaf Data Masih Kosong":NULL;
			$bt="publish";
			require_once("$includev/$include.c.php");
			
			break;	
		case "edit":
			$ided = mysql_real_escape_string($_GET['id']);
			$qed = mysql_query("SELECT * FROM posts WHERE id='$ided' LIMIT 1",$konek);
			$dt = mysql_fetch_array($qed);
			
			$bt = "edit";
			require_once("$includev/$include.c.php");
			
			break;
		
		case "categories":
			$ql = mysql_query("SELECT * FROM category ORDER BY nama ASC",$konek);
			$empty = (mysql_num_rows($ql) < "1")?"Maaf Data Masih Kosong":NULL;
			require_once("./func/count.php");
			require_once("$includev/$include.cat.php");
			
			break;
			
		case "promo":
			$ql = mysql_query("SELECT * FROM posts WHERE cat='2' ORDER BY id DESC",$konek);
			$empty = (mysql_num_rows($ql) < "1")?"Maaf Data Masih Kosong":NULL;
			require_once("./func/count.php");
			require_once("$includev/$include.p.php");
			
			break;			
			
		default:
			$ql = mysql_query("SELECT a.*,b.nama FROM posts a INNER JOIN category b on a.cat=b.id WHERE cat='1' ORDER BY id DESC",$konek);
			$empty = (mysql_num_rows($ql) < "1")?"Maaf Data Masih Kosong":NULL;
			
			require_once("$includev/$include.r.php");
			
			break;
		
	endswitch;	
?>