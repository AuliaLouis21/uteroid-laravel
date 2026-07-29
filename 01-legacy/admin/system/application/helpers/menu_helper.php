<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('menu_tag')) {
	function menu_tag() {
		return  
				#'<a href="'.base_url().index_page().'/bahanbaku/">BAHAN BAKU</a>'.
				'<a href="'.site_url().'/katalog/">KATALOG</a>'.
			  	/*'<a href="'.site_url().'/transaksi/">TRANSAKSI</a>'.
				'<a href="'.site_url().'/qualitycontrol/">QUALITY CONTROL</a>'.
				'<a href="'.site_url().'/jurnal/">JURNAL</a>'.*/
				'<a href="'.site_url().'/laporan/">LAPORAN</a>'.
				/*'<a href="'.site_url().'/users/">USER</a>'.*/
				'<a href="'.site_url().'/logout/" style="color: rgb(255, 0, 0); letter-spacing: -1px;">LOGOUT</a>';
	}
}

if(!function_exists('menu_non_admin_tag')) {
	function menu_non_admin_tag() {
		return  
				#'<a href="'.base_url().index_page().'/bahanbaku/">BAHAN BAKU</a>'.
				'<a href="'.site_url().'/katalog/">KATALOG</a>'.
			    '<a href="'.site_url().'/transaksi/">TRANSAKSI</a>'.
				//'<a href="'.site_url().'/qualitycontrol/">QUALITY CONTROL</a>'.
				'<a href="'.site_url().'/userreport/">LAPORAN</a>'.
				'<a href="'.site_url().'/logout/" style="color: rgb(255, 0, 0); letter-spacing: -1px;">LOGOUT</a>';
	}
}

if(! function_exists('menu_child_laporan_tag')) {
	function menu_child_laporan_tag() {
		return '<a title="Laporan Nota" href="'.site_url().'/laporan/show/laporan-nota'.'">Laporan Nota</a>
				<a title="Klien Order" href="'.site_url().'/laporan/show/piutang-nota'.'">Piutang Nota</a> 
				<a title="Klien Order" href="'.site_url().'/laporan/show/klien-order'.'">Laporan Klien Order</a> ';
				#<a title="Profit & Loss" href="'.base_url().index_page().'/laporan/show/profit-loss'.'">Profit & Loss</a>';
	}
}

if(!function_exists('menu_qc_tag')) {
	function menu_qc_tag() {
		return '<a title="Quality Control" href="'.site_url().'/qualitycontrol/'.'">Quality Control</a>' .
		 '<a href="'.site_url().'/logout/" style="color: rgb(255, 0, 0); letter-spacing: -1px;">LOGOUT</a>';
	}
}

if(!function_exists('menu_child_transaksi_tag')) {
	function menu_child_transaksi_tag() {
		return '<a title="Transaksi Nota" href="'.site_url().'/transaksinota/">Transaksi Nota</a>' .
			   '<a title="Nota Record" href="'.site_url().'/notarecord/">Nota Record</a>';
			   #'<a title="Pelunasan" href="'.base_url().index_page().'/pelunasan/">Pelunasan</a>' .
			   #'<a title="Cancel Nota" href="'.base_url().index_page().'/cancelnota/">Cancel Nota</a>' ;
			   #'<a title="Pengambilan" href="'.base_url().index_page().'/pengambilan/">Pengambilan</a>' .
			   #'<a title="Penagihan" href="'.base_url().index_page().'/penagihan/">Penagihan</a>';
	}
}

if(!function_exists('menu_child_bahan_baku_tag')) {
	function menu_child_bahan_baku_tag() {
			return '<a title="Transaksi Nota" href="'.site_url().'/bahanbaku/add/">Tambah Bahan Baku</a>';
	}
}

if(!function_exists('menu_child_jurnal_tag')) {
	function menu_child_jurnal_tag() {
		$menu = '<a title="Gl Posting" href="'.site_url().'/jurnal/glposting">GL Posting</a>';
		$menu .= '<a title="Gl Posting" href="'.site_url().'/jurnal/glreport">GL Report</a>';
		return $menu;
	}
}

if(!function_exists('menu_child_laporan_non_admin_tag')) {
	function menu_child_laporan_non_admin_tag() {
		return '<a title="Laporan Nota" href="'.site_url().'/userreport/show/laporan-nota'.'">Laporan Nota</a>
					  <a title="Klien Order" href="'.site_url().'/userreport/show/piutang-nota'.'">Piutang Nota</a>
						<a title="Klien Order" href="'.site_url().'/userreport/show/laporan-klienorder'.'">Laporan Klien Order</a>';
	}
}

