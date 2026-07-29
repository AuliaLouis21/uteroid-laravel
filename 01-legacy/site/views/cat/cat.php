            <div id="bodytengah">
				<div class="label">Jenis Produk</div>        
				<?=(isset($empty))?"<span class=\"empty\">Maaf Data Masih Kosong</center>":NULL?>
				<?php 
					while($dtr = mysqli_fetch_array($qlr)):
					$i++;
					$bg=(($i % 2) == 1) ? "background-color:#EBF5FE;" : "background-color:#F4FAFF;";
				?>
				<div class="jenis" style="<?=$bg?>">
					<span class="titlejenis" style="text-decoration:underline; margin-bottom:2px;">
						<a href="<?=$root?>/jenis/<?=$dtr[1]?>/<?=$dtr[4]?>.app" title="<?=$dtr[2]?>"><?=ucwords($dtr[2])?></a>
                    </span>
					<span class="ketjenis"><?=strip_tags(substr("$dtr[3]", 0, 150))?></span>
				</div>               
				<?php endwhile; ?>         
			</div>