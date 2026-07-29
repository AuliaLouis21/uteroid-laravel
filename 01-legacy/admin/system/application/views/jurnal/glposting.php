<html>
	<head>
		<title>Web Administrator ::: JURNAL</title>
		<?=jquery_tag()?>
		<?=jquery_ui_tag()?>
		<?= jquery_blockui_tag() ?>
		<?= javascript_ajax_tag() ?>
		<?=jquery_ui_stylesheet_tag()?>
		<?= stylesheet_tag() ?>
		<? $this->load->view('jurnal/glposting.js.php') ?>
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
				<?=form_open('',array('name'=>'form1','id'=>'form1')) ?>
					<fieldset>
						<table style='float:left'>
							<tr>
								<td><?=label_for('Tanggal : ')?></td>
								<td><?=calendar_tag(array('name'=>'tanggal_awal','id'=>'tanggal_awal','onkeypress'=>'tanggal_awal_onKeyPress(event)')) ?></td>
								<td><?=label_for(' Ke : ')?></td>
								<td><?=calendar_tag(array('name'=>'tanggal_akhir','id'=>'tanggal_akhir','onkeypress'=>'tanggal_akhir_onKeyPress(event)'))?></td>
								<!--<td>
									<div style='margin-left:100px'>
										<?=button_tag(array('name'=>'button_account_baru','id'=>'button_account_baru','value'=>'Account Baru','style'=>'width:130px;height:50px'))?>
									</div>
								</td>-->
								<td>
									<div style='margin-left:100px'>
										<?=button_tag(array('name'=>'button_transaksi_hari_ini','id'=>'button_transaksi_hari_ini',
										'value'=>'Transaksi Hari Ini','style'=>'width:130px;height:50px','onclick'=>'button_transaksi_hari_ini_onClick(event)'))?>
										</div>
								</td>
								<!--<td>
									<?=button_tag(array('name'=>'button_baru','id'=>'button_baru','value'=>'Baru','style'=>'width:130px;height:50px'))?>
								</td>
								<td>
									<?=button_tag(array('name'=>'button_simpan','id'=>'button_simpan','value'=>'Simpan','style'=>'width:130px;height:50px'))?>
								</td>
								<td>
									<?=button_tag(array('name'=>'button_modifikasi','id'=>'button_modifikasi','value'=>'Modifikasi','style'=>'width:130px;height:50px'))?>
								</td>
								<td>
									<?=button_tag(array('name'=>'button_cari','id'=>'button_cari','value'=>'Cari','style'=>'width:130px;height:50px'))?>
								</td>-->
							</tr>
						</table>
					</fieldset>
					<fieldset>
						<table style='float:left;'>
							<tr>
								<td><?=label_for("Sortir Berdasarkan : ") ?></td>
								<td><?=textbox_tag(array('id'=>'keterangan','name'=>'keterangan','style'=>'width:300px','onkeypress'=>'keterangan_onKeyPress(event)'))?></td>
							</tr>
						</table>
					</fieldset>
					<div id="table-content">
						
					</div>
				<?=form_close()?>
			</div>
		</div>
	</body>
</html>