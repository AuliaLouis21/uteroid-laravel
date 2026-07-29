<?php
	if(isset($_GET['f'])){
		$slug = amankan($_GET['f']);
		$ex = amankan($_GET['ex']);
		$ql = mysqli_query($konek,"SELECT * FROM dataupload WHERE slug='$slug' AND ext='$ex'");
		$dt = mysqli_fetch_array($ql);
		
		if(mysqli_num_rows($ql)==1){
				$filenya = $dt['2'].".".$dt['3'];
				$ex = header("Content-type: application/octet-stream");
				$ex = header("Content-Description: File Transfer");
				$ex = header("Content-Disposition: attachment; filename=$filenya");
				$ex = header("Content-Transfer-Encoding: binary");
				$ex = header("Content-Length:".filesize("./xdata/".$filenya));
				$ex = readfile("./xdata/".$filenya)or die("error");
				
				if($ex){
					$myr = mysqli_query($konek,"update dataupload set download=download+1 where slug='$slug'");
				}
		}else{
			header("location:$root");
		}
	}else{
		echo "cok cok";
	}
?>