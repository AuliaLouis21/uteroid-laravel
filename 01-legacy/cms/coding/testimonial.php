<?php
	//post
	if(!isset($_POST['submit'])){
		$_POST['submit'] = NULL;
	}
	
	switch ($_POST['submit']){
		case "Delete Testi":
			if(isset($_POST['del']) && $_POST['del']!=NULL ){
				foreach($_POST['del'] as $delitem){
					$ql=mysql_query("DELETE FROM `testi` WHERE `id`='$delitem'",$konek);
					if($ql){
						$msg[] = "$delitem deleted";
						$msgdel = implode('<br>',$msg);
					}
				}
			}else{
				$msgdel = "Nothing To Do";
			}
		break;
	}
	//load data and theme----------------------------------------------------------
	
	require_once("$includev/$include.head.php");
	if(!isset($_GET['sub'])){
		$_GET['sub'] = NULL;
	}
	
	switch ($_GET['sub']):
		case "approve":
			if(isset($_GET['id'])){
				$idnya = mysql_real_escape_string($_GET['id']);
				mysql_query("UPDATE testi SET approve='1' WHERE id='$idnya' LIMIT 1",$konek)or die("error");
			}
			
			$ql=mysql_query("SELECT * FROM testi ORDER BY id DESC",$konek);
			$i=0;

			require_once("$includev/$include.r.php");
			break;	
			
		default:
			$ql=mysql_query("SELECT * FROM testi ORDER BY id DESC",$konek);
			$i=0;
			
			require_once("$includev/$include.r.php");
			break;	
			
	endswitch;
?>