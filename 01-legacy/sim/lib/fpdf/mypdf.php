<?php 
	require_once('fpdf.php');
	class PDF extends FPDF {
		function PDF($orientation , $unit = "mm", $format = "A4") {
			parent:__contruct($orientation,$unit,$format);
		}
		function Header() {
			
		}
	}
?>