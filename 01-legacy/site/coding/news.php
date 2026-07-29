<?php
	if(isset($_GET['v'])){
		$slug = mysqli_real_escape_string($konek,$_GET['v']);
		$ql = mysqli_query($konek,"SELECT * FROM posts WHERE slug='$slug' LIMIT 1");
		$dt=mysqli_fetch_array($ql);	
		
		$q=mysqli_query($konek,"SELECT * FROM posts LIMIT 5");	
		
		$title = $dt['1'];
		define("_Title_","News : $title | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include.detil.php");
		require("$dirview/footer.php");		
	}else{
		$i = 0;
			
		$perhalaman = $newsperpage;
		$halaman 	= isset($_GET["hal"]) ? $_GET["hal"] : "0";
		$awal 		= $halaman * $perhalaman;						
		
		$qlr = mysqli_query($konek,"SELECT * FROM posts WHERE cat='1' ORDER BY id DESC limit $awal, $perhalaman")or die(mysqli_error());
		$qu_jml = mysqli_query($konek,"select count(*) from posts WHERE cat='1'")or die(mysqli_error());
		$empty = (!$qlr || mysqli_num_rows($qlr) < 1)?"Data Masih Kosong":NULL;

		$r = mysqli_fetch_row($qu_jml);
		$total_halaman = ceil($r[0] / $perhalaman);	
		
		$halaman_str = "";
		if($halaman > 1){
			$hal = $halaman;
			$halaman_str .= "<a href='$root/?t=news&hal=$hal' title='Halaman pertama'><b>&lt;&lt;</b></a> ";
		}
		if($halaman > 0){
			$hal = $halaman - 1;
			$halaman_str .= "<a href='$root/?t=news&hal=$hal' title='Halaman sebelumnya'>&lt;</a> ";
		}
		
		for ($i = 0; $i < $total_halaman; $i++){
			$hal = $i + 1;
			if ($i == $halaman){    
				$halaman_str .= "$hal";
			}else{
				$halaman_str .= "<a href='$root/?t=news&hal=$i' title='Halaman $hal'>$hal</a> ";
			}
		}		
		
		if ($halaman < ($total_halaman - 1)){
			$hal = $halaman + 1;
			$halaman_str .= "<a href='$root/?t=news&hal=$hal' title='Halaman berikutnya'>&gt;</a> ";
		}
		
		if ($halaman < ($total_halaman - 2)){
			$hal = $total_halaman - 1;
			$halaman_str .= "<a href='$root/?t=produk&hal=$hal' title='Halaman terakhir'><b>&gt;&gt;</b></a> ";
		}
		
		$halaman_str = "<div class='paging'>$halaman_str</div>";
		
		define("_Title_","News | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include_files[$include]");
		require("$dirview/footer.php");		
	}
?>