<table style='float:left;width:100%'>
	<tr>
		<td>
			<fieldset>
				<table>
					<tr>
						<td><?php echo label_for('Nama') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td><?php echo textbox_tag(array('id'=>'_nama','name'=>'_nama','style'=>'width:300px','onkeypress'=>'_nama_onKeyPress(event)')) ?></td>
						<td><?php echo button_tag(array('id'=>'button_cari_nama_klien','id'=>'button_cari_nama_klien','onclick'=>'button_cari_nama_klien_onClick(event)','value'=>'Cari')) ?></td>
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
						<td><?php echo label_for('Perusahaan') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td colspan='2'><?php echo textbox_tag(array('id'=>'_perusahaan','name'=>'_perusahaan','style'=>'width:300px')) ?></td>
					</tr>
					<tr>
						<td><?php echo label_for('Email') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td colspan='2'><?php echo textbox_tag(array('id'=>'_email','name'=>'_email','style'=>'width:300px')) ?></td>
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
							<?php echo button_tag(array('id'=>'button_klien_simpan','name'=>'button_klien_simpan','value'=>'Simpan','onclick'=>'button_klien_simpan_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_klien_modifikasi','name'=>'button_klien_modifikasi','value'=>'Modifikasi','onclick'=>'button_klien_modifikasi_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_klien_hapus','name'=>'button_klien_hapus','value'=>'Hapus','onclick'=>'button_klien_hapus_onClick(event)')) ?>
						</td>
						<td>
							<?php echo button_tag(array('id'=>'button_klien_reset','name'=>'button_klien_reset','value'=>'Reset','onclick'=>'button_klien_reset_onClick(event)')) ?>
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
<script type='text/javascript'>
	var _id_klien = null;
	function button_klien_simpan_onClick(event) {
		var _nama = document.getElementById('_nama');
		var _alamat = document.getElementById('_alamat');
		var _telepon = document.getElementById('_telepon');
		var _perusahaan = document.getElementById('_perusahaan');
		var _email = document.getElementById('_email');
		
		if(_nama.value == "") {
			alert('nama masih kosong , harap di isi');
			_nama.focus();
			return;
		}
		if(_alamat.value == "") {
			alert("alamat masih kosong , harap di isi");
			_alamat.focus();
			return;
		}
		if(_telepon.value == "") {
			alert("telepon masih kosong , harap di isi");
			_telepon.focus();
			return;
		}
		
		jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/'?>",
			{"param":"add","_nama":_nama.value,"_alamat":_alamat.value,"_telepon":_telepon.value,"_perusahaan":_perusahaan.value,"_email":_email.value},
			function(data){
				eval(data);
			});		
	};
	
	function button_klien_modifikasi_onClick(event) {
		if(_id_klien != null) {
			if(_id_klien != "") {
			
				var _nama = document.getElementById('_nama');
				var _alamat = document.getElementById('_alamat');
				var _telepon = document.getElementById('_telepon');
				var _perusahaan = document.getElementById('_perusahaan');
				var _email = document.getElementById('_email');
				
				if(_nama.value == "") {
					alert('nama masih kosong , harap di isi');
					_nama.focus();
					return;
				}
				if(_alamat.value == "") {
					alert("alamat masih kosong , harap di isi");
					_alamat.focus();
					return;
				}
				if(_telepon.value == "") {
					alert("telepon masih kosong , harap di isi");
					_telepon.focus();
					return;
				}
				jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/' ?>",
					{"param":"edit","id":_id_klien,"_nama":_nama.value,"_alamat":_alamat.value,"_telepon":_telepon.value,"_perusahaan":_perusahaan.value,"_email":_email.value},
					function(data){
						eval(data);
				});
			}
		}
	};
	
	function button_klien_hapus_onClick(event) {
		if(_id_klien == null) {
			alert('pilih di table dari salah satu nama yang akan dihapus');
			document.getElementById('_nama').focus();
			return;
		}
		if(_id_klien != null) {
			jQuery.post("<?php echo base_url().index_page().'/transaksinota/save/'?>",{"param":"delete","id":_id_klien},function(data){
				eval(data);
			});
		}
	};
	
	function button_klien_reset_onClick(event) {
		reset();
	};
	
	function reset() {
		document.getElementById('_nama').value = "";
		document.getElementById('_alamat').value = "";
		document.getElementById('_telepon').value = "";
		document.getElementById('_perusahaan').value = "";
		document.getElementById('_email').value = "";
		_id_klien = null;
	};
	
	function row_onClick(event) {
		var target = event.target;
		if(target.tagName == "LABEL") {
			var id = jQuery(target).parent().parent().children("td:first").attr("id");
			jQuery.post("<?php echo base_url().index_page().'/transaksinota/isinamaklien' ?>",{"id":id},function(data){
				eval(data);
			});
		}
	};
	function button_cari_nama_klien_onClick(event) {
		var nama = document.getElementById('_nama');
		if(nama.value == "") {
			alert('nama masih kosong , harap di isi');
			nama.focus();
			return;
		}
		jQuery.post("<?php echo base_url().index_page().'/transaksinota/carinamaklien/' ?>",{"nama":nama.value},function(data){
			document.getElementById('table-container').innerHTML = data;
		});
	};
	
	function _nama_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			button_cari_nama_klien_onClick(event);
		}
	};
</script>