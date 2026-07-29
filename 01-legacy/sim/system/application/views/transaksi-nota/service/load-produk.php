<?php foreach($query_produk->result_array() as $row) { ?>
	<option value="<?php echo $row['no_id'] ?>"><?php echo $row['nama'] ?></option>
<?php } ?>