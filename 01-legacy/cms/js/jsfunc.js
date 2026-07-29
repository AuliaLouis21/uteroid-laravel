/* 
	JavaScript Document
	By Rio Adetya Rizky
	rio@teknoku.com
	+6285 649 500 774
*/

function out(root){
	var y = confirm('klik OK jika yakin ingin logout');
	if(y){
		alert('yuk dadah.. bye bye...');
		document.location.href=root+'/adm/out.jsp';
	}else{
		return false;
	}
}