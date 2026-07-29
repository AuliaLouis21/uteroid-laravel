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
                        <th cellpadding="8px" scope="col" class="post">Jenis</th>
                    </tr>
                </thead>
                <tbody>
                <?=(isset($empty))?"<tr><td colspan=\"4\" class=\"empty\"><?=$empty?></td></td>":NULL;?>
				
                <?php 
					$i = 0;
					while($dt=mysql_fetch_array($ql)): 
					$i++;
				?>	
                    <tr class="odd<?=($i & 1)?>">				
                    	<td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>" /></td>
                        <td class="cat"><a href="./?cms=catalog&sub=jenis&show=<?=$dt[3]?>"><?=$dt[1]?></a></td>
                        <td class="desc"><?=$dt[2]?></td>
                        <td class="post"><a href="./?cms=catalog&sub=jenis&show=<?=$dt[3]?>"><?=countjns($dt[0],$konek)?></a></td>
                    </tr>
                    <input type="hidden" name="val[]" value="<?=$dt[1]?>" />
				<?php endwhile; ?>
                </tbody>
            </table><br />
            <input type="submit" name="submit" value="Delete Category" />
            </form>
        </div>
    </div>
    <div id="rightcolumn">
	    <?=(isset($errmsg))?"<div id=\"errorform2\">".$errmsg."</div>":NULL?>
    	<div id="formcat">
        	<span>Add New Category Product</span>
            <form method="post">
            	<div class="formnya">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" name="nama" value="" id="nama"  />   
                </div>
                <div class="formnya">
                    <label for="desc">Keterangan</label>
                    <textarea name="descript" id="desc" ></textarea>
				</div>
                <div class="formnya">
	                <input type="submit" name="submit" value="Add Category"  />
				</div>
            </form>
        </div>
    </div>
</div>