/* 
	calcsize()
*/

function calcsize(event,hasil,sizeori,minorder,harga,ttlharga){
	var input		=event.target.value;
	var total		=document.getElementById(hasil); //form yg menampilkan hasil perkalian
	var hrgtotal	=document.getElementById(ttlharga); //form yg menampilkan total harga keseluruhan
	var check 		=isNaN(input);
	
	//variable perkalian
	var hargasize 	= Math.ceil((harga / sizeori) * input);
	var hargamin	= sizeori * harga;
	var totalhrg	= number2String(harga * minorder,0);
	var totalhrg2	= number2String(hargasize * minorder,0);
	
	if(check){
		total.value = "Harus Angka";
		exit;
	}
	else if(input == '' || input < '1' || input == '0'){
		total.value = number2String(harga,0);
		hrgtotal.value	= totalhrg;
	}	
	else if(input < sizeori || input == sizeori){
		total.value 	= number2String(harga,0);
		hrgtotal.value	= totalhrg;
	}
	else if(input > sizeori){
		total.value 	= number2String(hargasize,0);
		hrgtotal.value	= totalhrg2;
	}
}

function calculate(event,hasil,hargasize,minorder,harga){
	var input		=event.target.value;
	var total		=document.getElementById(hasil);
	var sizehrg		=document.getElementById(hargasize).value;
	var sizehrg		=string2Number(sizehrg);
	var check 		=isNaN(input);
	
	//variable perkalian jika tanpa size
	var hargamin	= number2String(harga * minorder,0);
	var hargakali	= number2String(harga * input,0);
	var hargatotmin	= Math.ceil(sizehrg * minorder);
	var hargatot 	= Math.ceil(sizehrg * input);
	
	if(check){
		//hasil.value = qty + " bukan angka";
		total.value = "Harus Angka";
		exit;
	}
	
	if(sizehrg > 0){
		if(input=='' || input==0 || input < 1){
			total.value = number2String(hargatotmin,0);
		}
		else if(input == minorder){
			total.value = number2String(hargatotmin,0);
		}
		else if(input < minorder){
			total.value = number2String(hargatotmin,0);
		}		
		else if(input > minorder){
			total.value = number2String(hargatot,0); 
		}
	}
	
	if(sizehrg == 0 || sizehrg == ''){
		if(input=='' || input==0 || input < 1){
			total.value = hargamin;
		}
		else if(input==minorder){
			total.value = hargamin;
		}
		else if(input<minorder){
			total.value = hargamin;
		}		
		else if(input>minorder){
			total.value = hargakali;
		}		
	}
}


/*
function hitung(size,qty,total,minorder,ttlharga){
	//var size	= event.target.value;
	var size	= document.getElementById(size).value;
	var jumlah	= document.getElementById(qty).value;
	var hasil	= document.getElementById(total);
	
	var ceksize = isNaN(size);
	var cekjumlah = isNaN(size);
	
	if(cekjumlah || ceksize){
		hasil.value = "Rp. 0 ";
		exit;
	}
	
	//variable perkalian
	var hargatotal	= jumlah * ttlharga;
	var hargamin	= minorder * ttlharga;
	
	if(size==null || size < '0'){
		hasil.value = "Rp. 0 ";
	}
	else if (size > '0'){
		hasil.value = hargamin;
	}
	
	if(jumlah==null || jumlah < '0'){
		hasil.value = "Rp. 0 ";
	}
	else if(jumlah == minorder){
		hasil.value = "Rp. "+hargamin;
	}
	else if(jumlah < minorder){
		hasil.value = "Rp. "+hargamin;
	}
	else if(jumlah > minorder){
		hasil.value = "Rp. "+hargatotal;
	}	
}
*/