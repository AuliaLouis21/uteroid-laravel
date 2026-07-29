<?php
	require_once("./../config.php");
	
	$kode = mysql_real_escape_string($_GET['kode']);
	
	if($kode){
		echo "<select name='jenis'>";
			$rs = mysql_query ("SELECT * FROM jnsproduk WHERE cat='$kode' ");
			$empty = (mysql_num_rows($rs) < "1")?"No Data":NULL;
			
			if($empty){
				echo "<option value=\"".NULL."\">$empty</option>";
			}
			
			while ($r = mysql_fetch_array($rs)){
				echo "<option value='$r[id]'>$r[jenis]</option>";
			}
		echo "</select>";		
	}
?>