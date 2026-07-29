function number2String(nNumber,nDecimals){  
  var n = 0 ;
  var cNumber = "" ;
  var cDigit = "" ;
  var nDigit = 0 ;
  var cRetval = "" ;
  var nLen = 0 ;
  var i = 0 ;
  var cSplit = "" ;
  var nCount = 0 ;

  if (number2String.arguments.length == 1){
    nDecimals = 2 ;
  }  

  nCount = "00000000000000000000000000000" ;
  if (nNumber == ""){
    cRetval = "0" ;
    if(nDecimals > 0) cRetval = cRetval + "." + nCount.substring(0,nDecimals) ;
    return cRetval ;
  }
  nCount = "1" + nCount.substr(0,nDecimals) ;
  nCount = parseFloat(nCount) ;  
  n = Math.round(string2Number(nNumber) * nCount) ;
  n = n / nCount ;  
  cNumber = n.toString() ;  
  nDigit = cNumber.indexOf(".",1) ;
  // Periksa apakah ada Koma Untuk Bilangan tersebut
  if (nDigit < 0){
    if (nDecimals !== 0){
      cDigit = ".00" ;
    }else{
      cDigit = "" ;
    }
  }else{
    cDigit = cNumber.substring(nDigit) ;
    cNumber = cNumber.substring(0,nDigit) ;    
    if (cDigit.length < 3){
      cDigit = cDigit + "0" ;
    }
  }
  cRetval = "" ;
  nLen = cNumber.length ;
  for(i=nLen - 3;i > -3;i -= 3){
    cSplit = cNumber.substring(i,i+3) ;    
    if (cSplit !== ""){
      cRetval =  cSplit + "." + cRetval ;
    }
  }
  cRetval = cRetval.substring(0,cRetval.length -1) ;
  return cRetval + cDigit ;
}

function string2Number(cString){
  var i;
  var cRetval = "";
  var ValidChars = "0123456789" ;
  var cChar = "" ;
  cString = cString.toString() ;
  for(i=0;i<cString.length;i++){
    cChar = cString.charAt(i) ;    
    if (ValidChars.indexOf(cChar) >= 0){
      cRetval = cRetval + cChar ;
    }
  }
  cRetval=parseFloat(cRetval);
  return cRetval;
}
