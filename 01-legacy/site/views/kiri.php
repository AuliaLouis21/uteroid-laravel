        	<div id="bodykiri">
            	<div class="label">Product Category</div>
                <div id="menuscrolling">
                    <ul class="menukiri">
                    <?php
                        $sql = mysqli_query($konek,"SELECT * FROM catproduk ORDER BY nama ASC");
                        while($dtx=mysqli_fetch_array($sql)):
                    ?>				
                        <li><a href="<?=$root?>/cat/<?=$dtx[0]?>/<?=$dtx[3]?>.app" title="category: <?=$dtx[1]?>"><?=$dtx[1]?></a></li>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>  
