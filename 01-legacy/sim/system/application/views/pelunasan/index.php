<html>
	<head>
		<title>Web Administrator ::: PELUNASAN</title>
		<?php echo jquery_ui_stylesheet_tag()?>
		<?php echo jquery_tag() ?>
		<?php echo jquery_ui_tag() ?>
		<?php echo simplemodal_tag() ?>
		<?php echo stylesheet_tag() ?>
		<style type='text/css'>
		</style>
		<script type='text/javascript'>
			var document_width = null;
			var document_height = null;
			jQuery(document).ready(function(){
				jQuery("#tanggal_awal,#tanggal_akhir,#tanggal_terima")
					.datepicker({
						showOn: 'button', 
						buttonImage: "<?php echo base_url() .'resources/style/images/calendar.gif'; ?>", 
						buttonImageOnly: true,
            changeMonth: true,
			    	changeYear: true,
			    	dateFormat : "d-m-yy",
			    	showButtonPanel: true
         	});
					document_width = jQuery(document).width();
					document_height = jQuery(document).height();
			});
			
			function button_tanggal_sekarang_onClick(event) {
				alert('tanggal sekarang clicked');
			};
		</script>
	</head>
	<body>
		<div id='header'><?php echo menu_tag() ?></div>
		<div id="bigloading" style="display: none;height:0px;" class='bigloading'>
			<center id="center-loading">
				<div style="top: 230px; position: relative; 
						background: url(<?php echo base_url()."resources/images/bigloading.gif"; ?>) 
						no-repeat scroll 0% 0% transparent; 
						vertical-align: middle; width: 66px; height: 66px;">
				</div>
			</center>
		</div>
		<div id='header2'>
			<div id='headsub2'><?php echo menu_child_transaksi_tag() ?></div>
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<form name='form1' id='form1' method='post'>
					<table style='float:left;width:100%'>
						<tr>
							<td>
								<fieldset>
									<legend><?php echo label_for('Cari Berdasarkan Nota')?></legend>
									<table style='float:left'>
										<tr>
											<td><?php echo label_for('No.Nota')?></td>
											<td><?php echo label_for(':')?></td>
											<td colspan='3'><?php echo textbox_tag(array('id'=>'no_nota',
													'name'=>'no_nota','onkeypress'=>'no_nota_onKeyPress(event);'))?>
											</td>
										</tr>
										<tr>
											<td><?php echo label_for('Dari Nota')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'nota_awal'
													,'name'=>'nota_awal','onkeypress'=>'nota_awal_onKeyPress(event)'))?>
											</td>
											<td><?php echo label_for('S/D')?></td>
											<td><?php echo textbox_tag(array('id'=>'nota_akhir'
													,'name'=>'nota_akhir','onkeypress'=>'nota_akhir_onKeyPress(event)'))?>
											</td>
										</tr>
									</table>
								</fieldset>				
							</td>
							<td>
								<fieldset>
									<legend><?php echo label_for('Pencarian Berdasarkan Tanggal')?></legend>
									<table style='float:left'>
										<tr>
											<td><?php echo label_for('Tanggal Terima')?></td>
											<td><?php echo label_for(':')?></td>
											<td>
												<?php echo calendar_tag(array('id'=>'tanggal_terima','name'=>'tanggal_terima'))?>
											</td>
											<td></td>
											<td><?php echo button_tag(array('id'=>'button_tanggal_sekarang',
													'name'=>'button_tanggal_sekarang','value'=>'tanggal sekarang',
													'onclick'=>'button_tanggal_sekarang_onClick(event)'))?>
											</td>
										</tr>
										<tr>
											<td><?php echo label_for('Tanggal Awal')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo calendar_tag(array('id'=>'tanggal_awal','name'=>'tanggal_awal'))?></td>
											<td><?php echo label_for('S/D')?></td>
											<td><?php echo calendar_tag(array('id'=>'tanggal_akhir','name'=>'tanggal_akhir'))?></td>
										</tr>
									</table>
								</fieldset>
							</td>
							<td><?php echo button_tag(array('id'=>'button_record',
								'name'=>'button_record','style'=>'width:100px;height:75px;',
								'value'=>'Record','onclick'=>'button_record_onClick(event)'))?>
							</td>
						</tr>
						<tr>
							<td colspan='3'>
								<fieldset>
									<table style='float:left;'>
										<td><?php echo label_for('Nama Klien')?></td>
										<td><?php echo label_for(':')?></td>
										<td><?php echo textbox_tag(array('id'=>'nama_klien',
											'name'=>'nama_klien','style'=>'width:400px;','onkeypress'=>'nama_klien_onKeyPress(event)')) ?>
										</td>
									</table>
								</fieldset>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>