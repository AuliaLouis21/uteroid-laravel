<div id="content">
<table id="hor-zebra" summary="Employee Pay Sheet" >
    <thead>
        <tr>
            <th cellpadding="8px" scope="col" class="chk"><input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/></th>
            <th cellpadding="8px" scope="col" class="jdpost">Title Pages</th>
             <th cellpadding="8px" scope="col" class="isipost">Content</th>
            <th cellpadding="8px" scope="col" >&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?=(isset($empty))?"<tr><td colspan=\"4\" class=\"empty\">$empty</td></tr>":NULL?>
    <form name="chkdel" method="post">
    <?php 
        $i = 0;
        while($dt=mysql_fetch_array($ql)): 
        $i++;
    ?>	
        <tr class="odd<?=($i & 1)?>">				
            <td class="chk"><input type="checkbox" id="cuk" name="del[]" value="<?=$dt[0]?>"/></td>
            <td class="jdpost "><?=$dt[1]?></td>
            <td class="isipost"><?=strip_tags(substr("$dt[2]", 0, 150))." ..."?></td>
            <td style="text-align:center; width:80px;">
            	<a href="<?=$root?>/?cms=pages&sub=edit&id=<?=$dt[0]?>">[edit]</a>&nbsp;
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
    	<input type="submit" name="submit" value="Delete Pages" style="margin-top:8px;"/>
    </form>
</div>