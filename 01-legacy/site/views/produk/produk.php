            <div id="bodytengah" style="height:890px;overflow-x: hidden; position: relative;">
                <div style="display:block; clear:both; margin-bottom:10px; padding:8px!important; background-color:#333; 				-moz-border-radius: 4px; border-radius: 4px;">
                    <form name="search" method="post" action="<?=$root?>/produk.app">
                        <select name="cat" onchange="javascript:rubah(this)">
                        <option value="null">Pilih Kategori</option>
                        <?=$cbstr?>
                        </select>
                        <span id="divkedua">
                            <select name="jenis" onchange="javascript:rubah(this)">
                                <option value="<?=NULL?>">---</option>
                            </select>
                        </span>				
                        <span style="display:block; margin-top:8px;">
                            <input type="text" name="src" style="width:250px;"/>
                            <input type="submit" name="cari" value="CARI" />
                        </span>                    
                    </form>
                </div>
                
                <table border="0" cellpadding="0" cellspacing="1" class="tbspec" style="border:1px solid #EBF5FE;">
                    <tr class="trhead">
                        <td style="width:36px;">&nbsp;</td>
                        <td style="width:180px;">Nama Produk</td>
                        <td>Min. Order</td>
                        <td style="width:90px;">Harga Satuan</td>
                    </tr>
                    <?php 
                        echo (isset($empty))?"<tr><td colspan=\"5\"><span class=\"empty\">$empty</span></td></tr>":NULL;
                        while($dtr = mysqli_fetch_array($qlr)):
                        $i++;
                        $bg=(($i%2)==0)?"background-color:#EBF5FE;":"background-color:#F4FAFF;";
                    ?>               
                    <tr class="rowz" style="<?=$bg?>">
                        <td style="text-align:center;">
                        <img src="https://www.uterogroup.com/img/imgcropkecil/<?=$dtr['0']?>.pic"  alt="<?=$dtr[1]?>" style="<?=$imgcss?>"/>
                        </td>
                        <td style="font-size:10px;">
                            <a href="<?=$root?>/produk/<?=$dtr[9]?>.app" title="<?=$dtr[1]?>"><?=ucwords($dtr[1])?></a>
                        </td>
                        <td style="text-align:center;"><?=$dtr[4]?></td>
                        <td style="text-align:right; font-size:10px;">Rp. <?=number_format($dtr[5], 0, ',', '.')?></td>
                    <?php endwhile; ?>
                </table>
                <span class="lineboth"><?=$halaman_str?></span>
		</div>