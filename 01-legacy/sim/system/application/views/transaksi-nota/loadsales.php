<table style='float:left;width:100%'>
	<tr>
		<td>
			<fieldset>
				<table>
					<tr>
						<td><?php echo label_for('Nama') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td><?php echo textbox_tag(array('id'=>'_nama','name'=>'_nama','style'=>'width:300px','onkeypress'=>'_nama_onKeyPress(event)')) ?></td>
						<td><?php echo button_tag(array('id'=>'button_cari_nama_sales2','id'=>'button_cari_nama_sales2','onclick'=>'button_cari_nama_sales2_onClick(event)','value'=>'Cari')) ?></td>
					</tr>
					<tr>
						<td><?php echo label_for('Alamat') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td colspan='2'><?php echo textbox_tag(array('id'=>'_alamat','name'=>'_alamat','style'=>'width:300px')) ?></td>
					</tr>
					<tr>
						<td><?php echo label_for('Telepon') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td colspan='2'><?php echo textbox_tag(array('id'=>'_telepon','name'=>'_telepon','style'=>'width:300px')) ?></td>
					</tr>
					<tr>
						<td><?php echo label_for('Kota') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td colspan='2'><?php echo textbox_tag(array('id'=>'_kota','name'=>'_kota','style'=>'width:300px')) ?></td>
					</tr>					
				</table>
			</fieldset>
		</td>		
	</tr>
	<tr>
		<td>
			<fieldset>
				<table>
					<tr>
						<td>
							<?php echo button_tag(array('id'=>'button_sales_simpan','name'=>'button_sales_simpan','value'=>'Simpan','onclick'=>'button_sales_simpan_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_sales_modifikasi','name'=>'button_sales_modifikasi','value'=>'Modifikasi','onclick'=>'button_sales_modifikasi_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_sales_hapus','name'=>'button_sales_hapus','value'=>'Hapus','onclick'=>'button_sales_hapus_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_sales_reset','name'=>'button_sales_reset','value'=>'Reset','onclick'=>'button_sales_reset_onClick(event)')) ?>
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<div id='table-container' style='height:200px;overflow:scroll;border:1px solid silver;'>
					<table border='1' style='border-collapse: collapse; border: 1px solid silver; width: 100%;'>
						<tr>
							<td class='table-header'><?php echo label_for('No') ?></td>
							<td class='table-header'><?php echo label_for('Nama') ?></td>
							<td class='table-header'><?php echo label_for('Alamat') ?></td>
							<td class='table-header'><?php echo label_for('Telepon') ?></td>
						</tr>
					</table>
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
	var _id_sales = null;
	function button_sales_simpan_onClick(event) {
		var nama = document.getElementById('_nama');
		var alamat = document.getElementById('_alamat');
		var telepon = document.getElementById('_telepon');
		var kota = document.getElementById('_kota');
		if(nama.value == "") {
			alert('nama masih kosong , harap di isi');
			nama.focus();
			return;
		}
		if(alamat.value == "") {
			alert('alamat masih kosong , harap di isi');
			alamat.focus();
			return;
		}
		if(telepon.value == "") {
			alert('telepon masih kosong , harap di isi');
			telepon.focus();
			return;
		}
		jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/' ?>",
			{"param":"add-sales","_nama":nama.value,"_alamat":alamat.value,"_telepon":telepon.value,"_kota":kota.value},
			function(data) {
				eval(data);
		});
	};
	function button_sales_modifikasi_onClick(event) {
		var nama = document.getElementById('_nama');
		var alamat = document.getElementById('_alamat');
		var telepon = document.getElementById('_telepon');
		var kota = document.getElementById('_kota');
		if(_id_sales == null) {
			alert('pilih salah satu sales yang akan dimodifikasi');
			nama.focus();
			return;
		}
		if(nama.value == "") {
			alert('nama masih kosong , harap di isi');
			nama.focus();
			return;
		}
		if(alamat.value == "") {
			alert('alamat masih kosong , harap di isi');
			alamat.focus();
			return;
		}		
		if(telepon.value == "") {
			alert('telepon masih kosong , harap di isi');
			telepon.focus();
			return;
		}	
		jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/' ?>",
			{"param":"edit-sales","id":_id_sales,"_nama":nama.value,"_alamat":alamat.value,"_telepon":telepon.value,"_kota":kota.value},
			function(data) {
				eval(data);
		});
	};
	function button_sales_hapus_onClick(event) {
		var nama = document.getElementById('_nama');
		var alamat = document.getElementById('_alamat');
		var telepon = document.getElementById('_telepon');
		var kota = document.getElementById('_kota');
		if(_id_sales == null) {
			alert('pilih salah satu sales yang akan dihapus');
			nama.focus();
			return;
		}
		jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/' ?>",
			{"param":"delete-sales","id":_id_sales},
			function(data) {
				eval(data);
		});
	};
	function button_sales_reset_onClick(event) {
		reset();
	};
	function button_cari_nama_sales2_onClick(event) {
		var nama = document.getElementById('_nama');
		if(nama.value == "") {
			alert('nama masih kosong , harap di isi');
			nama.focus();
			return;
		}
		if(nama.value != "") {
			jQuery.post("<?php echo base_url().index_page().'/transaksinota/carinamasales/' ?>",
				{"nama":nama.value},function(data){
					document.getElementById('table-container').innerHTML = data;
			});
		}
	};
	
	function row_onClick(event) {
		var target = event.target;
		if(target.tagName == "LABEL") {
			var id = jQuery(target).parent().parent().children("td:first").attr("id");
			jQuery.post("<?php echo base_url().index_page().'/transaksinota/isinamasales/' ?>",{"id":id},function(data){
				eval(data);
			});
		}
	};
	
	function _nama_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			button_cari_nama_sales2_onClick(event);
		}
	};
	
	function reset() {
		document.getElementById('_nama').value = "";
		document.getElementById('_alamat').value="";
		document.getElementById('_telepon').value = "";
		document.getElementById('_kota').value="";
		_id_sales = null;
	};
</script>