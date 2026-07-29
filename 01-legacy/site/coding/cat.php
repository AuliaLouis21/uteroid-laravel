<?php
	if(isset($_GET['i']) && isset($_GET['j'])){
		$id = mysqli_real_escape_string($konek,$_GET['i']);
		$jslug = mysqli_real_escape_string($konek,$_GET['j']);
		
		$qx="SELECT a . * , b.slug FROM produk a INNER JOIN jnsproduk b
			 WHERE a.jns = '$id' AND b.slug ='$jslug'"; 
		
		$query = mysqli_query($konek,"$qx") or die(mysqli_error());
		
		$cbstr = "";
		while ($r = mysqli_fetch_array($query))
		{
			$cbstr 	.= "<option value='$r[id]'>$r[nama]</option>";
		}

		$perhalaman = $produkperpage;
		$halaman 	= isset($_GET["hal"]) ? $_GET["hal"] : "0";
		$awal 		= $halaman * $perhalaman;			
		
		if($_SERVER['REQUEST_METHOD'] =="POST"){
				$srcfrm = mysqli_real_escape_string($konek,$_POST['src']);
				$srcfrm = trim($srcfrm);
				
				$qlr=mysqli_query($konek,"SELECT * FROM produk WHERE nama LIKE '%$srcfrm%' ORDER BY id DESC limit $awal, $perhalaman");
				$qu_jml	= mysqli_query($konek,"select count(*) from produk WHERE nama LIKE '%$srcfrm%'")or die(mysqli_error());
				
				$empty = (mysqli_num_rows($qlr) < "1")?"Tidak menemukan Yg Anda cari":NULL;
		}else{
			$qlr = mysqli_query($konek,"SELECT * FROM produk ORDER BY id DESC limit $awal, $perhalaman")or die(mysqli_error());
			$qu_jml = mysqli_query($konek,"select count(*) from produk")or die(mysqli_error());
			
			$empty = (!$qlr || mysqli_num_rows($qlr) < 1)?"Data Masih Kosong":NULL;
		}		
		
		#$qlr 		= mysqli_query($konek,"SELECT * FROM produk ORDER BY id DESC limit $awal, $perhalaman")or die(mysqli_error());
		#$qu_jml 	= mysqli_query($konek,"select count(*) from produk")or die(mysqli_error());
		
		$r = mysqli_fetch_row($qu_jml);
		$total_halaman = ceil($r[0] / $perhalaman);	
		
		$halaman_str = "";
		if($halaman > 1){
			$halaman_str .= "<a href='$root/?t=produk&hal=$hal' title='Halaman pertama'><b>&lt;&lt;</b></a> ";
		}
		if($halaman > 0){
			$hal = $halaman - 1;
			$halaman_str .= "<a href='$root/?t=produk&hal=$hal' title='Halaman sebelumnya'>&lt;</a> ";
		}
		
		for ($i = 0; $i < $total_halaman; $i++){
			$hal = $i + 1;
			if ($i == $halaman){    
				$halaman_str .= "$hal";
			}else{
				$halaman_str .= "<a href='$root/?t=produk&hal=$i' title='Halaman $hal'>$hal</a> ";
			}
		}		
		
		if ($halaman < ($total_halaman - 1)){
			$hal = $halaman + 1;
			$halaman_str .= "<a href='$root/?t=produk&hal=$hal' title='Halaman berikutnya'>&gt;</a> ";
		}
		
		if ($halaman < ($total_halaman - 2)){
			$hal = $total_halaman - 1;
			$halaman_str .= "<a href='$root/?t=produk&hal=$hal' title='Halaman terakhir'><b>&gt;&gt;</b></a> ";
		}
		
		$halaman_str = "<div class='paging'>$halaman_str</div>";		
		
		$i = 0;		
		
		define("_Title_","Produk | Utero Advertising");
		
		require("./views/header.php");
		require("./views/$include/$include.jns.php");
		require("./views/footer.php");
		
	}else{
		$id	= isset($_GET['n'])?mysqli_real_escape_string($konek,$_GET['n']):NULL;
		$slug = isset($_GET['p'])?mysqli_real_escape_string($konek,$_GET['p']):NULL;
		
		$query = "SELECT a.nama , b.* FROM catproduk a
					INNER JOIN jnsproduk b
					WHERE b.cat = '$id'
					AND a.slug = '$slug' ORDER BY b.id";
		
		$qlr = mysqli_query($konek,$query);
		$i = 0;
		
		$empty=(!$qlr || mysqli_num_rows($qlr) < '1')?"":NULL;
		
		$ql = mysqli_query($konek,$query);	
		$dt = mysqli_fetch_array($ql);
	
		#------------------------
		$title = ucwords($dt[0]);	
		define("_Title_","$title | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include.php");
		require("$dirview/footer.php");
	}
?>