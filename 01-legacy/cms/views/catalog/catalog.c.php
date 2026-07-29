<div id="content">
	<!--h2>Entry Product</h2-->
    <div id="contentwrapper">
        <div id="contentcolumn2">
        -kosongan-
        
        </div>
    </div>
    <div id="rightcolumn2">
    	<?=(isset($errmsg))?"<div id=\"errorform2\">".$errmsg."</div>":NULL?>
    	<span class="titleform">Add New Product</span>
        <form method="post" class="cssformright" enctype="multipart/form-data">  
        	<p>
                <label>KATEGORI</label>
                <select name="cat" onchange="javascript:rubah(this)">
                	<option value="<?=NULL?>">Pilih Kategori</option>
                	<?=$cbstr?>
                </select>
            </p>
            
            <p>
            	<label>JENIS PRODUK</label>
            	<span id="divkedua">
                    <select name="jenis" onchange="javascript:rubah(this)">
                        <option value="<?=NULL?>">---</option>
                    </select>
                </span>
            </p>
            
            <p>
            	<label for="nama">NAMA PRODUK</label>
            	<input type="text" name="nama" id="nama" value="<?=(isset($error))?$_POST['nama']:NULL;?>"/>
            </p>
            
            <p>
            	<label for="ukuran">UKURAN</label>
            	<input type="text" name="size" id="ukuran" style="width:30px;" maxlength="3" value="<?=(isset($error))?$_POST['size']:NULL;?>"/>
                <select name="satuan">
                	<option value="-" >-</option>
                    <option value="cm;" >Cm&sup2;</option>
                    <option value="m">M&sup2;</option>
                </select>                
				<span class="info">isi dengan ( - ) jika kosong</span>
            </p>
            
            <p>
            	<label for="tebal">KETEBALAN</label>
            	<input type="text" name="tebal" id="tebal" style="width:70px;" value="<?=(isset($error))?$_POST['tebal']:NULL;?>"/>
				<span class="info">isi dengan ( - ) jika kosong</span>
            </p>
            
            <p>
            	<label for="harga">HARGA SATUAN</label>
                <input type="text" name="harga" id="harga" style="width:150px;" value="<?=(isset($error))?$_POST['harga']:NULL;?>"/>
                <span class="info">isi tanpa titik atau koma</span>
            </p>
            
            <p>
            	<label for="descript">KETERANGAN</label>
                <textarea name="descript" id="descript"><?=(isset($error))?$_POST['descript']:NULL;?></textarea>
            </p>            
            
            <p>
            	<label for="minorder">MINIMUM ORDER</label>
            	<input type="text" name="minorder" id="minorder" style="width:70px;" value="<?=(isset($error))?$_POST['minorder']:NULL;?>"/>
                <span class="info">Jumlah Order Minimum</span>
            </p>
            
			<p>
            	<label for="img">GAMBAR</label>
            	<input type="file" name="img" id="img"/>
            </p>     
			
			<p>
            	<label for="img">PRODUK PROMO</label>
            	<input type="radio" name="promo" value="0" id="tidak"/>TIDAK
            	<input type="radio" name="promo" value="1" id="ya"/>YA
            </p>			                               
            
            <p>
            	<label>&nbsp;</label>
                <input type="submit" name="submit" value="Add Data"  style="text-transform:uppercase; font-size:14px;"/>
            </p>            
        </form>
    </div>
</div>