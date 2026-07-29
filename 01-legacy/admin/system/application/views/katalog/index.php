<html>
	<head>
		<title>Web Administrator ::: KATALOG</title>
		<?php echo jquery_tag() ?>
		<?php echo jquery_ui_tag() ?>
		<?php echo jquery_ui_stylesheet_tag() ?>
		<?php echo stylesheet_tag() ?>
		<?php echo simplemodal_tag() ?>
		<?php echo javascript_util_tag() ?>
		<?php echo jquery_blockui_tag() ?>
		<?php echo javascript_ajax_tag() ?>
		<script type='text/javascript'>
			var document_width = null;
			var document_heigth = null;
			var jDocument = null;
			jQuery(document).ready(function(){
				document.getElementById('ukuran').readOnly = true;
				document.getElementById('ketebalan').readOnly = true;
				document.getElementById('minimal_order').readOnly = true;
				document.getElementById('harga_satuan').readOnly = true;
				document.getElementById('total_harga1').readOnly = true;
				document.getElementById('total_harga2').readOnly = true;
				
				jDocument = jQuery(document);
				document_width = jDocument.width();
				document_height = jDocument.height();
			});
			function kategori_onChange(event) {
				var target = event.target;
				ajax_default('service','jenis-produk='+target.value+'&param=get-jenis-produk',
					function() { block_ui('loading data produk ... '); },
					function(xml) {
						var jenis_produk = document.getElementById('jenis_produk');
						jenis_produk.innerHTML = xml;
						document.getElementById('keterangan').innerHTML = "";
						clear_all();
						unblock_ui();
					},
					function(xml) {
						alert('oops , something wrong on the server');
						unblock_ui();
					}
				);
			};
			
			function jenis_produk_onChange(event) {
				var target = event.target;
				ajax_default('service','jenis-produk='+target.value+'&param=get-keterangan-jenis',
					function() { block_ui('loading jenis produk ... '); },
					function(xml) {
						var jenis_produk = document.getElementById('jenis_produk');
						var result = xml.split(':::');
						document.getElementById('keterangan').innerHTML = result[0];
						document.getElementById('nama_produk').innerHTML = result[1];
						unblock_ui();
					},
					function(xml) {
						alert('oops , something wrong on the server');
						unblock_ui();
					}
				);
			};
			
			function nama_produk_onClick(event) {
				var target = event.target;
				jQuery.post('<?php echo base_url().index_page().'/katalog/service' ?>',
					'jenis-produk='+target.value+'&param=get-detail-produk',
					function(data) {
						eval(data);
						var image = document.getElementById('gambar');
						image.src = "<?php echo base_url().index_page().'/katalog/imageservice/' ?>"+target.value;
					});
				ajax_default('service','jenis-produk='+target.value+'&param=get-detail-produk',
					function() { block_ui('loading jenis produk ... '); },
					function(xml) {
						eval(xml);
						var image = document.getElementById('gambar');
						image.src = "<?php echo base_url().index_page().'/katalog/imageservice/' ?>"+target.value;
						unblock_ui();
					},
					function(xml) {
						alert('oops , something wrong on the server');
						unblock_ui();
					}
				);
			};
			
			function jumlah_order_onKeyUp(event) {
				var target = event.target;
				calculate_all(target);
			};
			function jumlah_order_onBlur(event) {
				var target = event.target;
				calculate_all(target);
			};
			
			function quantity_onKeyUp(event) {
				var target = event.target;
				calculate_all(target);
			};
			function quantity_onBlur(event) {
				var target = event.target;
				calculate_all(target);
			};
			
			function button_cetak_onClick(event) {
				var src="<?php echo base_url().index_page().'/katalog/cetak/' ?>";
				var _height = document_height - 60;
				var _width = document_width - 60;
				var target = event.target;
				var options = {
					containerCss:{
						height: _height,
						padding:0,
						margin:0,
						width:_width
					}
				};				
				var kategori_produk = document.getElementById('kategori');
				var jenis_produk = document.getElementById('jenis_produk');
				var nama_produk = document.getElementById('nama_produk');
				var jumlah_order = document.getElementById('jumlah_order');
				var harga_satuan1 = document.getElementById('total_harga1');
				var quantity = document.getElementById('quantity');
				var harga_satuan2 = document.getElementById('total_harga2');
				if(kategori_produk.value == "null") {
					alert('kategori produk tidak valid !!');
					kategori_produk.focus();
					return;
				}
				if(jenis_produk.value == "null") {
					alert('jenis produk tidak valid !!');
					jenis_produk.focus();
					return;
				}
				if (nama_produk.value == "null") {
					alert('nama produk tidak valid !!');
					nama_produk.focus();
					return;
				}
				else {
					src += 'kategori_produk/'+kategori_produk.value+'/jenis_produk/'+jenis_produk.value+'/nama_produk/'+nama_produk.value+
						'/jumlah_order/'+jumlah_order.value+'/harga_satuan1/'+harga_satuan1.value+
						'/quantity/'+quantity.value+'/harga_satuan2/'+harga_satuan2.value;					
						
					jQuery.modal('<iframe src="' + src + '" height="'+(_height) 
						+'" width="'+(_width)+'" style="border:0">',options);
				}
			};
			
			function clear_all() {
				document.getElementById('ukuran').value = '';
				document.getElementById('ketebalan').value = '';
				document.getElementById('minimal_order').value = '';
				document.getElementById('harga_satuan').value = '';
				document.getElementById('nama_produk').innerHTML = "<option value=null>Pilih Nama Produk</option>";
			};
			
			function calculate_all(target) {
				var total_harga1 = document.getElementById('total_harga1');
				var total_harga2 = document.getElementById('total_harga2');
				var harga_satuan = document.getElementById('harga_satuan');
				if(target.value != "") {
					total_harga1.value = parseFloat(String2Number(harga_satuan.value)) * parseFloat(target.value);
					total_harga2.value = parseFloat(String2Number(harga_satuan.value)) * parseFloat(target.value);
					total_harga1.value = Number2String(total_harga1.value);
					total_harga2.value = Number2String(total_harga2.value);
				}
			};
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
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<form name='form1' name='form1' method='post'>
					<table style='float:left;'>
						<tr>
							<td>
								<fieldset>
									<table>
										<tr>
											<td><?php echo label_for('Kategori Produk') ?></td>
											<td><?php echo label_for(':') ?></td>
											<td><?php echo select_tag(array('id'=>'kategori','name'=>'kategori',
															'onchange'=>'kategori_onChange(event)'),$kategori) ?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Jenis Produk') ?></td>
											<td><?php echo label_for(':') ?></td>
											<td><?php echo select_tag(array('id'=>'jenis_produk','name'=>'jenis_produk',
															'onclick'=>'jenis_produk_onChange(event)'),array('null'=>'Pilih Jenis Produk')) ?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Keterangan') ?></td>
											<td><?php echo label_for(':') ?></td>
											<td><?php echo textarea_tag(array('id'=>'keterangan','name'=>'keterangan',
															'style'=>'width: 460px; height: 50px;')) ?></td>
										</tr>
										<tr>
											<td><?php echo label_for('Nama Produk') ?></td>
											<td><?php echo label_for(':') ?></td>
											<td><?php echo select_tag(array('id'=>'nama_produk','name'=>'nama_produk',
														'onclick'=>'nama_produk_onClick(event)'),array('null'=>'Pilih Nama Produk')) ?></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td>
												<table>
													<tr>
														<td><?php echo label_for('Ukuran') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'ukuran','name'=>'ukuran','style'=>'width:100px')) ?></td>
														<td><?php echo label_for('Ketebalan') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'ketebalan','name'=>'ketebalan','style'=>'width:100px')) ?></td>
													</tr>
													<tr>
														<td><?php echo label_for('Minimal Order') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'minimal_order','name'=>'minimal_order','style'=>'width:100px')) ?></td>
														<td><?php echo label_for('Harga Satuan') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'harga_satuan','name'=>'harga_satuan','style'=>'width:100px;text-align:right')) ?></td>
													</tr>
													<tr>
														<td><?php echo label_for('Jumlah Order M2/CM2') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'jumlah_order','name'=>'jumlah_order','style'=>'width:100px;',
																		'onkeyup'=>'jumlah_order_onKeyUp(event)','onblur'=>'jumlah_order_onBlur(event)')) ?></td>
														<td><?php echo label_for('Total Harga') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'total_harga1','name'=>'total_harga1','style'=>'width:100px;text-align:right')) ?></td>
													</tr>
													<tr>
														<td><?php echo label_for('Quantity') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'quantity','name'=>'quantity','style'=>'width:100px;',
																		'onkeyup'=>'quantity_onKeyUp(event)','onblur'=>'quantity_onBlur(event)')) ?></td>
														<td><?php echo label_for('Total Harga') ?></td>
														<td><?php echo label_for(':') ?></td>
														<td><?php echo textbox_tag(array('id'=>'total_harga2','name'=>'total_harga2','style'=>'width:100px;text-align:right')) ?></td>
													</tr>
												</table>
											</td>
										</tr>							
									</table>
								</fieldset>
							</td>
							<td>
								<fieldset>
									<img id='gambar' src='<?php echo base_url().'/resources/images/image.jpg' ?>' style='height:253px;width:350px'/>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td colspan='2'>
								<fieldset>
									<table style='float:right'>
										<tr>
											<td><?php echo button_tag(array('id'=>'button_cetak',
														'name'=>'button_cetak','style'=>'width:100px;height:87px;',
														'value'=>'Cetak','onclick'=>'button_cetak_onClick(event)'))?>
											</td>
										</tr>
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