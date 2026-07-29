<html>
	<head>
		<title>Web Admistrator ::: TRANSAKSI NOTA</title>
		<?=jquery_tag() ?>
		<?=jquery_ui_tag() ?>
		<?=jquery_blockui_tag() ?>
		<?=javascript_ajax_tag() ?>
		<?=javascript_util_tag() ?>
		<?=simplemodal_tag() ?>
		<?=jquery_ui_stylesheet_tag() ?>		
		<?=stylesheet_tag() ?>
		<style type='text/css'>
			.gridwrapper {
				width:100%;height:200px;border:1px solid silver;margin-top:8px;padding:2px;float:left;overflow-y:scroll;
			}
			.formwrapper {
				padding:2px;border:1px solid silver;width:100%;float:left;
			}
			.commandwrapper {
				width:100%;height:145px;border:1px solid silver;margin-top:8px;padding:2px;float:left;margin-bottom:8px;
			}
			fieldset { border:1px solid silver;}
		</style>
		<?php $this->load->view('transaksi-nota/hitung.js') ?>
		<?php $this->load->view('transaksi-nota/init.js') ?>
		<?php $this->load->view('transaksi-nota/index.js') ?>
		
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
			<div id='headsub2'>
				<?php echo menu_child_transaksi_tag() ?>
			</div>
			<div id='headsub1'>
				<h1>
					Welcome : <?php echo $user; ?>
				</h1>
			</div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<div id='formwrapper' class='formwrapper'>
					<form name='form1' id='form1' method='post'>
						<table style='float:left;'>
							<tr>
								<td>
									<fieldset>
										<legend><?php echo label_for('Klien')?>
										<table style='float:left;'>
											<tr>
												<td><?php echo label_for('No.Nota')?></td>
												<td><?php echo label_for(':')?></td>
												<td><?php echo textbox_tag(array('id'=>'no_nota','name'=>'no_nota'))?></td>
												<td colspan='2'>
												</td>
											</tr>
											<tr>
												<td><?php echo label_for('Nama')?></td>
												<td><?php echo label_for(':')?></td>
												<td><?php echo textbox_tag(array('id'=>'nama','name'=>'nama','style'=>'width:220px'))?></td>
												<td><?php echo button_tag(array('id'=>'button_cari_nama','name'=>'button_cari_nama',
														'onclick'=>'button_cari_nama_onClick(event);','value'=>'Cari Nama','style'=>'width:100px;'))?>
												</td>
												<td><?php echo button_tag(array('id'=>'button_klien_baru','name'=>'button_klien_baru',
														'onclick'=>'button_klien_baru_onClick(event);','value'=>'Klien Baru','style'=>'width:100px;'))?>
												</td>
											</tr>
											<tr>
												<td><?php echo label_for('Alamat')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo textbox_tag(array('id'=>'alamat','name'=>'alamat','style'=>'width:220px'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('Telepon')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo textbox_tag(array('id'=>'telepon','name'=>'telepon'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('Email')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo textbox_tag(array('id'=>'email','name'=>'email'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('Perusahaan')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo textbox_tag(array('id'=>'perusahaan','name'=>'perusahaan','style'=>'width:220px'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('Tema')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo textbox_tag(array('id'=>'tema','name'=>'tema','style'=>'width:220px'))?></td>
											</tr>
										</table>
									</fieldset>
								</td>
								<td>
									<fieldset>
										<legend><?php echo label_for('Sales Counter')?>
										<table style='float:left;width:400px'>
											<tr>
												<td><?php echo label_for('Nama Sales')?></td>
												<td><?php echo label_for(':')?></td>
												<td><?php echo textbox_tag(array('id'=>'nama_sales','name'=>'nama_sales','style'=>'width:250px'))?></td>
												<td><!--<?php echo button_tag(array('id'=>'button_cari_nama_sales','name'=>'button_cari_nama_sales',
														'onclick'=>'button_cari_nama_sales_onClick(event);','value'=>'Cari Sales','style'=>'width:100px;'))?>-->
												</td>
												<td><!--<?php echo button_tag(array('id'=>'button_sales_baru','name'=>'button_sales_baru',
														'onclick'=>'button_sales_baru_onClick(event);','value'=>'Sales Baru','style'=>'width:100px;'))?>-->
												</td>
											</tr>
											<tr>
												<td><?php echo label_for('Tanggal Terima')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo calendar_tag(array('id'=>'tanggal_terima','name'=>'tanggal_terima'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('DeadLine Desain')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo calendar_tag(array('id'=>'deadline_desain','name'=>'deadline_desain'))?></td>
											</tr>
											<tr>
												<td><?php echo label_for('Dealine Selesai')?></td>
												<td><?php echo label_for(':')?></td>
												<td colspan='3'><?php echo calendar_tag(array('id'=>'deadline_selesai','name'=>'deadline_selesai'))?></td>
											</tr>
										</table>
									</fieldset>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div id='gridwrapper' class='gridwrapper'>
					<table style='float:left;border-collapse: collapse; border: 1px solid silver; width: 100%;' border='1'>
						<tr>
							<td class='table-header'><?php echo label_for('Id') ?></td>
							<td class='table-header'><?php echo label_for('Kategori') ?></td>
							<td class='table-header'><?php echo label_for('Jenis Produk') ?></td>
							<td class='table-header'><?php echo label_for('Nama Produk') ?></td>
							<td class='table-header'><?php echo label_for('Ukuran') ?></td>
							<td class='table-header'><?php echo label_for('Harga Satuan') ?></td>
							<td class='table-header'><?php echo label_for('Jumlah') ?></td>
							<td class='table-header'><?php echo label_for('Diskon') ?></td>
							<td class='table-header'><?php echo label_for('Total') ?></td>
							<td class='table-header'><?php echo label_for('Action') ?></td>
						</tr>
						<tr>
							<td class='table-row-center' style='width:30px'></td>
							<td class='table-row-center' style='clear:both;width:180px;'>
								<?php echo select_tag(array('id'=>'produk_kategori','name'=>'produk_kategori','style'=>'width:180px;;','onchange'=>'produk_kategori_onChange(event)'),$produk_kategori) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:180px;'>
								<?php echo select_tag(array('id'=>'jenis_produk','name'=>'jenis_produk','style'=>'width:180px;','onclick'=>'jenis_produk_onClick(event);'),array('null'=>'pilih jenis produk')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:250px;'>
								<?php echo select_tag(array('id'=>'nama_produk','name'=>'nama_produk','style'=>'width:250px;','onclick'=>'nama_produk_onClick(event)'),array('null'=>'pilih jenis produk'))?>
							</td>
							<td class='table-row-center' style='clear:both;width:80px;'>
								<?php echo textbox_tag(array('id'=>'ukuran_produk','name'=>'ukuran_produk','style'=>'width:80px;text-align:center;')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:120px;'>
								<?php echo textbox_tag(array('id'=>'harga_satuan','name'=>'harga_satuan','style'=>'width:100px;text-align:right;')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:80px;'>
								<?php echo textbox_tag(array('id'=>'jumlah_produk','name'=>'jumlah_produk','style'=>'width:80px;text-align:right;')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:80px;'>
								<?php echo textbox_tag(array('id'=>'diskon_produk','name'=>'diskon_produk','style'=>'width:80px;text-align:right;')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:120px;'>
								<?php echo textbox_tag(array('id'=>'total_produk','name'=>'total_produk','style'=>'width:100px;text-align:right;')) ?>
							</td>
							<td class='table-row-center' style='clear:both;width:70px;'>
								<?php echo button_tag(array('id'=>'add_produk','name'=>'add_produk','value'=>'add','style'=>'width:60px;','onclick'=>'add_produk_onClick(event)')) ?>
							</td>
						</tr>						
					</table>
				</div>
				<div id='commandwrapper' class='commandwrapper'>
					<table style='float:right;'>
						<tr>
							<td>
								<table style='float:right;'>
									<tr>
										<td>
											<?php echo button_tag(array('id'=>'button_transaksi_baru',
											'name'=>'button_transaksi_baru','style'=>'width:100px;height:87px;',
											'value'=>'Baru','onclick'=>'button_transaksi_baru_onClick(event)'))?>
										</td>
										<td>
											<?php echo button_tag(array('id'=>'button_simpan_transaksi',
											'name'=>'button_simpan_transaksi','style'=>'width:100px;height:87px;',
											'value'=>'Simpan','onclick'=>'button_simpan_transaksi_onClick(event)'))?>
										</td>
										<td>
											<?php echo button_tag(array('id'=>'button_cetak_transaksi',
											'name'=>'button_cetak_transaksi','style'=>'width:100px;height:87px;',
											'value'=>'Cetak','onclick'=>'button_cetak_transaksi_onClick(event)'))?>
										</td>
									</tr>
								</table>
							</td>
							<td style="width:310px">
								<fieldset>
									<legend><?php echo label_for('Uang Muka / Dibayar')?></legend>
									<table style='float:left;'>
										<tr>
											<td><?php echo label_for('Prosentase')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'prosentase','name'=>'prosentase','style'=>'text-align:right;width:40px','onkeyup'=>'prosentase_onKeyUp(event)'))?></td>
											<td><?php echo label_for('%')?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Jumlah Uang')?></td>
											<td><?php echo label_for(':')?></td>
											<td colspan='2'><?php echo textbox_tag(array('id'=>'jumlah_uang','name'=>'jumlah_uang','style'=>'text-align:right;width:180px','onkeyup'=>'jumlah_uang_onKeyUp(event)'))?></td>
										</tr>
										<tr>
											<td><?php echo checkbox_tag(array('id'=>'card','name'=>'card','onclick'=>'card_onClick(event)'),array('card'=>'Card'))?></td>
											<td><?php echo label_for(':')?></td>
											<td colspan='2'><?php echo select_tag(array('id'=>'jumlah_card','name'=>'jumlah_card'),$jumlah_card); ?></td>
											
										</tr>
									</table>
								</fieldset>
							</td>
							<td style="width:325px;">
								<fieldset>
									<table style='float:left;'>
										<tr>
											<td><?php echo label_for('Total')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'total','name'=>'total','style'=>'text-align:right;width:180px','readonly'=>'true'))?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Biaya Tambahan')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'biaya_tambahan','name'=>'biaya_tambahan','style'=>'text-align:right;width:180px','onkeyup'=>'biaya_tambahan_onKeyUp(event)'))?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Jumlah Tagihan')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'jumlah_tagihan','name'=>'jumlah_tagihan','style'=>'text-align:right;width:180px','readonly'=>'true'))?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Sisa Tagihan')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'sisa_tagihan','name'=>'sisa_tagihan','style'=>'text-align:right;width:180px','readonly'=>'true'))?></td>
										</tr>
									</table>
								</fieldset>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<script type='text/javascript'>
			var sc_code = "<?=$this->session->userdata('users_code')?>";
			var sc_name = "<?=$this->session->userdata('users')?>";
			jQuery(document).ready(function(){
				document.getElementById('nama_sales').value = sc_name;
			});
		</script>
	</body>
</html>