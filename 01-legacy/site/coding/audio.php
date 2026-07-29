<?php
//file coding


	//load data and theme----------------------------------------------------------
	
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "detil":

			$slug = mysqli_real_escape_string($konek,$_GET['src']);
			if(isset($slug)){
				$picture=mysqli_query($konek,"SELECT * FROM audgal WHERE slug='$slug'")or die(mysqli_error());
				$pi=mysqli_fetch_array($picture);
			}else{
				header("location:./audio.app");
			}
			
			define("_Title_",ucwords($pi['1'])." | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include.detil.php");
			require("$dirview/footer.php");

			break;			
			
		default:
		
			$p=0;
			$video=mysqli_query($konek,"SELECT * FROM audgal")or die(mysqli_error());
			
			define("_Title_","Audio Gallery | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include_files[$include]");
			require("$dirview/footer.php");
			break;
			
	endswitch;
?>