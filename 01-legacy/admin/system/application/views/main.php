<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Web Administrator </title>
	<?php echo stylesheet_tag(); ?>	
</head>
<body>
    <div id="header">
        <?php
					if($this->session->userdata('isadmin') == 'true') echo menu_tag(); 
					//if($this->session->userdata('is_sc') == 'true') echo menu_admin_tag(); 
					if($this->session->userdata('is_sc') == 'true') echo menu_non_admin_tag();
					# untuk sementara user akses QC di off dolo
					#if($this->session->userdata('is_qc') == 'true') echo menu_qc_tag(); 
				?>
    </div>
    <div id="header2">
        <div id="headsub1">
            <h1>
                Welcome : <?php echo $user; ?>
             </h1>
        </div>
    </div>
</body>
</html>