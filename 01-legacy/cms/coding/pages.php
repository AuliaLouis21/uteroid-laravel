<?php
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	switch($_POST['submit']){
		case "publish":
			if($_POST['judul']==""){
				$error 		= TRUE;
				$err[] = "Label Menu Tidak Boleh Kosong"; 
			}
						
			if($_POST['isinya']==""){
				$error 		= TRUE;
				$err[]	= "Isi Halaman Tidak Boleh Kosong";
			}

			$slug = $_POST['judul'];
			$slug = bikinslug($slug);
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$inp="INSERT INTO page (judul,
										 isi,
										 tgl,
										 jam,
										 slug) VALUES ('".$_POST['judul']."',
													   '".$_POST['isinya']."',
													   '$tgl',
													   '$jam',
													   '$slug')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = trim("$err");
				$errmsg = implode('<br>',$err);
				#$errmsg = explode("#", $errmsg);
			}
		break;
		
		//----
		
		case "edit":
			if($_POST['judul']==""){
				$error 		= TRUE;
				$err[] = "Label Menu Tidak Boleh Kosong"; 
			}
						
			if($_POST['isinya']==""){
				$error 		= TRUE;
				$err[]	= "Isi Halaman Tidak Boleh Kosong";
			}

			$slug = $_POST['judul'];
			$slug = bikinslug($slug);
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");

			if(!isset($error)){
				$ided = mysql_real_escape_string($_GET['id']);
				$inp="UPDATE page SET judul ='".$_POST['judul']."', isi='".$_POST['isinya']."', slug='$slug' WHERE id='$ided' LIMIT 1";				
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
					header("location:./?cms=pages");
				}
			}else{
				$errmsg = trim("$err");
				$errmsg = implode('<br>',$err);
				#$errmsg = explode("#", $errmsg);
			}
		break;
		
		case "Delete Pages":
			foreach($_POST['del'] as $delitem){
				$ql=mysql_query("DELETE FROM `page` WHERE `id`='$delitem'",$konek)or die(mysql_error());
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
			
			$bt="publish";
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