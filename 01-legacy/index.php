<?php
ob_start();

error_reporting(E_ALL);
ini_set("display_errors", 1); 

require("./site/config.php");

// include file
$include_files = array(
	'index' => 'index.php',
	'pertamax' => 'pertamax.php',
	'signup' => 'signup.php',
	'detil' => 'detil.php',
	'pages' => 'pages.php',
	'news' => 'news.php',
	'produk' => 'produk.php',
	'testimonial' => 'testimonial.php',
	'contact' => 'contact.php',
	'gallery' => 'gallery.php',
	'picture' => 'picture.php',
	'video' => 'video.php',	
	'order' => 'order.php',
	'ads' => 'ads.php',
	'audio' => 'audio.php',	
	'download' => 'download.php'	
);

$include = isset($_GET['t']) ? $_GET['t'] : '';
if (!$include) {
	$include = 'pertamax';
}

session_start();
#var_dump($_SESSION);

require_once("./site/func/func.php");
require_once("./site/func/menu.php");
require_once("./site/func/tanggal.php");

if (isset($include_files[$include])) {
	require_once("./site/coding/$include_files[$include]");
}else{
	header("location:$root/");
}

ob_end_flush();
?>