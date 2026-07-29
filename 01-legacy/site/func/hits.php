<?php
$filename= "./site/func/nomer.txt" ;
$fd = fopen ($filename , "r") or die ("error") ;
$fstring = fread ($fd , 2048) ;
// echo "$fstring" ; 
// fclose($fd) ;
$fcounted = $fstring + 1 ;
echo "$fstring" ;
$fc = fopen ($filename , "w") or die ("error") ;
// $fcounted = $fstring + 1 ;
//$fout = fwrite ($fd , $fcounted ) ;
fwrite ($fc , $fcounted) ;
//fclose($fc) ;
?>
