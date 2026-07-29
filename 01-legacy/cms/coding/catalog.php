<?php	
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "Add Data":
			if($_POST['cat']==""){
				$error[]		= TRUE;
				$err[]		= "Anda Belum Pilih Kategori";
			}
			
			if($_POST['jenis']==""){
				$error[]		= TRUE;
				$err[]		= "Jenis Produk Masih Kosong";
			}					
			
			if($_POST['nama']==""){
				$error[]		= TRUE;
				$err[]		= "Nama Produk Tidak Boleh Kosong";
			}
			
			if($_POST['size']==""){
				$error[]		= TRUE;
				$err[]		= "Ukuran Lebar Tidak Boleh Kosong";
			}
			
			if($_POST['satuan']==""){
				$error		= TRUE;
				$err[]		= "Satuan Tidak Boleh Kosong";
			}
			
			if($_POST['tebal']==""){
				$error[]		= TRUE;
				$err[]		= "Tebal Tidak Boleh Kosong";
			}
			
			if($_POST['harga']==""){
				$error[]		= TRUE;
				$err[]		= "Harga Tidak Boleh Kosong";
			}
			
			if($_POST['descript']==""){
				$error[]		= FALSE;
				$err[]		= "Harga Tidak Boleh Kosong";
			}			
			
			if($_POST['minorder']==""){
				$error[]		= TRUE;
				$err[]		= "Minimum Order Tidak Boleh Kosong";
			}

			if(!isset($_POST['promo'])){
				$error[]		= TRUE;
				$err[]		= "Anda belum menandai barang promo";
			}			
			
			$imgfile = $_FILES['img']['name']; // baca namafile
			$ext = substr($imgfile, strrpos($imgfile, ".") + 1); // ambil ekstension
			$ext = strtolower($ext);
			
			if($_FILES['img']['name'] == ""){
				$error[]		= TRUE;
				$err[]		= "Gambar Tidak Boleh Kosong";
			}
			else if($ext !== "jpg"){
				$error[]		= TRUE;
				$err[]		= "Format Gambar Harus JPEG";
			}
			else if($_FILES['img']['size'] > "1048576" ){
				$error[]		= TRUE;
				$err[]		= "Gambar Tidak Boleh Melebihi 100Kb";
			}
				
			$slug = $_POST['nama'];
			$slug = bikinslug($slug);
			
			$targetdir = "./../imgupload";
			(file_exists($targetdir))?"sipp!!":mkdir("$targetdir", 0700);
			
			#$namabaru = "$imgfile"; // namafile ditambah id_, mencegah replace file
			#$namabaru = strtolower($namabaru);
			#$namabaru = ereg_replace('([[:space:]]|-)+', '_', $namabaru);
			
			$n=1;
			$namabaru = "$slug.$ext";
			while(file_exists("$targetdir/$namabaru")){
				#$error		= TRUE;
				#$err[]		= "File Gambar Sudah Ada";
				$namabaru = "$slug-".$n++.".$ext";
			}
			
			$tgl = date("Y-m-d");
			$jam = date("h:i:s");
			
			if(!isset($error)){
				require_once("func/resimg.php");
				$upload = move_uploaded_file($_FILES['img']['tmp_name'], "$targetdir/$namabaru");
				Resize("$targetdir/$namabaru");
				ResizeKecil("$targetdir/$namabaru");
				
				if($upload){
					$inp="INSERT INTO produk (nama,
											  ukuran,
											  ketebalan,
											  minorder,
											  hargasatuan,
											  descript,
											  tgl,
											  jam,
											  slug,
											  cat,
											  jns,
											  promo) VALUES ('".$_POST['nama']."',
														   '".$_POST['size']."#".$_POST['satuan']."',
														   '".$_POST['tebal']."',
														   '".$_POST['minorder']."',
														   '".$_POST['harga']."',
														   '".$_POST['descript']."',
														   '$tgl',
														   '$jam',
														   '$slug',
														   '".$_POST['cat']."',
														   '".$_POST['jenis']."',
														   '".$_POST['promo']."')";	
					
					$qldata = mysql_query($inp,$konek)or die(mysql_error());
					$produkid = mysql_insert_id();
					
					$qlimg = mysql_query("INSERT INTO image (img,
															 produkid) VALUES 
																			  ('$namabaru',
																			   '$produkid' )",$konek)or die(mysql_error());
					if($qldata && $qlimg){
						$errmsg= "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a>
									</span><br><b>New Product has been Added</b><br>";
						echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"1; url=./?cms=catalog\">";
					}
					
				}
				
			}else{
				$errmsg = implode('<br>',$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
			
		break;
		
		//--------------------------------------------------------------------
		
		case "Add Category":
			if($_POST['nama']==""){
				$error[]		= TRUE;
				$err[]		= "Nama Kategori Tidak Boleh Kosong";
			}
			if($_POST['descript']==""){
				$error[]		= TRUE;
				$err[]		= "Keterangan Tidak Boleh Kosong";
			}
			
			$slug = $_POST['nama'];
			$slug = strtolower($slug);
			$slug = bikinslug($slug);
			
			if(!isset($error)){
				$inp="INSERT INTO catproduk (nama,
										 	descript,
										 	slug) VALUES ('".$_POST['nama']."',
													      '".$_POST['descript']."',
														  '$slug')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode('<br>',$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
		break;
		
		//jenis-----------------------------------------------------------------
		
		case "Add Product Type":
			if($_POST['jenis']==""){
				$error[]		= TRUE;
				$err[]		= "Jenis Produk Tidak Boleh Kosong";
			}
			if($_POST['descript']==""){
				$error[]		= TRUE;
				$err[]		= "Keterangan Tidak Boleh Kosong";
			}
			
			$slug = $_POST['jenis'];
			$slug = bikinslug($slug);
			
			$sw = mysql_real_escape_string($_GET['show']);
			$ql = mysql_query("SELECT id FROM catproduk WHERE slug='$sw' LIMIT 1",$konek);
			$idx = mysql_fetch_array($ql);
			
			if(!isset($error)){
				$inp="INSERT INTO jnsproduk (jenis,
										 	descript,
										 	slug,
											cat) VALUES ('".$_POST['jenis']."',
													      '".$_POST['descript']."',
														  '$slug',
														  '$idx[0]')";
				$q = mysql_query($inp,$konek)or die(mysql_error());
				if($q){
					$sukses = TRUE;
				}
			}else{
				$errmsg = implode('<br>',$err);
				$errmsg = "<span style=\"float:right;\"><a href=\"javascript:Void(null)\">close[X]</a></span><br><b>ERROR :</b><br>$errmsg";
			}
		break;		
		
		//--------------------------------------------------------------------
		
		case "Delete Category":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$ql=mysql_query("DELETE FROM `catproduk` WHERE `id`='$delitem' LIMIT 1",$konek);
					$ql=mysql_query("DELETE FROM `jnsproduk` WHERE `cat`='$delitem'",$konek);
					if($ql){
						$msg[] = "$delitem deleted";
						$msgdel = implode('<br>',$msg);
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}
		break;
		
		//--------------------------------------------------------------------
		
		case "Delete Product Type":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$ql=mysql_query("DELETE FROM `jnsproduk` WHERE `id`='$delitem' LIMIT 1",$konek);
					if($ql){
						$msg[] = "$delitem deleted";
						$msgdel = implode('<br>',$msg);
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}
		break;
		
		case "Delete":
			if(isset($_POST['del']) && $_POST['del'] != NULL ){
				foreach($_POST['del'] as $delitem){
					$dl=mysql_query("SELECT * FROM image WHERE produkid='$delitem'",$konek);
					$img=mysql_fetch_array($dl);
					$ql=mysql_query("DELETE FROM `produk` WHERE `id`='$delitem' LIMIT 1",$konek);
					if($ql){
						$msg[] = "$delitem deleted";
						$msgdel = implode('<br>',$msg);
						unlink("./../imgupload/".$img['1'])or die("delete error");
						unlink("./../imgupload/thumb/rk_".$img['1'])or die("delete error");
						unlink("./../imgupload/img/r_".$img['1'])or die("delete error");
						mysql_query("DELETE FROM image WHERE produkid='$delitem'",$konek)or die(mysql_error());
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}			
		break;		
	}
	

	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	$sub= isset($_GET['sub']) ?$_GET['sub'] :"" ;	
	
	switch ($sub):
		case "create":
			$ql =  "SELECT a . * , b.nama, b.slug, c.jenis, c.slug FROM produk a
					INNER JOIN catproduk b ON a.cat = b.id
					INNER JOIN jnsproduk c ON b.id = c.cat
					WHERE a.cat=b.id AND a.jns=c.id
					ORDER BY id DESC";
					
			$qu =	mysql_query($ql,$konek);
			
			$query = "SELECT * FROM catproduk ORDER BY nama";
			$rs = mysql_query($query) or die(mysql_error());
			$cbstr = "";
			while ($r = mysql_fetch_array($rs))
			{
				$cbstr 	.= "<option value='$r[id]'>$r[nama]</option>";
			}
			
			require_once("$includev/$include.c.php");
			break;
		
		case "cat":
			$ql = mysql_query("SELECT * FROM catproduk ORDER BY nama ASC",$konek);
			if(mysql_num_rows($ql) < "1"){
				$empty = "Maaf Data Masih Kosong";
			}
			
			require_once("./func/count.php");
			require_once("$includev/$include.cat.php");
			break;
			
		case "jenis":
			$sl = mysql_real_escape_string($_GET['show']);
			$ql = mysql_query("SELECT id,nama FROM catproduk WHERE slug='$sl' limit 1",$konek);
			$cat=mysql_fetch_array($ql);
			
			$id = mysql_real_escape_string($cat['0']);
			$qlj = mysql_query("SELECT * FROM jnsproduk WHERE cat='$id'",$konek);			
			
			$empty = (mysql_num_rows($qlj) < "1")?"Maaf Data Masih Kosong":NULL;
			
			require_once("$includev/$include.jns.php");
			break;			
			
		default:
			$perhalaman = 10;
			$halaman 	= isset($_GET["hal"]) ? $_GET["hal"] : "0";
			$awal 		= $halaman * $perhalaman;			
	
			$query="SELECT a.* , b.nama, b.slug FROM produk a
					INNER JOIN catproduk b ON a.cat = b.id
					ORDER BY a.id DESC
					limit $awal, $perhalaman";

			$qlr = mysql_query("$query",$konek)or die(mysql_error());
			$qu_jml = mysql_query("select count(a.id) FROM produk a
								INNER JOIN catproduk b ON a.cat = b.id",$konek)or die(mysql_error());
			
			$empty = (mysql_num_rows($qlr) < "1")?"Data Masih Kosong":NULL;
			
			$r = mysql_fetch_row($qu_jml);
			$total_halaman = ceil($r[0] / $perhalaman);	
			
			$halaman_str = "";
			if($halaman > 1){
				$hal = 0;
				$halaman_str .= "<a href='$root/?cms=catalog&hal=$hal' title='Halaman pertama'><b>&lt;&lt;</b></a> ";
			}
			if($halaman > 0){
				$hal = $halaman - 1;
				$halaman_str .= "<a href='$root/?cms=catalog&hal=$hal' title='Halaman sebelumnya'>&lt;</a> ";
			}
			
			for ($i = 0; $i < $total_halaman; $i++){
				$hal = $i + 1;
				if ($i == $halaman){    
					$halaman_str .= "$hal";
				}else{
					$halaman_str .= "<a href='$root/?cms=catalog&hal=$i' title='Halaman $hal'>$hal</a> ";
				}
			}		
			
			if ($halaman < ($total_halaman - 1)){
				$hal = $halaman + 1;
				$halaman_str .= "<a href='$root/?cms=catalog&hal=$hal' title='Halaman berikutnya'>&gt;</a> ";
			}
			
			if ($halaman < ($total_halaman - 2)){
				$hal = $total_halaman - 1;
				$halaman_str .= "<a href='$root/?cms=catalog&hal=$hal' title='Halaman terakhir'><b>&gt;&gt;</b></a> ";
			}
			
			$halaman_str = "<div class='paging'>$halaman_str</div>";		
		
			/*$ql =  "SELECT a.* , b.nama, b.slug, c.jenis, c.slug, d.img FROM produk a
					INNER JOIN catproduk b ON a.cat = b.id
					INNER JOIN jnsproduk c ON b.id = c.cat
					INNER JOIN image d ON a.id = d.produkid
					ORDER BY a.id DESC";
					
			$qu =	mysql_query($ql,$konek)or die("error : ".mysql_error());
			*/
			
			require_once("$includev/$include.r.php");
			break;	
	endswitch;
?>