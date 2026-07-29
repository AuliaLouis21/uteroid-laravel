<?php
ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1); 

require("./config.php");

session_start();
if (!$_SESSION['root']){
	header("Location: $rootbase/adm/login.jsp");
	die;
}

// include file
$include_files = array(
	'pertamax' 		=> 'pertamax.php',
	'posts'			=> 'posts.php',
	'pages'			=> 'pages.php',
	'catalog'		=> 'catalog.php',
	'gallery' 		=> 'gallery.php',
	'testimonial'	=> 'testimonial.php'
);

$include = isset($_GET['cms']) ? $_GET['cms'] : '';
if (!$include) {
	$include = 'pertamax';
}

$includev = "./views/$include";

require_once("./func/menu.php");
require_once("./views/header.php");
if (isset($include_files[$include])) {
	require_once("./coding/$include_files[$include]");
}else{
	header("location:$root");
}
require_once("./views/footer.php");

ob_end_flush();
?>