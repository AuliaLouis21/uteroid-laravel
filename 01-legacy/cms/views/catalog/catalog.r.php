<div id="content">
	<form method="post" style="margin:0px;padding:0px;" name="chkdel">
    <table class="tablesorter">
    	<thead>
            <tr class="tbhead">
                <th style="width:30px;"><input type="checkbox" name="all" onClick="checkAll(document.chkdel.cuk,this)"/></th>
                <th style="width:50px;">img</th>
                <th	>NAMA</th>
                <th style="width:150px;">Category</th>                
                <th style="width:150px;">UKURAN</th>
                <th style="width:70px;">Ketebalan</th>
                <th style="width:70px;">Min Order</th>
                <th style="width:150px;">Harga Satuan</th>                                
                <th style="width:50px;">Promo</th>
            </tr>
		</thead>            
		<tbody>
            <?php
                $i=0;
                while ($d=mysql_fetch_array($qlr)):
                $i++;
                $size = explode("#",$d['2']);
                $satuan = ($size[1] == "M")?"m&sup2;":"cm&sup2;";
                $ukuran = ($size[0] == "-" || $size[0] == "")?"-":$size[0]."&nbsp;".$satuan;
                $bg=(($i % 2) == 0) ? "background-color:#EBF5FE;" : "background-color:#F4FAFF;";
            ?>        
            <tr class="tbrow" style="<?=$bg?>">
                <td><input type="checkbox" id="cuk" name="del[]" value="<?=$d[0]?>" /></td>
                <td><img src="https://www.uterogroup.com/img/imgcropkecil/<?=$d[0]?>.pic" alt="tes"/></td>
                <td style="text-align:left;"><?=strtoupper($d[1])?></td>
                <td><a href="./?cms=catalog&sub=jenis&show=<?=$d[14]?>" title="<?=$d[13]?>"><?=strtoupper($d[13])?></a></td>
                <td><?=$ukuran?></td>
                <td><?=$d[3]?></td>
                <td><?=$d[4]?></td>
                <td style="font-weight:bold; text-align:right;">Rp. <?=number_format($d[5], 0, ',', '.')?></td>
                <td><?=($d[12]=='1')?"YES":"NO"?></td>
            </tr>
            <?php
                endwhile;
            ?>
            <tr>
                <td colspan="9" style="padding-top:8px;">
                	<input type="submit" name="submit" value="Delete" style="float:left;"/>
					<span style="float:right;"><?=$halaman_str?></span>
                </td>
            </tr>
		</tbody>
    </table>
    </form>
</div>