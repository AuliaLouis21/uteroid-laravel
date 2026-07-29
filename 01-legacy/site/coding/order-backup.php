<?php
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	switch (mysql_real_escape_string($_POST['submit'])){
		case "ORDER NOW":
			$id=amankan($_GET['id']);
			$slug=amankan($_GET['slug']);
			
			if(!isset($id) && !isset($slug)){
				$error[] = TRUE;
				$err[]	= "error get";
			}
			else if(empty($_POST['qty'])){
				$error[] = TRUE;
				$err[]	= "<div id=\"bodytengah\" style=\"height:400px;\">error quantity masi kosong</div>";
			}
			
				if(isset($error)){
					define("_Title_","Utero Toren");
					require("$dirview/header.php");
					require("$dirview/$include/$include_files[$include]");
				}else{
					$q=mysql_query("SELECT * FROM produk WHERE id='$id' AND slug='$slug' LIMIT 1",$konek)or die(mysql_error());
					$d=mysql_fetch_array($q);
					
					$size 			=explode("#",$d['2']);
					$ukuranawal		=$size['0'];						//ukuran awal dari mysql
					$hargasatuanawal=$d['5'];
					$minorder		=$d['4'];
					
					$ukuran			=amankan($_POST['size']);			//inputan ukuran
					$hargasatuan	=amankan($_POST['hrgsize']);		//hasil perhitungan (hargasatuanawal / ukuranawal) * inputukuran);
					$quantity		=amankan($_POST['qty']);			//inputan jumlah order (quantity)
					$totalharga		=amankan($_POST['qtyhrgttl']);		//total harga keseluruhan
					
					if($quantity < $minorder){
						$hasil = $hargasatuanawal * $minorder;
						$hasil = ceil("$hasil");
					}
					else if($quantity == $minorder){
						$hasil = $hargasatuanawal * $minorder;
						$hasil = ceil("$hasil");
					}						
					else if($quantity > $minorder){
						$hasil = $hargasatuanawal * $quantity;
						$hasil = ceil("$hasil");
					}				
					
					#session_start();
					$_SESSION['produkid']	= $d['0'];
					$_SESSION['produk']		= $d['1'];
					$_SESSION['hargasatuan']= $d['5'];
					$_SESSION['minorder']	= $d['4'];
					$_SESSION['jumorder']	= $quantity;
					$_SESSION['hasil'] 		= $hasil;
					
					
					
					define("_Title_","Utero Toren");
		
					require("$dirview/header.php");
					require("$dirview/$include/$include_files[$include]");
					require("$dirview/footer.php");						
				}		
		break;
		case "finish":
					#session_start();
					if($_POST['nama']==""){
						$error[]		= TRUE;
						$msg['nama']	= "nama masih kosong";
					}
					elseif(strlen($_POST['nama'])>50){
						$error[]		= TRUE;
						$msg['nama']	= "nama kepanjangan, g'mungkin bgt :p";
					}
					if($_POST['mail']==""){
						$error[]		= TRUE;
						$msg['mail']	= "email masih kosng";						
					}
					elseif(!isValidEmail($_POST['mail'])){
						$error[]		= TRUE;
						$msg['mail']	= "email tidak valid";
					}
					if($_POST['notelp']==""){
						$error[]		= TRUE;
						$msg['notelp']	= "No Telp masih kosong";						
					}
					elseif(!is_numeric($_POST['notelp'])){
						$error[]		= TRUE;
						$msg['notelp']	= "No Telp tidak benar";						
					}
					elseif(strlen($_POST['notelp'])>13){
						$error[]		= TRUE;
						$msg['notelp']	= "No Telp Kepanjangan";						
					}
					elseif(strlen($_POST['notelp'])<9){
						$error[]		= TRUE;
						$msg['notelp']	= "No Telp Terlalu sedikit";						
					}					
					if($_POST['alamat']==""){
						$error[]		= TRUE;
						$msg['alamat']	= "alamat masih kosong";
					}
					elseif(preg_match('/<\/?[a-z][a-z0-9]*[^<>]*>/i',$_POST['alamat'])){
						$error[]		= TRUE;
						$msg['alamat']	= "alamat tidak benar";
					}
					if($_POST['kota']==""){
						$error[]		= TRUE;
						$msg['kota']	= "kota masih kosong";
					}
					if($_POST['kodepos']==""){
						$error[]		= TRUE;
						$msg['kodepos']	= "kodepos masih kosong";
					}
					elseif(!is_numeric($_POST['kodepos'])){
						$error[]		= TRUE;
						$msg['kodepos']	= "kodepos tidak benar";
					}
					elseif(strlen($_POST['kodepos'])>6){
						$error[]		= TRUE;
						$msg['kodepos']	= "kodepos kepanjangan";
					}
					elseif(strlen($_POST['kodepos'])<5){
						$error[]		= TRUE;
						$msg['kodepos']	= "kodepos terlalu pendek";
					}									
					if(preg_match('/<\/?[a-z][a-z0-9]*[^<>]*>/i',$_POST['pesan'])){
						$error[]		= TRUE;
						$msg['pesan']	= "isi pesan gak bener";						
					}
					
					if(isset($error)){
						define("_Title_","Utero Toren");
			
						require("$dirview/header.php");
						require("$dirview/$include/$include_files[$include]");
						require("$dirview/footer.php");
					}else{
						$nama		=amankan($_POST['nama']);
						$email		=amankan($_POST['mail']);
						$notelp		=amankan($_POST['notelp']);
						$alamat		=amankan($_POST['alamat']);
						$kota		=amankan($_POST['kota']);
						$kodepos	=amankan($_POST['kodepos']);
						$pesan		=amankan($_POST['pesan']);
						if($pesan==""){ $pesan = "-"; }						
						
						$tgl = date("Y-m-d");
						$jam = date("h:i:s");						
						
						$qx 	= "INSERT INTO orderuser (nama, email, notelp, alamat, kodepos, pesan, tgl, jam) 
									VALUES ('$nama', '$email', '$notelp', '$alamat#$kota', '$kodepos', '$pesan', '$tgl', '$jam')";			
						$quo	= mysql_query($qx, $konek)or die(mysql_error());
						
						if($quo){
							$li		= mysql_insert_id($konek);
							
							$produkid		= trim($_SESSION['produkid']);
							$produk			= trim($_SESSION['produk']);
							$hargasatuan		= trim($_SESSION['hargasatuan']);
							$minorder		= trim($_SESSION['minorder']);
							$jumorder		= trim($_SESSION['jumorder']);
							$hasil			= trim($_SESSION['hasil']);
							
							$inso 	= "INSERT INTO ordernya (produk,harga,minorder,jumlahorder,total,userid,produkid) 
										VALUES ('$produk', '$hargasatuan', '$minorder', '$jumorder', '$hasil', '$li','$produkid')";			  
							$qin 	= mysql_query($inso, $konek)or die(mysql_error());
							
							if($qin){
								date_default_timezone_set('Asia/Jakarta');
								require_once($func.'/class.phpmailer.php');
								
								$mail             = new PHPMailer();
								
								$mail->IsSMTP(); // telling the class to use SMTP
								$mail->Host       = "smtp.gmail.com"; // SMTP server
								$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
																		   // 1 = errors and messages
																		   // 2 = messages only
								$mail->SMTPAuth   = true;                  // enable SMTP authentication
								$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
								$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
								$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
								$mail->Username   = "orderutero@gmail.com";  // GMAIL username
								$mail->Password   = "dadikwahyuku12";            // GMAIL password
								
								$mail->SetFrom('admin@uterogroup.com', 'Marketing Utero');						
								$mail->AddReplyTo("marketingutero@gmail.com","Marketing Utero");						
								$mail->Subject    = "Order Detil uterogroup.com";						
								$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
								
								$user  ="";
								$user .="<h1 style=\"border-bottom:1px solid #f60; margin-bottom:10px;\">Halo, ".$_POST['nama']."</h1>";
								$user .="Terimakasih telah melakukan order,<br> berikut adalah order detil anda :<br>";
										
								$user .="
										<table width=\"400\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\" style=\"font-family:arial; font-size:12px\">
										  <tr>
											<td width=\"137\" style=\"background-color:#CCC;\">Nama Produk</td>
											<td width=\"252\" style=\"background-color:#efefef;\">".$_SESSION['produk']."</td>
										  </tr>
										  <tr>
											 <td style=\"background-color:#CCC;\">Harga Satuan</td>
											<td style=\"background-color:#efefef;\">".$_SESSION['hargasatuan']."</td>
										  </tr>
										  <tr>
											 <td style=\"background-color:#CCC;\">Minimum Order</td>
											<td style=\"background-color:#efefef;\">".$_SESSION['minorder']."</td>
										  </tr>
										  <tr>
											 <td style=\"background-color:#CCC;\">Jumlah Order</td>
											<td style=\"background-color:#efefef;\">".$_SESSION['jumorder']."</td>
										  </tr>
										  <tr>
											 <td style=\"background-color:#CCC;\">Total Harga</td>
											<td style=\"background-color:#efefef; color:#F00\">".$_SESSION['hasil']."</td>
										  </tr>
										</table>";
										
								$user .="
										<p>Untuk konfirmasi selanjutnya silahkan hubungi marketing utero</p>
										<p>GRAHA UTERO INDONESIA<br />
										(Rumah Kreatif OXYZ)<br />
										  Jalan Bantaran 1 No 25<br />
										Tulusrejo, Kec. Lowokwaru<br />
										Malang<br />
										  Jawa Timur - Indonesia - 65141</p>
										<p>Telp.	0341 - 408408, 0341 - 417417<br />
                    WA.	+62 81 999 900 900<br />
                    untuk konfirmasi pembayaran:<br />
										  No. Rek. BCA. 8161125199 a.n. CV WAHYU UTERO SINARJAYA KREASINDO<br />
                      NB: barang akan kami selesaikan dan kami kirim apabila pembayaran telah dilakukan 100%</p>						
								";
								
								$mail->MsgHTML($user);
								
								$address = $_POST['mail'];
								$mail->AddAddress($address, $_POST['nama']);
								$mail->AddAddress('marketingutero@gmail.com', 'Website Utero');
								
								if(!$mail->Send()) {
								  echo "Mailer Error: " . $mail->ErrorInfo;
								} else {
								  echo "Message sent!";
								  session_destroy();
								}							
							}
						}

						define("_Title_","Utero Toren");
						
						require("$dirview/header.php");
						require("$dirview/$include/$include.f.php");
						require("$dirview/footer.php");
					}
		break;
		default:
			if(isset($_GET['cok'])){
				echo "sip";
			}else{
				header("location:$root");
			}
		break;
	}
?>
