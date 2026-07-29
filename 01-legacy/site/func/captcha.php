<?php
ob_start();
	if(isset($_GET['img']) == "cap"){
		session_start();
		// Set the content-type
		header('Content-type: image/png');
		
		// Create the image
		$im = @imagecreate(150, 36)
				or die("Cannot Initialize new GD image stream");
		
		// Create some colors
		$white 	= imagecolorallocate($im, 255, 255, 255);
		$grey 	= imagecolorallocate($im, 200, 200, 200);
		$bg		= imagecolorallocate($im, rand(200,250), rand(220,250), rand(230,250));
		$color 	= imagecolorallocate($im, 200, rand(0,200), rand(0,150));
		imagefilledrectangle($im, 0, 0, 399, 29, $white);
		$fontsize = '10, 0, 10, 20';
		
		// The text to draw
		$string = md5(microtime(rand(0,1000)));
		$string = strtoupper(substr($string,rand(0,22),rand(5,6)));
		$x = rand(2,46);
		$y = rand(0,4);
		$z = rand(0,20);
		$_SESSION['kodenya'] = $string;
		
		// Replace path by your own font path
		$font 	= './MTCORSVA.TTF';
		$fontbg	= './MinionPro-SemiboldIt.otf';
		
		// Add some shadow to the text
		for($n = 0 ; $n <= 20 ;$n++){
			imagettftext($im,10,20,0,10*$n,$bg,$fontbg, md5(microtime(rand(0,1000)))."$string");
			imagettftext($im,10,20,2,10*$n,$grey,$fontbg, "teknoku.com-teknoku.com-teknoku.com");
		}	
		
		// Add the text
		imagettftext($im, rand(16,20), rand(-6,6), rand(1,70), rand(20,30), $color, $font, $_SESSION['kodenya']);
		
		// Using imagepng() results in clearer text compared with imagejpeg()
		imagepng($im);
		imagedestroy($im);
	}else{
		echo "<h1>404 error</h1>";
	}
ob_end_flush();
?>