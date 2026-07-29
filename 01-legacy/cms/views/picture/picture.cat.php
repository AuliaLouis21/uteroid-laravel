<div id="content">
    <div id="contentwrapper">
        <div id="contentcolumn">
        	<?php if(isset($msgdel)): ?>
            <div style="border:1px solid #F00; background-color:#FFD7D7; margin:0px 0px 16px 0px; padding:16px!important;"><?=$msgdel?></div>
            <?php endif; ?>
        	<form method="post" style="margin:0px;padding:0px;" name="chkdel">
            <table id="hor-zebra" summary="Employee Pay Sheet" >
                <thead>
                    <tr>
                        <th cellpadding="8px" scope="col" class="chk">
                        	<input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/>
						</th>
                        <th cellpadding="8px" scope="col" class="cat">Categories</th>
                        <th cellpadding="8px" scope="col" class="desc">Description</th>
                        <th cellpadding="8px" scope="col" class="post">Posts</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($empty)): ?>
                	<tr><td colspan="4" class="empty"><?=$empty?></td></td>
                <?php endif; ?>
				
                <?php 
					$i = 0;
					while($dt=mysql_fetch_array($ql)): 
					$i++;
				?>	
                    <tr class="odd<?=($i & 1)?>">				
                    	<td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>" /></td>
                        <td class="cat"><?=$dt[1]?></td>
                        <td class="desc"><?=$dt[3]?></td>
                        <td class="post"><?=countpic($dt[0],$konek)?></td>
                    </tr>
				<?php endwhile; ?>
				
                </tbody>
            </table>
            <input type="submit" name="submit" value="Delete Album" />
            </form>
        </div>
    </div>
    <div id="rightcolumn">
    	<div id="formcat">
        	<span>Add New Album</span>
            <form method="post">
            	<div class="formnya">
                    <label for="nama">Album Name</label>
                    <input type="text" name="nama" value="" id="nama"  />   
                </div>
                <div class="formnya">
                    <label for="desc">Description</label>
                    <textarea name="descript" id="desc" ></textarea>
				</div>
                <div class="formnya">
	                <input type="submit" name="submit" value="Add New Album"  />
				</div>
            </form>
        </div>
    </div>
</div>