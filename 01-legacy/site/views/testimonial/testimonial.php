            <div id="bodytengah" style="height:890px;overflow-x: hidden; position: relative;">
            	<div class="label">Testimonial</div>
				<?php 
					echo (mysqli_num_rows($ql)<'1')?"<div class=\"news\">Belum Ada Testimonial</div>":NULL;
					while($dt=mysqli_fetch_array($ql)): 
					$i++;
				?>                
  				<div class="news">
	  					<div class="isitesti"><?=ucfirst($dt['1'])?></div>
                        <div class="infotesti">From : <?=$dt['2']?> &rarr; <?=tanggal($dt['5'])?></div>
				</div>
                <?php endwhile; ?>
                <div class="lineboth">&nbsp;</div>
                
                <div class="judul" style="background:url(<?=$view?>/images/add.gif) left 4px no-repeat #FFF;">
                	<a href="javascript:null(0);" id="btadd" style="text-decoration:none; margin-left:16px;">Add Testimonial</a>
				</div>
                <div class="formtesti" id="formadd" style="<?=(isset($error))?NULL:"display:none"?>;">
                    <form method="post" method="post" >
                        <span>
                        	<label for="nama">Name</label>
                            <input type="text" name="nama" title="Your Name" id="nama" value="<?=(isset($error))?$_POST['nama']:NULL?>"/>
                            <div class="error"><?=(isset($msg['nama']))?$msg['nama']:NULL?></div>
						</span>
                        <span>
                        	<label for="mail">Email</label>
                            <input type="text" name="mail" title="your email" id="mail" value="<?=(isset($error))?$_POST['mail']:NULL?>"/>
                            <div class="error"><?=(isset($msg['mail']))?$msg['mail']:NULL?></div>
						</span>
                        <span>
                        	<label for="prsh">Perusahaan</label>
                            <input type="text" name="prsh" title="your email" id="prsh"/>
						</span>                        
                        <span>
                        	<label for="testinya">Testimonial</label>
                            <textarea name="testinya" id="testinya"><?=(isset($error))?$_POST['testinya']:NULL?></textarea>
                            <div class="error"><?=(isset($msg['testinya']))?$msg['testinya']:NULL?></div>
						</span>
                        <span>
                        	<label for="code">Security Code</label>
                          	<img src="<?=$root?>/captcha/imgcap.cap" alt="captcha" style="float:left; border:1px solid #666;"/>
                            <input type="text" name="code" title="Security code" AUTOCOMPLETE="OFF" style="width:150px; margin-top:4px" id="code"/>
                            <div class="error"><?=(isset($msg['code']))?$msg['code']:NULL?></div>
						</span>
                        <span>
                        	<label>&nbsp;</label>
                        	<input type="submit" name="submit" value="SEND TESTIMONIAL"/>
						</span>
                    </form>
                </div>
                <br /><?=(isset($sukses))?"$sukses":NULL;?><br />
            </div>