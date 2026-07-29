            <div id="bodytengah" style="height:890px;overflow-x: hidden; position: relative;">
            	<div class="label">UTERO NEWS</div>
				<?php 
					while($dt=mysqli_fetch_array($qlr)): 
					$i++;
					$bg=(($i % 2) == 0)?"background-color:#EBF5FE;":"background-color:#F4FAFF;";
				?>
				<div class="news" style="<?=$bg?>">
					<span class="tgl"><?=tanggal($dt[3])?></span>
					<span class="titlenews"><a href="<?=$root?>/news/<?=$dt[5]?>.app" title="<?=$dt[1]?>"><?=ucfirst($dt[1])?></a></span>
					<span class="isinews"><?=strip_tags(substr("$dt[2]", 0, 250))?></span>
				</div>
				<?php endwhile; ?>
                <span class="lineboth"><?=$halaman_str?></span>
            </div>