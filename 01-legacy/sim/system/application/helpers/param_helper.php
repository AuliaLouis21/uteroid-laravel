<?php
if ( ! function_exists('get_parameter')) {
	function get_parameter($param) {
		$ci = & get_instance();
		$totalsegment = $ci->uri->total_segments();
		$resultparam = "";
		for($i=1;$i<=$totalsegment;$i++) {
			if ($ci->uri->segment($i)==$param) {
				$resultparam = $ci->uri->segment($i+1);
				break;
			}
		}
		return $resultparam;
	}
}

if(!function_exists('to_mssql_date')) {
	function to_mssql_date($tanggal) {
		return str_replace("-","/",$tanggal);
	}
}

if(!function_exists('to_mysql_date')) {
	function to_mysql_date($tanggal) {
		$tanggal = explode('/',$tanggal);
		return $tanggal[2].'-'.$tanggal[0].'-'.$tanggal[1];
	}
}

if(!function_exists('to_human_date')) {
	function to_human_date($tanggal) {
		$tanggal = substr($tanggal,0,10);
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli',
			'Agustus','September','Oktober','November','Desember');
		$tanggal = explode("-",$tanggal);
		return $tanggal[2]." ".$bulan[$tanggal[1]-1]." ".$tanggal[0];
	}
}
/* End of file use_param_helper.php */
/* Location: ./system/application/helpers/use_param_helper.php */