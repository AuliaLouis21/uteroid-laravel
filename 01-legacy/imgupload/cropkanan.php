<?php
require_once ("./../site/config.php");
if (isset($_GET['img'])){
	$idnya = mysql_real_escape_string($_GET['img']);
	$rs = mysql_query("SELECT * FROM image WHERE produkid='".$idnya."'",$konek);
	$r = mysql_fetch_array($rs);
	
	#$namafile = $r['0']."_$r[1]";
	#$thumb_namafile = "r".substr("_$r[2]", 0, strrpos("_$r[2]", ".")) . ".jpg";
	$thumb_namafile = "r_".$r['1'];			
			
//Your Image
$imgSrc = "./img/$thumb_namafile"; 
 
//getting the image dimensions
list($width, $height) = getimagesize($imgSrc); 
 
//saving the image into memory (for manipulation with GD Library)
$myImage = imagecreatefromjpeg($imgSrc); 

///--------------------------------------------------------
//setting the crop size
//--------------------------------------------------------
if($width > $height) $biggestSide = $width; 
else $biggestSide = $height; 
 
//The crop size will be half that of the largest side 
$cropPercent = .5; 
$cropWidth   = $biggestSide*$cropPercent; 
$cropHeight  = $biggestSide*$cropPercent; 
 
 
//getting the top left coordinate
$c1 = array("x"=>($width-$cropWidth)/2, "y"=>($height-$cropHeight)/2);

//--------------------------------------------------------
// Creating the thumbnail
//--------------------------------------------------------
$thumbSize1 = 110;
$thumbSize2 = 200;
$thumb = imagecreatetruecolor($thumbSize2, $thumbSize1); 
imagecopyresampled($thumb, $myImage, 0, 0, $c1['x'], $c1['y'], $thumbSize2, $thumbSize2, $cropWidth, $cropHeight); 

//--------------------------------------------------------
// Creating the lines
//--------------------------------------------------------
/*
$lineWidth = 0;
$margin    = 0;  
$green    = imagecolorallocate($thumb, 193, 252, 182);
 
for($i=0; $i<2; $i++){
	//left line
	imagefilledrectangle($thumb, $margin, $margin, $margin+$lineWidth, $thumbSize-$margin, $green); 
	//right line
	imagefilledrectangle($thumb, $thumbSize-$margin-$lineWidth, $margin, $thumbSize-$margin, $thumbSize-$margin, $green);
	//topLine
	imagefilledrectangle($thumb, $margin, $margin, $thumbSize-$margin-$lineWidth, $margin+$lineWidth, $green); 
	//bottom line 
	imagefilledrectangle($thumb, $margin, $thumbSize-$margin-$lineWidth, $thumbSize-$margin-$lineWidth, $thumbSize-$margin,$green);
	$margin+=4; 
} 
*/
//final output  
	header('Content-type: image/jpg');
	imagepng($thumb);
	imagedestroy($thumb);

}
?>