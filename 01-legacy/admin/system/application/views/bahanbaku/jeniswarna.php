<html>
	<head>
		<title>Web Administrator ::: TAMBAH BAHAN BAKU </title>
		<?php echo jquery_tag()?>
		<?php echo jquery_ui_stylesheet_tag() ?>
		<?php echo stylesheet_tag()?>
		<script type='text/javascript'>
			function button_simpan_onClick(event) {
				var form = document.form1;
				if(form.bahan_baku.value == '') {
					alert('bahan baku masih kosong , harap di isi');
					form.bahan_baku.focus();
					return;
				}
				if(form.jenis_warna.value == ''){
					alert('jenis warna masih kosong , harap di isi');
					form.jenis_warna.focus();
					return;
				}
				form.submit();
			};
		</script>
	</head>
	<body>
		<div id="header">
        <?php if($this->session->userdata('isadmin') == 'true') echo menu_tag(); else echo menu_non_admin_tag(); ?>
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
			<div id='headsub2'><?php echo menu_child_bahan_baku_tag() ?></div>
			<div id='headsub1'><h1>Welcome : <?php echo $user; ?></h1></div>
		</div>
		<div id='content'>
			<div id='contentwrapper'>
				<form name='form1' name='form1' method='post' action='<?php echo $post_url; ?>'>
					<table style='float:left;width:100%;'>
						<tr>
							<td>
								<fieldset>
									<?php $row_bahan_baku = $query_bahan_baku->row_array() ?>
									<table style='float:left;'>
										<tr>
											<td><?php echo label_for('Bahan Baku')?></td>
											<td><?php echo label_for(':')?></td>
											<td colspan='2'><?php echo textbox_tag(array('id'=>'bahan_baku','name'=>'bahana_baku',
												'style'=>'width:250px;','value'=>$row_bahan_baku['bahan_baku']))?></td>							
										</tr>		
										<tr>
											<td><?php echo label_for('Jenis Warna')?></td>
											<td><?php echo label_for(':')?></td>
											<td><?php echo textbox_tag(array('id'=>'jenis_warna','name'=>'jenis_warna','style'=>'width:250px;'))?></td>
											<td class='table-row-center'>
												<?php echo button_tag(array('id'=>'button_simpan','type'=>'button',
													'value'=>'tambah jenis warna','onclick'=>'button_simpan_onClick(event)'))?>
											</td>
											<?php echo hidden_tag(array('name'=>'action','value'=>'add'))?>
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<table border='1' style='float: left; border-collapse: collapse; border: 1px solid silver; width: 500px;'>
										<tr>
											<td class='table-header'><?php echo label_for('No')?></td>
											<td class='table-header'><?php echo label_for('Jenis/Warna')?></td>
											<td class='table-header' colspan='2'><?php echo label_for('Action')?></td>
										</tr>
										<?php foreach($query_jenis_bahan_baku->result_array() as $row) { ?>
											<tr>
												<td class='table-row-center' style='width:50px;'><?php echo label_for($row['no_id'])?></td>
												<td class='table-row-center'><?php echo label_for($row['jenis_bahanbaku'])?></td>
												<td class='table-row-center'>
													<a href='<?php echo base_url().index_page().'/bahanbaku/editjeniswarna/' . $row['no_id']?>'>
														<?php echo label_for('edit')?>
													</a>
												</td>
												<td class='table-row-center'>
													<a href='<?php echo base_url().index_page().'/bahanbaku/deletejeniswarna/'. $row['no_id'] ?>'>
														<?php echo label_for('delete')?>
													</a>
												</td>
											</tr>
										<?php } ?>
										<?php echo hidden_tag(array('name'=>'action','value'=>'jenis_warna'))?>
										<?php echo hidden_tag(array('name'=>'no_id_jenis','value'=>$row['no_id']))?>
										<?php echo hidden_tag(array('name'=>'no_id_bahan_baku','value'=>$row_bahan_baku['no_id']))?>
										<?php $query_bahan_baku->free_result()?>
										<?php $query_jenis_bahan_baku->free_result() ?>
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