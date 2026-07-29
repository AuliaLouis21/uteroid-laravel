<?php
	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "mail":
			
			
			require_once("$includev/$include.set.php");
		break;			
			
		default:
			$ql 	= mysql_query("SELECT user FROM logmin");
			$qlx		= mysql_fetch_array($ql);
			
			#-----------------------------------------------------------
			
			if(isset($_POST['password']) && $_POST['password']=='save'){
				if($_POST['user']==""){
					$error[] 		= TRUE;
					$msg['user']	="Username Tidak Boleh Kosong"; 
				}
				else if(!preg_match("/^[a-zA-Z\d_@.-]/i",$_POST['user'])){
					$error[] 		= TRUE;
					$msg['user']	="Username gak valid";
				}
				else if(strlen(trim($_POST['user']))<6){
					$error[] 		= TRUE;
					$msg['user']	="Tidak Boleh Kurang Dari 6";
				}
				else if(strpos($_POST['user']," ")>0){
					$error[] 		= TRUE;
					$msg['user']	="Tidak Boleh ada spasi";
				}					
				$pl=mysql_query("SELECT pass FROM logmin WHERE pass='".$_POST['passlama']."'",$konek);
				if($_POST['passlama']==""){
					$error[]		= TRUE;
					$msg['passlama']= "Password Lama Kok Kosong?";					
				}
				elseif(mysql_num_rows($pl)!=1){
					$error[]		= TRUE;
					$msg['passlama']= "Password Lama Salah";		
				}
				
				if($_POST['pass']==""){
					$error[]		= TRUE;
					$msg['pass']	= "Password tidak boleh kosong";
				}
				elseif(strlen($_POST['pass'])<6){
					$error[]		= TRUE;
					$msg['pass']	= "bahaya euy.., gak boleh kurang dari 6";
				}
				
				if($_POST['pass2']==""){
					$error[]		= TRUE;
					$msg['pass2']	= "Password tidak boleh kosong";
				}
				elseif($_POST['pass2']!=$_POST['pass']){
					$error[]		= TRUE;
					$msg['pass2']	= "Password tidak sama dengan yg di atas";					
				}
				
				if(isset($error)){
					#NULL
				}else{
					$us = amankan($_POST['user']);
					$ps = amankan($_POST['pass']);
					
					$q=mysql_query("UPDATE logmin SET user='$us', pass='$ps'",$konek)or die(mysql_error());
					if($q){
						unset($_SESSION['root']);
						unset($_SESSION['un']);
						session_destroy();	
						
						echo "<center style=\"margin-top:20px;\">berhasil, tunggu 5 detik dan silahkan login kembali</center>";
						echo "<meta http-equiv=\"REFRESH\" content=\"3;url=$rootbase/cms\">";
						exit;
					}
				}
			}
			#-------------------------------------------------------------
			if(isset($_POST['loginfo']) && $_POST['loginfo']=='save'){
				if($_POST['nama']==""){
					$error[]		= TRUE;
					$msg['nama']	= "Nama Masih Kosong";		
				}
				
				if($_POST['mail']==""){
					$error[]		= TRUE;
					$msg['mail']	= "email Masih Kosong";						
				}
				elseif(!isValidEmail($_POST['mail'])){
					$error[]		= TRUE;
					$msg['mail']	= "Email gak valid";							
				}
				
				if(!isset($error)){
					$nama=amankan($_POST['nama']);
					$mail=amankan($_POST['mail']);
					$q=mysql_query("UPDATE logminfo SET nama='$nama',email='$mail'",$konek)or die(mysql_error());
					if($q){
						$m="Data Has Been Updated";
					}
				}
			}
			
			$ql=mysql_query("SELECT * FROM logminfo LIMIT 1",$konek);
			$dt=mysql_fetch_array($ql);
			require_once("$includev/$include.pass.php");
			break;
			
	endswitch;
?>