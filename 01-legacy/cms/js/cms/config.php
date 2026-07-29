<?php
	$serper = "localhost";  # variable server sql
	$user_db = "uteroadv_uteroad";	# variable user mysql
	$passdb	= "!@#$%^";	# variable password mysql
	$dbname = "uteroadv_uteroadv";	# variable nama database

$konek = mysql_connect($serper,$user_db,$passdb);
mysql_select_db($dbname,$konek)or die("<center>Error : Sql Gak Konek Cuq</center>");


$rootbase = "http://".$_SERVER['SERVER_NAME'];
$root = "http://".$_SERVER['SERVER_NAME']."/cms";

$dirviews = "$root/views";
$cok = "asu";
?>