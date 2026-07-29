            <div id="bodytengah">
            	<div class="label"><?=ucwords($dt['1'])?></div>
				<div class="bigimg">
					<img src="https://www.uterogroup.com/img/imgdetil/<?=$dt['0']?>.pic" alt="<?=$dt['1']?>"/>
				</div>
                <form action="<?=$root?>/order/<?=$dt['0']?>/<?=$dt['9']?>.app" method="post">
				<table border="0" cellpadding="0" cellspacing="1" class="tbspec">
				  <tr class="trhead">
					<td>Ukuran</td>
					<td>Ketebalan</td>
					<td>Minimum Order</td>
					<td>Harga Satuan</td>
				  </tr>
				  <tr class="trow">
					<td><?=$ukuran?></td>
					<td><?=$dt['3']?></td>
					<td><?=$dt['4']?></td>
					<td>
						Rp. <?=number_format($dt[5], 0, ',', '.')?>,- 
						<input type="hidden" id="hrgsatuan" value="<?=$dt[5]?>" />
					</td>
				  </tr>
				</table>				
				<div class="judul">Deskripsi Produk</div>
				<div class="isidesc">
					<?=(trim($dt[6])=="" || trim($dt[6])=="-")?"<span style=\"color:#CCC\">Tidak Ada Keterangan</span>":nl2br($dt[6])?>
				</div>
				<div class="judul">Perhitungan Jumlah Order</div>
				<table border="0" cellpadding="0" cellspacing="1" class="tbspec">
				  <tr class="trtitle" <?=$hidden?>>
					<td>Jumlah Order Dalam <?=$satuan?></td>
					<td>Total Harga Satuan</td>
				  </tr>                          
				  <tr class="trow" <?=$hidden?>>
					<td style="width:50%;">
						<input type="text" name="size" maxlength="11" onkeyup="calcsize(event,'hrgsize',<?=$size[0]?>,<?=$dt['4']?>,<?=$dt[5]?>,'qtyhrgttl')" autocomplete="off"/>
					</td>
					<td style="width:50%;"><input type="text" name="hrgsize" id="hrgsize" value="0" readonly="readonly"/></td>
				  </tr>
				  <!-- lanjut -->
				  <tr class="trtitle">
					<td>Jumlah Order (Quantity)</td>
					<td>Total Harga Keseluruhan</td>
				  </tr>                          
				  <tr class="trow">
					<td style="width:50%;">
						<input type="text" name="qty" maxlength="11" onkeyup="calculate(event,'qtyhrgttl','hrgsize',<?=$dt['4']?>,<?=$dt[5]?>)" autocomplete="off"/>
					</td>
					<td style="width:50%;"><input type="text" name="qtyhrgttl" id="qtyhrgttl" value="0" readonly="readonly"/></td>
				  </tr>           
				</table>
				<span class="lineboth" style="border:none; margin: 16px 0 16px;">
					<!-- <input type="submit" name="submit" value="ORDER NOW"/> -->
					<a href="https://wa.me/6281999900900?text=%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%20%2ASalam%20Merah%2A%20%F0%9F%94%B4%F0%9F%94%B4%F0%9F%94%B4%0ASaya%20dapat%20informasi%20dari%20uterogroup.com%0AMau%20konsultasi%20dong%21%0ANama%20%3A%20%0AAlamat%20%3A%0ANo.%20Telp%20%3A%0AEmail%20%3A%0AKebutuhan%20%3A" name="submit" target="_blank" style="border:1px solid #CCC;	padding:4px; color: #000; background: #e1e1e1; font-size: 14px;">ORDER NOW</a>
				</span>
                </form>
            </div>