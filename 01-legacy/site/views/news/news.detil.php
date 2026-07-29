            <div id="bodytengah">
            	<div class="label"><?=$dt[1]?></div>
				<div class="isinews"><?=$dt[2]?></div>
				<span class="lineboth">Posted at <?=tanggal($dt[3])?> - <?=$dt[4]?></span>
                
                <div class="judul">5 latest news</div>
                <?php 
					while($dt5=mysqli_fetch_array($q)):
				?>
                <span class="list">
                	&raquo; <a href="<?=$root?>/news/<?=$dt5['5']?>.app" title="<?=$dt5['1']?>"><?=ucfirst($dt5['1'])?></a>
				</span>
                <?php endwhile; ?>
                <span class="lineboth"><a href="<?=$root?>/news.app" title="See All News">... See All News &raquo;</a></span>
            </div>