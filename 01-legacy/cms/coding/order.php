<?php
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "Delete":
			foreach($_POST['del'] as $delitem){
				$ql=mysql_query("DELETE a.* , b.*
								FROM orderuser AS a
								INNER JOIN ordernya AS b ON b.userid = a.id
								WHERE a.id = '$delitem'",$konek)or die(mysql_error());
				if($ql){
					$msg[] = "$delitem deleted";
					$msgdel = implode('<br>',$msg);
				}
			}
		break;
	}

	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "detil":
			
			$idnya = amankan($_GET['id']);
			
			$qq="SELECT a.*, b.*
				 FROM orderuser AS a
				 INNER JOIN ordernya AS b 
				 ON b.userid = a.id
				 WHERE a.id = '$idnya'";
				 
			$ql=mysql_query($qq,$konek);
			$dt=mysql_fetch_array($ql);		
			
			$t = explode('#',$dt['4']);
			
			require_once("$includev/$include.d.php");
			break;
			
		default:
			$i=0;
			$qq="SELECT a.id,a.nama, a.alamat, b.produk, b.total, b.produkid, a.tgl, a.jam
				 FROM orderuser AS a
				 INNER JOIN ordernya AS b ON b.userid = a.id
				 ORDER BY a.id DESC";
				 
			$ql=mysql_query($qq,$konek);

			require_once("$includev/$include.v.php");
			break;	
			
	endswitch;
?>