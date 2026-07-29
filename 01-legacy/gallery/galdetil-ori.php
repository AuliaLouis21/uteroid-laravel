<?php
ob_start();
require_once ("./../site/config.php");
if (isset($_GET['img'])){	
	$idnya = mysql_real_escape_string($_GET['img']);
	$rs = mysql_query("SELECT img FROM pictgal WHERE slug='".$idnya."'",$konek);
	$r = mysql_fetch_array($rs);
	
	$srcimg = $r['0'];

	$main_img 		= "./$srcimg";
	$watermark_img	= "./../site/images/logo-bunder.gif";
	$padding 		= 20;
	$opacity		= 100;
	
	$watermark 	= imagecreatefromgif($watermark_img); // create watermark
	$image 		= imagecreatefromjpeg($main_img); // create main graphic
	
	if(!$image || !$watermark) die("Error: main image or watermark could not be loaded!");
	
	
	// Get original image width and height
	$width = imagesx($image);
	$height = imagesy($image);
	
	// Set a new width, and calculate new height
	$new_width = 554;
	$new_height = $height * ($new_width/$width);
	
	//get original watermark image width & height
	$ww = imagesx($watermark);
	$wh = imagesy($watermark);	
	
	$watermark_size 	= getimagesize($watermark_img);
	$watermark_width 	= $watermark_size[0];  
	$watermark_height 	= $watermark_size[1];  
	
	$image_size 	= getimagesize($main_img);  
	$dest_x 		= $image_size[0] - $watermark_width - $padding;  
	$dest_y 		= $image_size[1] - $watermark_height - $padding;
	
	// copy watermark on main image
	imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $ww, $wh, $opacity);
	
	// Resample
	$image_resized = imagecreatetruecolor($new_width, $new_height);
	#imagecopyresampled(
	imagecopyresampled($image_resized, $image,0 , 0, 0, 0, $new_width, $new_height, $width, $height);
	
	// Display resized image
	header('Content-type: image/jpg');
		imagejpeg($image_resized);
		imagedestroy($image_resized); 
	die();
}else{
	echo "ngawur koen cuq!!!";
}
ob_end_flush();
?>