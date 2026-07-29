<div id="content">
    <h2>TYPES OF PRODUCTS IN CATEGORY : <?=strtoupper($cat['1'])?></h2>
    
    <div id="contentwrapper">
        <div id="contentcolumn">
        	<?php if(isset($msgdel)): ?>
            <div style="border:1px solid #F00; background-color:#FFD7D7; margin:0px 0px 16px 0px; padding:16px!important;"><?=$msgdel?></div>
            <?php endif; ?>
        	<form method="post" style="margin:0px;padding:0px;" name="chkdel">
            <table id="hor-zebra" style="border-bottom:1px solid #CCC;">
                <thead>
                    <tr>
                        <th cellpadding="8px" scope="col" class="chk">
                        	<input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/>
						</th>
                        <th cellpadding="8px" scope="col" class="cat">Product Types</th>
                        <th cellpadding="8px" scope="col" class="desc">Description</th>
                        <th cellpadding="8px" scope="col" class="post">Produk</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (isset($empty)): ?>
                	<tr><td colspan="4" class="empty"><?=$empty?></td></td>
                <?php endif; ?>
				
                <?php 
					$i = 0;
					while($jns=mysql_fetch_array($qlj)): 
					$i++;
				?>	
                    <tr class="odd<?=($i & 1)?>">				
                    	<td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$jns[0]?>" /></td>
                        <td class="cat"><?=$jns[1]?></td>
                        <td class="desc"><?=$jns[2]?></td>
                        <td class="post">0</td>
                    </tr>
				<?php endwhile; ?>
                </tbody>
            </table><br />
            <input type="submit" name="submit" value="Delete Product Type" />
            </form>
        </div>
    </div>
    <div id="rightcolumn">
	    <?=(isset($errmsg))?"<div id=\"errorform2\">".$errmsg."</div>":NULL?> 
    	<div id="formcat">
        	<span>Add New Product Type</span>
            <form method="post">
            	<div class="formnya">
                    <label for="nama">Jenis Produk</label>
                    <input type="text" name="jenis" value="" id="nama"  />   
                </div>
                <div class="formnya">
                    <label for="desc">Keterangan</label>
                    <textarea name="descript" id="desc" ></textarea>
				</div>
                <div class="formnya">
	                <input type="submit" name="submit" value="Add Product Type"  />
				</div>
            </form>
        </div>
    </div>
</div>