<div id="content">
<table id="hor-zebra" summary="Employee Pay Sheet" >
    <thead>
        <tr>
            <th cellpadding="8px" scope="col" class="chk"><input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/></th>
            <th cellpadding="8px" scope="col" class="jdpost">Title</th>
             <th cellpadding="8px" scope="col" class="isipost">Posts</th>
            <!--th cellpadding="8px" scope="col" class="cate">Categories</th-->
            <th cellpadding="8px" scope="col" class="date">Date</th>
            <th cellpadding="8px" scope="col" style="width:30px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php if (isset($empty)): ?>
        <tr><td colspan="4" class="empty"><?=$empty?></td></td>
    <?php endif; ?>
    <form name="chkdel" method="post" >
    <?php 
        $i = 0;
        while($dt=mysql_fetch_array($ql)): 
        $i++;
    ?>	
        <tr class="odd<?=($i & 1)?>">				
            <td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>"/></td>
            <td class="jdpost "><a href="./?cms=<?=$include?>&sub=edit&id=<?=$dt[0]?>" title="EDIT"><?=$dt[1]?></a></td>
            <td class="isipost"><?=strip_tags(substr("$dt[2]", 0, 150))?></td>
            <!--td class="cate"><?=$dt[7]?></td-->
            <td class="date"><?=$dt[3]?></td>
            <td style="text-align:center;"><a href="./?cms=<?=$include?>&sub=edit&id=<?=$dt[0]?>" title="EDIT">EDIT</a></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
    	<input type="submit" name="submit" value="Delete Post" style="margin-top:8px;"/>
    </form>
</div>