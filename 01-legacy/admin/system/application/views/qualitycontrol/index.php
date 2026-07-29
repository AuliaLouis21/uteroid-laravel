<html>
	<head>
		<title>WEB ADMINISTRATOR ::: QUALITY CONTROL</title>
		<?= jquery_ui_stylesheet_tag(); ?>
		<?= jquery_tag(); ?>
		<?= jquery_ui_tag(); ?>
		<?= stylesheet_tag(); ?>
		<?= javascript_ajax_tag() ?>
		<?= jquery_blockui_tag() ?>
		<? $this->load->view('qualitycontrol/index.js') ?>
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
			<div id='headsub1'>
				<h1>
					Welcome : <?= $user ?>
				</h1>
			</div>
		</div>
		<form name='form1' method='post'>
			<div id='content'>
				<div id='contentwrapper'>
					<div style='float:left'>
						<table style='float: left;width:100%'>
							<tr>
								<td>
									<fieldset>
									<legend><?= label_for("Selesai Desain") ?></legend>
									<table style='float: left;'>
										<tr>
											<td><?= label_for('Dari Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'selesaidesaintanggalawal','name'=>'selesaidesaintanggalawal',
															'onkeypress'=>'selesaidesaintanggalawal_onKeyPress(event);'
															));?>
											</td>
											<td><?= label_for('S/D')?></td>
											<td><?= calendar_tag(
															array('id'=>'selesaidesaintanggalakhir','name'=>'selesaidesaintanggalakhir',
															'onkeypress'=>'selesaidesaintanggalakhir_onKeyPress(event);'
															));?>
											</td>
										</tr>
										<tr>
											<td><?= label_for('Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(
															array('id'=>'selesaidesaintanggal','name'=>'selesaidesaintanggal',
															'onkeypress'=>'selesaidesaintanggal_onKeyPress(event);'
															));?>
											</td>
											<td>
											</td>
											<td><?= button_tag(array('id'=>'buttonselesaidesain','name'=>'buttonselesaidesain'
															,'value'=>'tanggal hari ini','onclick'=>'buttonselesaidesain_onClick(event);'));
													?>
											</td>
										</tr>
									</table>
									</fieldset>
								</td>
								<td>
									<fieldset>
									<legend><?= label_for("Selesai Produksi") ?></legend>
									<table style='float: left;'>
										<tr>
											<td><?= label_for('Dari Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'selesaiproduksitanggalawal','name'=>'selesaiproduksitanggalawal',
															'onkeypress'=>'selesaiproduksitanggalawal_onKeyPress(event);'
															));	?>
											</td>
											<td><?php echo label_for('S/D')?></td>
											<td><?= calendar_tag(array('id'=>'selesaiproduksitanggalakhir','name'=>'selesaidesaintanggalakhir',
															'onkeypress'=>'selesaiproduksitanggalakhir_onKeyPress(event);'
															));?>
											</td>
										</tr>
										<tr>
											<td><?= label_for('Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'selesaiproduksitanggal','name'=>'selesaidesaintanggal',
															'onkeypress'=>'selesaiproduksitanggal_onKeyPress(event);'
															));?>
											</td>
											<td>
											</td>
											<td><?= button_tag(array('id'=>'buttonselesaiproduksi','name'=>'buttonselesaiproduksi',
													'value'=>'tanggal hari ini','onclick'=>'buttonselesaiproduksi_onClick(event);'));?>
											</td>
										</tr>
									</table>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<fieldset>
									<legend><?= label_for("Tanggal Slip Order") ?></legend>
									<table style='float: left;'>
										<tr>
											<td><?= label_for('Dari Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'slipordertanggalawal','name'=>'slipordertanggalawal',
															'onkeypress'=>'slipordertanggalawal_onKeyPress(event);'
															));?>
											</td>
											<td><?= label_for('S/D')?></td>
											<td><?= calendar_tag(array('id'=>'slipordertanggalakhir','name'=>'slipordertanggalakhir',
															'onkeypress'=>'slipordertanggalakhir_onKeyPress(event);'
															));?>
											</td>
										</tr>
										<tr>
											<td><?= label_for('Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'slipordertanggal','name'=>'slipordertanggal',
															'onkeypress'=>'slipordertanggal_onKeyPress(event);'
															));
												?>
											</td>
											<td>
											</td>
											<td><?= button_tag(array('id'=>'buttonsliporder','name'=>'buttonsliporder',
														'value'=>'tanggal hari ini','onclick'=>'buttonsliporder_onClick(event);'));?>
											</td>
										</tr>
									</table>
									</fieldset>
								</td>
								<td>
									<fieldset>
									<legend><?= label_for("Selesai Ke Klien") ?></legend>
									<table style='float: left;'>
										<tr>
											<td><?= label_for('Dari Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'selesaikeklientanggalawal','name'=>'selesaikeklientanggalawal',
															'onkeypress'=>'selesaikeklientanggalawal_onKeyPress(event);'
															));?>
											</td>
											<td><?= label_for('S/D')?></td>
											<td><?= calendar_tag(array('id'=>'selesaikeklientanggalakhir','name'=>'selesaikeklientanggalakhir',
															'onkeypress'=>'selesaikeklientanggalakhir_onKeyPress(event);'
															));?>
											</td>
										</tr>
										<tr>
											<td><?= label_for('Tanggal')?></td>
											<td><?= label_for(":")?></td>
											<td><?= calendar_tag(array('id'=>'selesaikeklientanggal','name'=>'selesaikeklientanggal',
															'onkeypress'=>'selesaikeklientanggal_onKeyPress(event);'
															));
												?>
											</td>
											<td>
											</td>
											<td><?= button_tag(array('id'=>'buttonselesaikeklien','name'=>'buttonselesaikeklien',
														'value'=>'tanggal hari ini','onclick'=>'buttonselesaikeklien_onClick(event);'));?>
											</td>
										</tr>
									</table>
									</fieldset>
								</td>
							</tr>
						</table>
						<table style="float:left;width:100%;">
							<tr>
								<td>
									<fieldset>
										<table>
											<tr>
												<td><?= label_for("No.Nota")?></td>
												<td><?= label_for(":")?></td>
												<td><?= textbox_tag(array('id'=>'nonota','name'=>'nonota','onkeyup'=>'nonota_onKeyUp(event)'))?></td>
												<td>
													<table>
														<tr>
															<td><?= radio_tag(array('name'=>'tipebutton','onclick'=>"change_document_state(event);"),
																		array('sablon'=>'sablon',
																		'konstruksi'=>'konstruksi','slipp3'=>'slip p3','slipumum'=>'slip umum'));?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td><?= label_for("No.Slip")?></td>
												<td><?= label_for(":")?></td>
												<td><?= textbox_tag(array('id'=>'noslip','name'=>'noslip','onkeyup'=>'noslip_onKeyUp(event)'))?></td>
											</tr>
										</table>
									</fieldset>
								</td>
							</tr>
						</table>
					</div>
					<div id='content-table' style='float: left; margin-left: 3px; width:100%'></div>
				</div>
			</div>
		</form>
	</body>
</html>