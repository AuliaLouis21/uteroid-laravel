<?php
ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1); 

require_once ("./../site/config.php");
if (isset($_GET['img'])){
	#$id = mysql_real_escape_string($_GET['img']);
	#$rs = mysql_query("SELECT * FROM image WHERE produkid = $id",$konek);
	
	$slug = mysql_real_escape_string($_GET['img']);
	$rs = mysql_query("SELECT * FROM ads WHERE slug='$slug'",$konek);
	
	$r = mysql_fetch_array($rs);

	#$thumb_namafile = "r".substr("_$r[2]", 0, strrpos("_$r[2]", ".")) . ".jpg";
	$thumb_namafile = $r['4'];
	
	$imgfile = $thumb_namafile; // baca namafile
	$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
	$ext = strtolower($ext);	
	
	// Load image
	if($ext=="jpg"){
		$image 		= @imagecreatefromjpeg("./$thumb_namafile");
	}elseif($ext=="gif"){
		$image 		= @imagecreatefromgif("./$thumb_namafile");
	}elseif($ext=="png"){
		$image 		= @imagecreatefrompng("./$thumb_namafile");
	}
	
	if ($image == false ) { die ('Gak Onok Cuq...!!!s'); }
	
	// Get original image width and height
	$width = imagesx($image);
	$height = imagesy($image);
	
	// Set a new width, and calculate new height
	
	if ($width>200){
		$new_width = 200;
		$new_height = $height * ($new_width/$width);
		
		// Resample
		$image_resized = imagecreatetruecolor($new_width, $new_height);		
		
		#imagecopy($image_resized, $watermark, $width-$ww, $height-$wh, 0, 0, $ww, $wh);
		imagecopyresampled($image_resized, $image,0 , 0, 0,0 , $new_width, $new_height, $width, $height);
			
		// Display resized image
		if($ext=="jpg"){
			header('Content-type: image/jpg');
				imagejpeg($image_resized);
			die();
		}elseif($ext=="gif"){
			header('Content-type: image/gif');
				imagegif($image_resized);
			die();
		}elseif($ext=="png"){
			header('Content-type: image/png');
				imagepng($image_resized);
			die();
		}
	}else{
		if($ext=="jpg"){
			header('Content-type: image/jpg');
				imagejpeg($image);
			die();
		}elseif($ext=="gif"){
			header('Content-type: image/gif');
				imagegif($image);
			die();
		}elseif($ext=="png"){
			header('Content-type: image/png');
				imagepng($image);
			die();
		}
	}
	
}else{
	echo "ngawur koen cuq!!!";
}
ob_end_flush();
?>