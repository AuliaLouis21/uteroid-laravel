<?php
	ob_start();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$error = false;
		
		if($_POST['uname'] == ""){
			$error[]= TRUE;
		}
		else if (!preg_match("/^[A-Za-z0-9]+$/", $_POST['uname'])){
			$error[] = TRUE;
		}
		else if (strlen($_POST['uname']) > 15){
			$error[] = TRUE;
		}
		else if (strlen($_POST['uname']) < 5){
			$error[] = TRUE;
		}

		if($_POST['pwd'] == ""){
			$error[] = TRUE;
		}
		else if (!preg_match("/^[A-Za-z0-9]+$/", $_POST['pwd'])){
			$error[] = TRUE;
		}
		else if (strlen($_POST['pwd']) > 15){
			$error[] = TRUE;
		}
		else if (strlen($_POST['pwd']) < 5){
			$error[] = TRUE;
		}
		
		if($error){
			$failed = "Login Failed";
		}else{
			$unm = mysql_real_escape_string($_POST['uname']);
			$psw = mysql_real_escape_string($_POST['pwd']);

			$q = mysql_query("SELECT user,pass FROM logmin WHERE user='$unm' AND pass='$psw'", $konek);
			
			if (mysql_num_rows($q) == '1'){
				session_start();
				$ses = md5(date('dmYhis').$unm);
				$_SESSION['root'] 	= "$ses";
				$_SESSION['un']		= "$unm";
				header("location:$root");
			}else{
				$failed = "Login Failed";
			}
		}
	}
	
	ob_end_flush();
?>