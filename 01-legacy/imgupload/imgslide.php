<?php
ob_start();
require_once ("../site/config.php");
if (isset($_GET['img'])){
	#$id = mysqli_real_escape_string($konek,$_GET['img']);
	#$rs = mysqli_query($konek,"SELECT * FROM image WHERE produkid = $id");
	
	$idnya = mysqli_real_escape_string($konek,$_GET['img']);
	$rs = mysqli_query($konek,"SELECT * FROM image WHERE produkid='".$idnya."'");
	
	$r = mysqli_fetch_array($rs);

	#$thumb_namafile = "r".substr("_$r[2]", 0, strrpos("_$r[2]", ".")) . ".jpg";
	$thumb_namafile = "r_".$r[1];


	// Load image
	$image 		= @imagecreatefromjpeg("./img/$thumb_namafile");
	$watermark 	= @imagecreatefromjpeg("./../site/images/watermark.jpg");
	if ($image === false && $watermark === false) { die ('Gak Onok Cuq...!!!'); }
	
	// Get original image width and height
	$width = imagesx($image);
	$height = imagesy($image);
	
	// Set a new width, and calculate new height
	$new_width = 398;
	$new_height = $height * ($new_width/$width);
	
	//get original watermark image width & height
	$ww = imagesx($watermark);
	$wh = imagesy($watermark);
	
	// Resample
	$image_resized = imagecreatetruecolor($new_width, $new_height);
	#imagecopy($image_resized, $watermark, $width-$ww, $height-$wh, 0, 0, $ww, $wh);
	imagecopyresampled($image_resized, $image,0 , 0, 0,0 , $new_width, $new_height, $width, $height);
	
	// Display resized image
	header('Content-type: image/jpg');
		imagejpeg($image_resized);
	die();
}else{
	echo "ngawur koen cuq!!!";
}
ob_end_flush();
?>