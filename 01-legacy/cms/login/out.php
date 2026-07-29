<?php
	session_start();
	
	require_once("./../config.php");
	if(isset($_SESSION['root'])){
		unset($_SESSION['root']);
		session_destroy();
		header("Location: $rootbase");
		exit;
	}
?>