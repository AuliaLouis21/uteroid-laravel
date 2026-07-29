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
				$picture=mysqli_query($konek,"SELECT a.*, b.nama,b.slug FROM pictgal a 
									 INNER JOIN albumpic b ON a.cat = b.id 
									 WHERE a.slug='$slug' LIMIT 1")or die(mysqli_error());
				$pi=mysqli_fetch_array($picture);
			}else{
				header("location:./picture.app");
			}
			
			define("_Title_",ucwords($pi['1'])." | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include.detil.php");
			require("$dirview/footer.php");

			break;
			
		case "cat":
		
			$p=0;		
			$slug = mysqli_real_escape_string($konek,$_GET['cat']);
			if(isset($slug)){
				$picture=mysqli_query($konek,"SELECT a.*, b.nama,b.slug FROM pictgal a 
									 INNER JOIN albumpic b ON a.cat = b.id 
									 WHERE b.slug='$slug'")or die(mysqli_error());
				
				$title=mysqli_query($konek,"SELECT nama FROM albumpic WHERE slug='$slug'")or die(mysqli_error());	
				$tt = mysqli_fetch_array($title);
				if(!$picture || mysqli_num_rows($picture) < 1){
					$nodata = "Data Masih Kosong";
				}
			}else{
				header("location:./picture.app");
			}
			
			define("_Title_",ucwords($tt['0'])." | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include_files[$include]");
			require("$dirview/footer.php");

			break;				
			
		default:
		
			$p=0;
			$picture=mysqli_query($konek,"select a.*, b.nama,b.slug FROM pictgal a INNER JOIN albumpic b ON a.cat = b.id");
			
			define("_Title_","Picture Gallery | Utero Advertising");
			
			require("$dirview/header.php");
			require("$dirview/$include/$include_files[$include]");
			require("$dirview/footer.php");
			break;
			
	endswitch;
?>