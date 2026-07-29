<html>
	<head>
		<title>Web Administrator ::: GL REPORT</title>
		<?= jquery_tag() ?>
		<?= jquery_ui_tag() ?>
		<?= jquery_ui_stylesheet_tag() ?>
		<?= stylesheet_tag() ?>
		<?= simplemodal_tag() ?>
		<?= javascript_util_tag() ?>
		<?= jquery_blockui_tag() ?>
		<?= javascript_ajax_tag() ?>
		<script type='text/javascript'>
			var document_width = null;
			var document_heigth = null;
			var jDocument = null;
			jQuery(document).ready(function(){
				jQuery("#tanggal_awal,#tanggal_akhir")
				.datepicker({
					showOn: 'button', 
					buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					dateFormat : "d-m-yy",
					showButtonPanel: true
				});
				jDocument = jQuery(document);
				document_width = jDocument.width();
				document_height = jDocument.height();
			});
			function account_onKeyPress(event){
				var keycode = event.keyCode || event.charCode;
				if(keycode == 13) {
					var target = event.target;
					ajax_default('service','param=get_nama_account_group&id='+target.value,
						function(){
							block_ui('request data to server , please wait');
						},
						function(xml){
							var element = document.getElementById('div-account-group');
							if(xml != "false")
								element.innerHTML = xml;
							else 
								alert('opps, data yg dicari tidak ada');
							unblock_ui();
						},
						function(xml){
							alert('oops , something wrong on the server , please try again');
							unblock_ui();
						}
					);
				}
			}
			function button_cetak_onClick(event) {
				if(jQuery("input:checked:not(#check_all)").length == 0) {
					alert("harap dipilih acoount");
					return;
				}
				var tanggal_awal = document.getElementById("tanggal_awal");
				var tanggal_akhir = document.getElementById("tanggal_akhir");
				if(tanggal_awal.value == "") {
					alert("harap isi tanggal awal");
					tanggal_awal.focus();
					return;
				}
				if(tanggal_akhir.value == "") {
					alert("harap isi tanggal akhir");
					tanggal_akhir.focus();
					return;
				}
				var data = jQuery(document.form1).serialize();
				var src = "<?= site_url().'/jurnal/preview/' ?>";
				var _height = document_height - 60;
				var _width = document_width - 60;
				var target = event.target;
				var options = {containerCss:{height: _height,padding:0,margin:0,width:_width}};		
				
				var all_checkbox_value = "";
				jQuery(":checkbox").each(function(index,element){
						if(element.checked == true) 
							if(element.value != "check_all")
								all_checkbox_value += element.value + ";";
				});
				all_checkbox_value = all_checkbox_value.substr(0,all_checkbox_value.length - 1);
				src += "tanggal_awal/"+tanggal_awal.value+"/tanggal_akhir/"+tanggal_akhir.value+"/all_checkbox_value/"+all_checkbox_value;
				jQuery.modal('<iframe src="' + src + '" height="'+(_height) 
						+'" width="'+(_width)+'" style="border:0">',options);
			}
			function check_all_onClick(event) {
				var target = event.target;
				jQuery(":checkbox").each(function(index,element){
					if(target != element) {
						if(target.checked)
							element.checked = true;
						else
							element.checked = false;
					}
				});
			}
			
			function group_account_onChange(event) {
				var target = event.target;
				ajax_default('service','param=get_account_group&id='+target.value,
					function(){
						block_ui('request data to server , please wait');
					},
					function(xml){
						var element = document.getElementById('div-account-group');
						if(xml != "false")
							element.innerHTML = xml;
						else 
							alert('opps, data yg dicari tidak ada');
						unblock_ui();
						document.getElementById('check_all').checked = false;
					},
					function(xml){
						alert('oops , something wrong on the server , please try again');
						unblock_ui();
					}
				);
			}
		</script>
	</head>
	<body>
		<div id="header">
        <?php
					if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
					if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
					if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
				?>
    </div>
		<div id='header2'>
			<div id="headsub2">
				<?= menu_child_jurnal_tag() ?>
			</div>
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<?= form_open('',array('id'=>'form1','name'=>'form1')) ?>
					<fieldset>
						<table style='float:left;'>
							<tr>
								<td><?= label_for('Pencarian berdasarkan Account') ?></td>
								<td><?= label_for(':') ?></td>
								<td><?= textbox_tag(array('id'=>'account','name'=>'account','onkeypress'=>'account_onKeyPress(event)')) ?>
							</tr>
							<tr>
								<td><?= label_for('Pencarian berdasarkan Group Account') ?></td>
								<td><?= label_for(':') ?>
								<td><?= select_tag(array('id'=>'group_account','name'=>'group_account','onchange'=>'group_account_onChange(event)'),$account_group) ?>
							</td>
						</table>
					</fieldset>
					<fieldset>
						<div id="div-account-group" style="height:300px;overflow-y:scroll">
							<table style='float:left;'>
								<? foreach($this->db->query('select * from sim_account')->result_array() as  $row) : ?>
									<tr>
										<td><?=checkbox_tag(
											array('id'=>'cb_'.$row['no_id'],'name'=>'cb_account[]'),array($row['no_id']=>$row['code'])) ?>
										</td>
										<td>
											<div style='margin-left:100px'><?=label_for($row['account'])?></div>
										</td>
									</tr>
								<? endforeach ?>
							</table>	
						</div>
					</fieldset>
					
					<fieldset>
						<table style='float:left;'>
							<tr>
								<td>
									<?=checkbox_tag(array('name'=>'check_all','id'=>'check_all','onclick'=>'check_all_onClick(event)'),
											array('check_all'=>'')) ?>
								</td>
								<td colspan='5'><?= label_for('Tandai Semua') ?></td>
							</tr>
							<tr>
								<td></td>
								<td><?=label_for("Tanggal")?></td>
								<td><?=label_for(" : Dari ")?></td>
								<td><?=calendar_tag(array('id'=>'tanggal_awal','name'=>'tanggal_awal'))?></td>
								<td><?=label_for(" Ke : ")?></td>
								<td><?=calendar_tag(array('id'=>'tanggal_akhir','name'=>'tanggal_akhir'))?></td>
								<td><?=button_tag(array('name'=>'button_cetak','id'=>'button_cetak','value'=>'Cetak','onclick'=>'button_cetak_onClick(event)')) ?></td>
							</tr>
						</table>
					</fieldset>
				<?= form_close() ?>
			</div>
		</div>
	</body>
</html>