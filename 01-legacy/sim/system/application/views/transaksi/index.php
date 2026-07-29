<html>
	<head>
		<title>Web Administrator ::: TRANSAKSI</title>
		<?php echo stylesheet_tag() ?>
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
			<div id="headsub2"><?php echo menu_child_transaksi_tag(); ?></div>
			<div id="headsub1"><h1>Welcome : <?php echo $user; ?></h1></div>
	  </div>
	</body>
</html>