<script type='text/javascript'>
	function hitung() {
		var total = document.getElementById('total');
		var biaya_tambahan = document.getElementById('biaya_tambahan');
		var jumlah_tagihan = document.getElementById('jumlah_tagihan');
		var sisa_tagihan = document.getElementById('sisa_tagihan');
		
		var prosentase = document.getElementById('prosentase');
		var jumlah_uang = document.getElementById('jumlah_uang');
		
		var total_harga = 0;
		var total_biaya_tambahan = 0;
		var total_jumlah_tagihan = 0;
		var total_sisa_tagihan = 0;
		
		var diskon_persen = 0;
		var diskon_harga = 0;
		
		var pakai_diskon_persen = false;
		
		if(total.value != "") {
			if(!isNaN(String2Number(total.value))) {
				total_harga = String2Number(total.value);
			}
		}
		
		if(biaya_tambahan.value != "") {
			if(!isNaN(biaya_tambahan.value)) {
				total_biaya_tambahan = parseFloat(biaya_tambahan.value);
			}
			if(!isNaN(String2Number(biaya_tambahan.value))) {
				total_biaya_tambahan = String2Number(biaya_tambahan.value);
			}
		}
		
		if(prosentase.value != "") {
			if(prosentase.value != "0") {
				if(!isNaN(prosentase.value)) {
					diskon_persen = parseFloat(prosentase.value);
					jumlah_uang.value = diskon_persen;
					pakai_diskon_persen = true;
					jumlah_uang.value = "";
				}
				if(!isNaN(String2Number(prosentase.value))){
					diskon_persen = String2Number(prosentase.value);
					jumlah_uang.value = diskon_persen;
					pakai_diskon_persen = true;
					jumlah_uang.value = "";
				}
			}
		}
		
		if(jumlah_uang.value != "") {
			if(!isNaN(jumlah_uang.value)) {
				diskon_harga = parseFloat(jumlah_uang.value);
				pakai_diskon_harga = false;
				prosentase.value = "";
			}
		}
		
		total_jumlah_tagihan = total_harga + total_biaya_tambahan;
		if(pakai_diskon_persen == true) {
			var _diskon_persen = (total_jumlah_tagihan /100) * diskon_persen;
			jumlah_tagihan.value = Number2String(_diskon_persen);
			sisa_tagihan.value = Number2String(total_jumlah_tagihan - _diskon_persen);
		}
		else {		 
			 if(diskon_harga != 0) {
				jumlah_tagihan.value = Number2String(diskon_harga);
				sisa_tagihan.value = Number2String(total_jumlah_tagihan - diskon_harga);
			 }
			 else {
				jumlah_tagihan.value = Number2String(total_jumlah_tagihan);
				sisa_tagihan.value = Number2String(0);
			 }
			 
		}
	}
</script>