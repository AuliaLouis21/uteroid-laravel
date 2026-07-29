<html>
	<head>
		<title>Web Administrator ::: DELETE BAHAN BAKU </title>
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
				else {
					form.submit();
				}
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
				<form name='form1' name='form1' method='post' action='<?php echo $post_url ?>'>
					<?php $row = $query_bahan_baku->row_array()?>
					<table style='float:left'>
						<tr>
							<td><?php echo label_for('Bahan Baku')?></td>
							<td><?php echo label_for(':')?></td>
							<td><?php echo textbox_tag(array('id'=>'bahan_baku','name'=>'bahan_baku',
								'style'=>'width:250px;','value'=>$row['bahan_baku']))?></td>
							<td class='table-row-center' colspan='3'>
								<?php echo button_tag(array('id'=>'button_simpan','type'=>'button',
									'value'=>'hapus','onclick'=>'button_simpan_onClick(event)'))?>
							</td>
							<?php echo hidden_tag(array('name'=>'no_id','value'=>$row['no_id']))?>
							<?php echo hidden_tag(array('name'=>'action','value'=>'delete'))?>
							<?php $query_bahan_baku->free_result() ?>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>