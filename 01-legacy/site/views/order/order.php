			<?php
			if(isset($err)){
			?>
            <div id="bodytengah" style="height:890px;overflow-x: hidden; position: relative;">
                <div class="label">Detil Order</div> 
            </div>
            <?php
				echo (isset($err))?implode("<br>",$err):NULL;
				require("$dirview/footer.php");	
				die;
				
			}
			?>
            <div id="bodytengah" style="height:890px;overflow-x: hidden; position: relative;">
                <div class="label">Detil Order</div>            
               	<div class="detilorder" id="order1" style="<?=(!isset($d))?"display:none;":NULL?>">
                	<p>
                    	<label>Nama Produk</label>
                        <span><?=ucwords($_SESSION['produk'])?></span>
                    </p>
                    <p>
                    	<label>Harga Satuan</label>
                        <span>Rp. <?=number_format($_SESSION['hargasatuan'],0,",",".")?></span>
                    </p>
                    <p>
                    	<label>Minimum Order</label>
                        <span><?=$_SESSION['minorder']?></span>
                    </p>                    
                    <p>
                    	<label>Jumlah Order</label>
                        <span><?=$_SESSION['jumorder']?></span>
                    </p>                    
                    <p>
                    	<label style="background-color:#F00; color:#FFF;">Total Harga</label>
                        <span style="color:#F00;">Rp. <?=number_format($_SESSION['hasil'],0,",",".")?></span>
                    </p>
                   <div class="nextprev" style="border-top:1px solid #EFEFEF;">
						<input type="button" name="prev" value="&laquo; back" onclick="javascript:history.back(1)" style="float:left;"/>
                        <input type="button" name="next" value="next &raquo;" onclick="next()"/>
                    </div>                    
                </div>
               	<div class="detilorder2" id="order2" style="padding-top:0px; <?=(!isset($d))?"display:block;":"display:none"?>">
					<div class="title">Alamat Pengiriman</div>
                	<form method="post">
                	<p>
                    	<label>Nama Lengkap</label>
                        <span><input type="text" name="nama"/></span>
						<span class="er"><?=(isset($msg['nama']))?$msg['nama']:NULL?></span>
                    </p>
                    <p>
                    	<label>Email</label>
                        <span><input type="text" name="mail"/></span>
						<span class="er"><?=(isset($msg['mail']))?$msg['mail']:NULL?></span>
                    </p>
                    <p>
                    	<label>No telp</label>
                        <span><input type="text" name="notelp"/></span>
						<span class="er"><?=(isset($msg['notelp']))?$msg['notelp']:NULL?></span>
                    </p>
                    <p>
                    	<label>Alamat Pengiriman</label>
                        <span><textarea name="alamat"></textarea></span>
						<span class="er"><?=(isset($msg['alamat']))?$msg['alamat']:NULL?></span>
                    </p>
                    <p>
                    	<label>Kota</label>
                        <span><input type="text" name="kota" /></span>
						<span class="er"><?=(isset($msg['kota']))?$msg['kota']:NULL?></span>
                    </p>
                    <p>
                    	<label>Kode Pos</label>
                        <span><input type="text" name="kodepos" style="width:100px;" maxlength="7"/></span>
						<span class="er"><?=(isset($msg['kodepos']))?$msg['kodepos']:NULL?></span>
                    </p>
                    <p>
                    	<label>Pesan Tambahan,<br /> jika ada</label>
                        <span><textarea name="pesan"></textarea></span>
						<span class="er"><?=(isset($msg['pesan']))?$msg['pesan']:NULL?></span>
                    </p>
                    <div class="nextprev">
                        <input type="submit" value="finish" name="submit"/>
					</form>
                        <input type="button" name="prev" value="&laquo; back" onclick="mbalik()" style="float:left;"/>                    
                    </div>
                </div>
            </div>