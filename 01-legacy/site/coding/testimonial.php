<?php
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	switch($_POST['submit']){
		case "SEND TESTIMONIAL":
			session_start();
			if($_POST['nama']==""){
				$error			= TRUE;
				$msg['nama']	= "Nama Tidak Boleh Kosong!";
			}
			
			if($_POST['mail']==""){
				$error			= TRUE;
				$msg['mail']	= "Email Tidak Boleh Kosong";
			}
			else if(!preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $_POST['mail'])){
				$error			= TRUE;
				$msg['mail']	= "Tulis Email Dengan Benar";
			}
			
			if($_POST['testinya'] == ""){
				$error				= TRUE;
				$msg['testinya']	= "Anda Belum Menuliskan Testimonial";				
			}
			
			if($_POST['code'] == ""){
				$error				= TRUE;
				$msg['code'] 		= "Anda Belum Memasukkan Code";
			}
			else if($_POST['code'] != $_SESSION['kodenya']){
				$error				= TRUE;
				$msg['code'] 		= "Code Tidak Valid";
			}
			
			if(!isset($error)){
				
				$testinya = mysqli_real_escape_string($konek,$_POST['testinya']);
				$nama = mysqli_real_escape_string($konek,$_POST['nama']);
				$mail = $_POST['mail'];
				$prsh = $_POST['prsh'];
				
				$tgl = date("Y-m-d");
				$jam = date("h:i:s");
				$inp="INSERT INTO testi (testi,
										 pengirim,
										 mail,
										 prsh,
										 tgl,
										 jam,
										 ip) VALUES ('$testinya',
										 			 '$nama',
													 '$mail',
													 '$prsh',
													 '$tgl',
													 '$jam',
													 '".$_SERVER['REMOTE_ADDR']."')";
				$q = mysqli_query($konek,$inp)or die(mysqli_error());
				if($q){
					$sukses = "Terimakasih Telah Mengirimkan Testimonial";
				}
			}			
		break;
	}

	$ql=mysqli_query($konek,"SELECT * FROM testi WHERE approve='1' order by tgl desc");
	$i = 0;
	
	define("_Title_","Testimonial | Utero Advertising");
	
	require("$dirview/header.php");
	require("$dirview/$include/$include_files[$include]");
	require("$dirview/footer.php");	

?>