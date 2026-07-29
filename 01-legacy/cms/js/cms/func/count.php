<?php
	function selpost($idcat,$con){
		$ql = mysql_query("SELECT count( cat ) FROM posts WHERE cat = '$idcat'",$con);
		$data=mysql_fetch_array($ql);
		return $data['0'];
	}
	
	function countjns($idcat,$con){		
		$ql = mysql_query("SELECT count(cat) FROM jnsproduk WHERE cat='$idcat'",$con);
		$data=mysql_fetch_array($ql);
		return $data['0'];		
	}	
?>