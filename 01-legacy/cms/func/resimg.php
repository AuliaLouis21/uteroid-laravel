<?php
function Resize($filename)

{

     $bnf = basename($filename);
     $parts = explode(".", $bnf);
     $ext = $parts[count($parts)-1];
     $ext = strtolower($ext);

     $thumb_name = array_slice($parts, 0, count($parts) - 1);
     $thumb_dir = substr($filename, 0, strrpos($filename, "/") + 1);
	 $thumb_dir = $thumb_dir."img/";

     $namabaru = "r_".join(".", $thumb_name) . ".jpg";

     switch($ext)
     {
             case "jpg";

                     $src_img = ImageCreateFromJpeg("$filename");

                     break;

             case "gif":
                     $src_img = ImageCreateFromGif("$filename");
                     break;

             case "png":
                     $src_img = ImageCreateFromPng("$filename");
                     break;

     }

     /* get it's height and width */
     $imgSx = imagesx($src_img);
     $imgSy = imagesy($src_img);

     if($imgSy != 0)
     {
		$ratio = $imgSx / $imgSy;
		$resize = 512;

		if($ratio > 1)
		{
			$new_imgSx = $resize;
			$new_imgSy = $resize/$ratio;
		}else{
			$new_imgSx = (float) $resize * $ratio;
			$new_imgSy = $resize;
		}
		$dst_img = imagecreatetruecolor($new_imgSx, $new_imgSy);
		ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $new_imgSx, $new_imgSy, $imgSx, $imgSy);
		imageJpeg($dst_img, "$thumb_dir$namabaru");
     }
}

#--------------------------------------------------------------------------------------------------

function ResizeKecil($filename)
{
     $bnf = basename($filename);
     $parts = explode(".", $bnf);
     $ext = $parts[count($parts)-1];
     $ext = strtolower($ext);

     $thumb_name = array_slice($parts, 0, count($parts) - 1);
     $thumb_dir = substr($filename, 0, strrpos($filename, "/") + 1);
	 $thumb_dir = $thumb_dir."thumb/";

     $namabaru = "rk_".join(".", $thumb_name) . ".jpg";
	 
     switch($ext)
     {
             case "jpg";
                     $src_img = ImageCreateFromJpeg("$filename");
                     break;

             case "gif":
                     $src_img = ImageCreateFromGif("$filename");
                     break;

             case "png":
                     $src_img = ImageCreateFromPng("$filename");
                     break;
     }

     /* get it's height and width */

	$imgSx = imagesx($src_img);
	$imgSy = imagesy($src_img);

	if($imgSy != 0)
	{
		$ratio = $imgSx / $imgSy;
		$resize = 150;
	
		if($ratio > 1)
		{
			$new_imgSx = $resize;
			$new_imgSy = $resize/$ratio;
		}else{
			$new_imgSx = (float) $resize * $ratio;
			$new_imgSy = $resize;
		}

		$dst_img = imagecreatetruecolor($new_imgSx, $new_imgSy);
		ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $new_imgSx, $new_imgSy, $imgSx, $imgSy);
		imageJpeg($dst_img, "$thumb_dir$namabaru");
	}

}
?>