if(!function_exists('link_to')) {
	function link_to($title ,$url, $values = null) {
		$attributes = "";
		if(is_array($values)) {
			foreach($values as $key=>$value) {
				$attributes .= $key ."='".$value."' ";
			}
		}
		if($url != '#') $url = site_url() . '/'. $url;
		return label_for("<a href='$url' $attributes>$title</a>");
	}
}

if(!function_exists('label_for')) {
	function label_for($label) {
		return '<label style="font-size:12px">'.$label.'</label>';
	}
} 

if(! function_exists('textbox_tag')) {
	function textbox_tag($values = null) {
		$result = "";
		if($values == null) {
			$result = '<input type="text" class="input input-text"/>';
		}
		else {
			$attribute = "";
			foreach($values as $key => $value) {
				$attribute .= $key . '="' . $value . '" ';
			}
			$result = '<input type="text"' . $attribute . ' class="input input-text" />';
		}
		return $result;
	}
}

if(! function_exists('password_tag')) {
	function password_tag($values = null) {
		$result = "";
		if($values == null) {
			$result = '<input type="password" class="input input-text"/>';
		}
		else {
			$attribute = "";
			foreach($values as $key => $value) {
				$attribute .= $key . '="' . $value . '" ';
			}
			$result = '<input type="password"' . $attribute . ' class="input input-text" />';
		}
		return $result;
	}
}

if(! function_exists('calendar_tag')) {
	function calendar_tag($values = null) {
		$result = "";
		if($values == null) {
			$result = '<input type="text" class="input input-text"/>';
		}
		else {
			$attribute = "";
			foreach($values as $key => $value) {
				$attribute .= $key . '="' . $value . '" ';
			}
			$result = '<input type="text"' . $attribute . ' class="input input-text" style="width:85px;" />';
		}
		return $result;
	}
}

if(! function_exists('select_tag')) {
	function select_tag($values = null,$options = null) {
		$result = '';
		$attribute = '';
		$option = '';
		foreach($values as $key => $value) {
			$attribute .= $key . '="' . $value . '" ';
		}
		foreach($options as $key => $value) {
			$option .= '<option value="' . $key . '">' . $value . '</option>';
		}
		return '<select '.$attribute.'>'.$option.'</select>';
	}
}

if(! function_exists('checkbox_tag')) {
	function checkbox_tag($values = null, $options = null) {
		$result = "";
		$attribute = "";
		foreach($values as $key => $value) {
			$attribute .= $key . '="' . $value . '"';
		}
		foreach($options as $key => $value) {
			$result .= '<input type="checkbox" ' . $attribute . ' value="' . $key . '">' . label_for($value);
		}
		return $result;
	}
}

if(! function_exists('radio_tag')) {
	function radio_tag($values = null,$options=null) {
		$result = "";
		$attribute = "";
		foreach($values as $key => $value) {
			$attribute .= $key . '="' . $value . '"';
		}
		foreach($options as $key => $value) {
			$result .= '<input type="radio" ' . $attribute . ' value="' . $key . '"  id="'.$value.'" />' . label_for($value);
		}
		return $result;
	}
}

if(!function_exists('button_tag')) {
	function button_tag($values = null) {
		$attribute = '';
		$type = " type='button' ";
		foreach($values as $key=>$value) {
			$attribute .= $key.'="'.$value.'" ';
			if(trim($key) == 'type') {
				$type = " type='".$value."' ";
			}
		}
		return '<input ' . $type . $attribute . ' class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" />';
	}
}

if(!function_exists('hidden_tag')) {
	function hidden_tag($values) {
		$attribute = "";
		if($values != null) {
			if(is_array($values)) {
				foreach($values as $key=>$value) {
					$attribute .= $key."='".$value."' ";
				}
			}
		}
		return "<input type='hidden' ".$attribute."/>";
	}
}

if(!function_exists('create_slug')) {
	function create_slug($title) {
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
	}
}

if(!function_exists('textarea_tag')) {
	function textarea_tag($options) {
		$attribute = "";
		if($options != null) {
			if(is_array($options)) {
				foreach($options as $key => $value) {
					$attribute .= $key."='".$value."' ";
				}
			}
		}
		return "<textarea class='input input-text' ".$attribute ."></textarea>";
	}
}

if(!function_exists('simplemodal_tag')) {
	function simplemodal_tag() {
		$result = "";
		$base_url = base_url();
		$result .= "<link type='text/css' media='screen' rel='stylesheet' href='$base_url/resources/simplemodal/css/basic_ie.css'/>";
		$result .= "<link type='text/css' media='screen' rel='stylesheet' href='$base_url/resources/simplemodal/css/basic.css'/>";
		$result .= "<script type='text/javascript' src='$base_url/resources/simplemodal/js/jquery.simplemodal.js'></script>";
		return $result;
	}
}