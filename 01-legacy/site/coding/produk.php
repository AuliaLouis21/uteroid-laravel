<?php
	if(isset($_GET['i']) && isset($_GET['s'])){
		$id = mysqli_real_escape_string($konek,$_GET['i']);
		$sslug = mysqli_real_escape_string($konek,$_GET['s']);
		
		/*$query="SELECT a.*, b.slug FROM produk AS a INNER JOIN jnsproduk AS b
			 WHERE a.jns = '$id' AND b.slug ='$jslug'"; */
		$query="SELECT a.id,a.nama,a.minorder,a.hargasatuan,a.slug FROM produk a
				INNER JOIN catproduk b ON a.cat=b.id
				WHERE a.cat = '$id' AND b.slug = '$sslug' ORDER BY a.id";
		
		$perhalaman = $produkperpage;
		$halaman 	= isset($_GET["hal"]) ? $_GET["hal"] : "0";
		$awal 		= $halaman * $perhalaman;			

		$qlr = mysqli_query($konek,"$query")or die(mysqli_error());
		$qu_jml = mysqli_query($konek,"select count(*) from produk")or die(mysqli_error());
		
		$empty = (!$qlr || mysqli_num_rows($qlr) < "1")?"Data Masih Kosong":NULL;
		
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
		
		require("$dirview/header.php");
		require("$dirview/$include/$include.cat.php");
		require("$dirview/footer.php");	
		
	}
	#----------------------------
	else if(isset($_GET['p'])){
		$slug = mysqli_real_escape_string($konek,$_GET['p']);
		$ql = mysqli_query($konek,"SELECT * FROM produk WHERE slug = '$slug' LIMIT 1");
		if (mysqli_num_rows($ql)==0){
			echo "error";
			echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"5; url=$root\">";
			die;
		}
		$dt = mysqli_fetch_array($ql);
		
		$size = explode("#",$dt['2']);
		$satuan = ($size[1] == "m" || $size[1] == "M")?"m&sup2;":"Cm&sup2;";
		$ukuran = ($size[0] == "-" || $size[0] == "")?"-":$size[0]."&nbsp;".$satuan;
		$hidden = ($size[0] == "-" || $size[0] == "")?"style=\"display:none;\"":NULL;
		
		#-----------------------
		
		$namae = ucwords($dt[1]);
		define("_Title_","Detail Produk : $namae | Utero Advertising");
		
		require("$dirview/header.php");
		require("$dirview/$include/$include.detil.php");
		require("$dirview/footer.php");
	}else{
		$query = mysqli_query($konek,"SELECT * FROM catproduk ORDER BY nama") or die(mysqli_error());
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
			
			$empty = (!$qlr || mysqli_num_rows($qlr) < "1")?"Data Masih Kosong":NULL;
		}		
		
		#$qlr 		= mysqli_query($konek,"SELECT * FROM produk ORDER BY id DESC limit $awal, $perhalaman")or die(mysqli_error());
		#$qu_jml 	= mysqli_query($konek,"select count(*) from produk")or die(mysqli_error());
		
		$r = mysqli_fetch_row($qu_jml);
		$total_halaman = ceil($r[0] / $perhalaman);	
		
		$halaman_str = "";
		if($halaman > 1){
			$hal = $halaman;
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
		
		require("$dirview/header.php");
		require("$dirview/$include/$include_files[$include]");
		require("$dirview/footer.php");		
	}
?>