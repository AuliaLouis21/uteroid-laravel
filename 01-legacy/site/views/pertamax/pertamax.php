            <div id="bodytengah">
            	<div id="boxpromo"><? require_once("$dirview/pertamax/pertamax-slide.php"); ?></div>
            	<div class="label" style="margin-bottom:8px;">produk terbaru</div>
				<?php
                    $x = 0;
                    while($dt=mysqli_fetch_array($ql)): 
                    $x++;
                    $margin=(($x % 3)==0)?"margin-right:0px;":"margin-right:8px;";
                ?>                
                <div class="produklist" style="<?=$margin?>">
                	<a href="<?=$root?>/produk/<?=$dt[9]?>.app" title="<?=$dt[1]?>">
                    	<img src="<?=$root?>/img/imgcrop/<?=$dt[0]?>.pic" alt="<?=$dt[1]?>"/>
                    </a>
                    <span class="prodtitle"><a href="<?=$root?>/produk/<?=$dt[9]?>.app" title="<?=$dt[1]?>"><?=strtoupper($dt[1])?></a></span>
                    <span class="prodprice">Rp. <?=number_format($dt[5], 0, ',', '.')?>,-</span>
				</div>
				<?php endwhile; ?>
                <span class="lineboth"><a href="<?=$root?>/produk.app" title="All Product">...See All Product &raquo;</a></span>
            </div>