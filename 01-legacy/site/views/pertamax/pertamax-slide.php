        <div id="main-photo-slider" class="csw">
        	<?php 
				while($dtsl = mysqli_fetch_array($qls)): 
				$size = explode("#",$dtsl['2']);
				$satuan = ($size[1] == "M" || $size[1] == "m")?"m&sup2;":"cm&sup2;";
				$ukuran = ($size[0] == "-" || $size[0] == "")?"-":$size[0]."&nbsp;".$satuan;				
			?>
			<div class="panelContainer">	
				<div class="panel" title="Panel 3">
                    <div class="kotakslide" style=" 0px 0px no-repeat;"background:url(https://www.uterogroup.com/img/imgslide/<?=$dtsl['0']?>.pic)></div>
                    <div class="photo-meta-data">
						<span class="titleslide">
                        	<a href="<?=$root?>/produk/<?=$dtsl[9]?>.app" title="<?=$dtsl['1']?>"><?=$dtsl['1']?> &rarr;</a>
						</span>
                        <span class="specslide">
							Ukuran: <?=$ukuran?> | Harga Satuan: <b>Rp. <?=number_format($dtsl[5], 0, ',', '.')?>,-</b>
						</span>
                    </div>                    
				</div>
			</div>
			<?php endwhile; ?>           
		</div>