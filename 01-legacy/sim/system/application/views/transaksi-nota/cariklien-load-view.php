<table style='float:left;width:100%'>
	<tr>
		<td>
			<fieldset>
				<table>
					<tr>
						<td><?php echo label_for('Nama') ?></td>
						<td><?php echo label_for(':') ?></td>
						<td><?php echo textbox_tag(array('id'=>$nama,'name'=>$nama,'style'=>'width:300px','onkeypress'=>$nama.'_onKeyPress(event)')) ?></td>
						<td><?php echo button_tag(array('id'=>$button_cari,'id'=>$button_cari,'onclick'=>$button_cari.'_onClick(event)','value'=>'Cari')) ?></td>
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
	function <?php echo $nama ?>_onKeyPress(event) {
		var target = event.target;
		var keycode = event.keyCode || event.charCode;
		if(keycode == 13) {
			if(target.value != "") {
				jQuery.ajax({
					url : "<?php echo base_url().index_page().'/transaksinota/cariklien/' ?>",
					type : "POST",				
					data : {"param":"cari-nama","nama":target.value,"id":target.id},
					success : function(data) {
						document.getElementById('table-container').innerHTML = data;
					}
				});
			}
		}
	};
	function <?php echo $button_cari ?>_onClick(event) {
		var nama = document.getElementById("<?php echo $nama ?>");
		if(nama.value == "") {
			alert('nama masih kosong , harap di isi');
			nama.focus();
			return;
		}
		jQuery.ajax({
			url : "<?php echo base_url().index_page().'/transaksinota/cariklien/' ?>",
			type : "POST",				
			data : {"param":"cari-nama","nama":nama.value,"id":nama.id},
			success : function(data) {
				document.getElementById('table-container').innerHTML = data;
			}
		});
	};
	
	function row_onClick(event) {
		var target = event.target;
		if(target.tagName == "LABEL") {
			var id = jQuery(target).parent().parent().children("td:first").attr("id");
			jQuery.post("<?php echo base_url().index_page().'/transaksinota/cariklien/' ?>",
				{"param":"isi-form","id":id},
				function(data){
					eval(data);
			});
		}
	};
</script>