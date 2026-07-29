<div id="content">
    <div id="contentwrapper">
        <div id="contentcolumn">
			<div class="detilorder2" id="order2" style="padding-top:0px;">
				<div class="title"><b>Order <?=$dt['10']?>,</b> tgl <?=$dt['7']?> / <?=$dt['8']?></div>
				<p>
					<label>Produk</label>
					<span><?=$dt['10']?></span>
				</p>
				<p>
					<label>harga Satuan</label>
					<span><?=$dt['11']?></span>
				</p>
				<p>
					<label>min. Order</label>
					<span><?=$dt['12']?></span>
				</p>
				<p>
					<label>Jumlah Order</label>
					<span><?=$dt['13']?></span>
				</p>
				<p>
					<label>Harga Total</label>
					<span style="color:#FF0000; font-weight:bold;">
						<blink>&raquo;</blink> Rp. <?=number_format($dt[14], 0, ',', '.')?> <blink>&laquo;</blink
					</span>
				</p>
			</div>
        </div>
    </div>
    <div id="rightcolumn">
		<div class="detilorder2" id="order2" style="padding-top:0px;">
			<div class="title">Alamat Pengiriman</div>
			<p>
				<label>Nama Lengkap</label>
				<span><?=$dt['1']?></span>
			</p>
			<p>
				<label>Email</label>
				<span><?=$dt['2']?></span>
			</p>
			<p>
				<label>No telp</label>
				<span><?=$dt['3']?></span>
			</p>
			<p>
				<label>Alamat Pengiriman</label>
				<span><?=implode(", ",$t)?>. <?=$dt['5']?></span>
			</p>
			<p>
				<label>Pesan Tambahan</label>
				<span><?=ucfirst($dt['6'])?></span>
			</p>
		</div>
		
		<!--h1 style="text-align:right;"><a href="./">Selesai</a></h1-->
    </div>
</div>