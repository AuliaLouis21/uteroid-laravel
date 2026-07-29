<?php
//file coding

	require_once("$func/youtube.class.php");
	$yvid = new YouTube();

	//load data and theme----------------------------------------------------------
	
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "detil":

			$slug = mysqli_real_escape_string($konek,$_GET['src']);
			if(isset($slug)){
				$picture=mysqli_query($konek,"SELECT * FROM vidgal WHERE slug='$slug'")or die(mysqli_error());
				$pi=mysqli_fetch_array($picture);
			}else{
				header("location:./video.app");
			}
			
			define("_Title_",ucwords($pi['1'])." | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include.detil.php");
			require("$dirview/footer.php");

			break;			
			
		default:
		
			$p=0;
			$video=mysqli_query($konek,"SELECT * FROM vidgal")or die(mysqli_error());
			
			define("_Title_","Video Gallery | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include_files[$include]");
			require("$dirview/footer.php");
			break;
			
	endswitch;
?>