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
	if ($image === false ) { die ('Gak Onok Cuq...!!!'); }
	
	// Get original image width and height
	$width = imagesx($image);
	$height = imagesy($image);
	
	// Set a new width, and calculate new height
	$new_width = 400;
	$new_height = $height * ($new_width/$width);
	
	// Resample
	$image_resized = imagecreatetruecolor($new_width, $new_height);		
	
	#imagecopy($image_resized, $watermark, $width-$ww, $height-$wh, 0, 0, $ww, $wh);
	imagecopyresampled($image_resized, $image,0 , 0, 0,0 , $new_width, $new_height, $width, $height);
	
	$red 	= imagecolorallocate($image_resized, 255,32,32);
	$black 	= imagecolorallocate($image_resized, 0,0,0);
	$white 	= imagecolorallocate($image_resized, 255,255,255);
	$fontbg	= './arialbd.ttf';
	
	imagettftext($image_resized,10,90,ceil(($new_width/$width)+389),ceil(($new_height/2)+70),$white,$fontbg, "www.uterogroup.com");
	imagettftext($image_resized,10,90,ceil(($new_width/$width)+391),ceil(($new_height/2)+70),$black,$fontbg, "www.uterogroup.com");
	imagettftext($image_resized,10,90,ceil(($new_width/$width)+390),ceil(($new_height/2)+70),$red,$fontbg, "www.uterogroup.com");
		
	// Display resized image
	header('Content-type: image/jpg');
		imagejpeg($image_resized);
	die();
}else{
	echo "ngawur koen cuq!!!";
}
ob_end_flush();
?>