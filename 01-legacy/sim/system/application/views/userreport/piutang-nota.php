<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
    <title>Web Administrator - LAPORAN :: PIUTANG NOTA ::: <?=$user?></title>   
		<?= jquery_tag(); ?>
		<?= jquery_ui_tag(); ?>
		<?= jquery_blockui_tag() ?>
		<?= javascript_ajax_tag() ?>
		<?= simplemodal_tag(); ?>
		<?= jquery_ui_stylesheet_tag(); ?>
		<?= stylesheet_tag(); ?>
		<? $this->load->view('userreport/piutang-nota.js.php') ?>
	</head>
	<body>
		<div id="header">
        <?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?>
    </div>
		<form name='form1' id='form1'>
			<div id="header2">
				<div id='headsub2'> 
					<?= menu_child_laporan_non_admin_tag() ?>
				</div>
				<div id='headsub1'> 
					<h1>Welcome : <?= $user; ?></h1>
				</div>
			</div>
			<div id='content'>
				<div id='contentwrapper'>
					<div>
						<fieldset>
							<legend>Laporan Nota </legend>
							<table style="float: left;">
								<tr>
									<td><?= label_for('No Nota')?></td>
									<td><?= label_for(':'); ?></td>
									<td>
										<table>
											<tr>
												<td><?= textbox_tag(array('id'=>'nonota','name'=>'nonota','onkeypress'=>'nonota_onKeyPress(event);')); ?></td>
											</tr>
										</table>
									</td>
									<td>
									<td><?= label_for('Tanggal Terima')?></td>
									<td><?= label_for(':'); ?></td>
									<td>
										<table>
											<tr>
												<td><?= calendar_tag(array('id'=>'tanggalterima','name'=>'tanggalterima','onkeypress'=>'tanggalterima_onKeyPress(event);')); ?></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td><?= label_for('Tanggal Dari'); ?></td>
									<td><?= label_for(':'); ?></td>
									<td>
										<table>
											<tr>
												<td><?= calendar_tag(array('id'=>'tanggalawal','name'=>'tanggalawal','onkeypress'=>'tanggalawal_onKeyPress(event);'))?>
												</td>
											</tr>
										</table>
									</td>
									<td colspan='3'>
										<center><?=label_for('S/D'); ?>
										</center>
									</td>	
									<td>
										<table>
											<tr>
												<td><?=calendar_tag(array('id'=>'tanggalakhir','name'=>'tanggallakhir','onkeypress'=>'tanggalakhir_onKeyPress(event)'))?></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan='6'><?= button_tag(array('id'=>'buttonPreviewTanggalSekarang',
											'name'=>'buttonPreviewTanggalSekarang','value'=>'Tanggal Sekarang',
											'onclick'=>'javascript:buttonPreviewTanggalSekarang_onClick(event)')) ?>
									</td>
								</tr>
							</table>
						</fieldset>
						<div id="table-content"></div>
					</div>
				</div>
			</div>
		</form>
	</body>
</html>