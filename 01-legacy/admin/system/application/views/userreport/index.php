<html>
	<head>
		<title>Web Administrator ::: Laporan </title>
		<?=jquery_tag(); ?>
		<?=stylesheet_tag(); ?>
	</head>
	<body>
		<div id="header">
      <?php
				if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
				if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag(); 
				if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
			?>
    </div>
		<div id="header2">
			<div id="headsub2"><?=menu_child_laporan_non_admin_tag()?></div>
			<div id="headsub1"><h1>Welcome : <?=$user; ?></h1></div>
	  </div>
	</body>
</html>