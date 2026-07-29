<?php

$serper = "localhost";  	# variable server sql
$user_db = "uteroid_user";	# variable user mysql
$passdb	= "Wosl9xue*Nnl";	# variable password mysql
$dbname = "uteroid_simpusat";	# variable nama database 

$conn = mysqli_connect($serper,$user_db,$passdb);
$db = mysqli_select_db($conn,$dbname);
$query = mysqli_query("select * from sim_produk");
while($row = mysqli_fetch_array($query)) {
	if(trim($row['gambar'] != '') and trim($row['gambar'] != "\"")) {
		$gambar = get_image($row['gambar']);
		$no_id = $row['no_id'];
		update($gambar,$no_id);
	}
	
}
echo "berhasil";


function get_image($gambar) {
	$gambar = explode("\\",$gambar);
	if(count($gambar) != 0) {
		return $gambar[count($gambar)-1];
	}
}

function update($gambar,$no_id) {
	$query = mysqli_query("update sim_produk set gambar = '$gambar' where no_id = '$no_id'");
}
?>