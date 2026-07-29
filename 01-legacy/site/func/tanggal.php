<?php
/*
function tanggal by rio adetya rizky
cara pakenya cukup begini

echo tanggal('2008-01-1');
*/


function tanggal($tgl){

	$someWords = trim($tgl);
	$wordChunks = explode("-", $someWords);
	
	$th = $wordChunks[0];
	$bln = $wordChunks[1];
	$tgl = $wordChunks[2];
	
	$bln = str_replace("01", "January", $bln);
	$bln = str_replace("02", "February", $bln);
	$bln = str_replace("03", "March", $bln);
	$bln = str_replace("04", "April", $bln);
	$bln = str_replace("05", "May", $bln);
	$bln = str_replace("06", "June", $bln);
	$bln = str_replace("07", "July", $bln);
	$bln = str_replace("08", "August", $bln);
	$bln = str_replace("09", "September", $bln);
	$bln = str_replace("10", "October", $bln);
	$bln = str_replace("11", "November", $bln);
	$bln = str_replace("12", "December", $bln);
	
	if($tgl=="01"){
		$t = "st";
	}
	elseif($tgl=="02"){
		$t = "nd";
	}
	elseif($tgl == "03"){
		$t = "rd";
	}
	else{
		$t = "th";
	}
	
	if($tgl < "10"){
		$tgl=preg_replace('/^0/i', '', $tgl);
	}
	
	$tanggal = "$bln $tgl$t, $th";
	
	return $tanggal;
}

?>
