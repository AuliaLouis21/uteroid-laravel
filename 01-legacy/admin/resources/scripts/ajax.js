function block_ui(m) {jQuery.blockUI({ message: '<h1 id="block-ui-message" style="font-size:12px">'+ m +'</h1>'}); }
function unblock_ui() {jQuery.unblockUI();}
function ajax_default(_url,_data,_before_send,_success,_error) {
	jQuery.ajax({
		url : _url,
		data : _data,
		type : 'POST',
		beforeSend : function() {if(typeof(_before_send == 'function')) _before_send();},
		success : function(xml) {if(typeof(_success == 'function')) _success(xml); },
		error : function(xml) { if(typeof(_error == 'function')) _error(xml); }
	});
}