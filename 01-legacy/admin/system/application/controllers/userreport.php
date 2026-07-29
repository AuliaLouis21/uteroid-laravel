<?
	class UserReport extends Controller {
		private $paymentQuery = "select 
						SC.nama as sales,SK.nama as klien,SP.no_id as no,SC.*,SP.*,SK.* 
					from 
						sim_pembayaran SP 
					left 
						outer join sim_salescounter SC on SP.sales_no=SC.no_id 
					left 
						outer join sim_client SK on SP.klien_no=SK.no_id";
		private $total_uang_muka 	= 0;
		private $total_jumlah			= 0;
		private $button_parameter = "";
						
		function UserReport() {
			parent::Controller();
			$this->total_uang_muka = 0;
			$this->total_jumlah = 0;
		}
		
		function index() {
			$data['user'] = $this->session->userdata('users');
			$this->load->view('userreport/index',$data);
		}	
		
		function show($par = "") {
			if($par != "") {
				$data['user'] = $this->session->userdata('users');
				$data['user_code'] = $this->session->userdata('users_code');
				$this->load->view('userreport/'.$par,$data);
			}
		}
		
		function preview_nota() {
			if($_SERVER['REQUEST_METHOD'] != 'POST') {
				die('restricted access');
			}
			$sales = $this->db->escape(trim($this->session->userdata('users_code')));
			$action = trim($this->input->post('action'));
			$button_parameter = "";
			switch($action) {
				case "nota":
					$nota = trim($this->input->post('nonota'));
					$button_parameter = "action/nota/nonota/$nota";
					$nota = $this->db->escape($nota);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where nota = $nota and SS.no_id = $sales order by nota";
					$query = $this->db->query($sql);
					$this->load->view('userreport/service-template-nota',array('query'=>$query,'i'=>0,'uangmuka'=>0,'total'=>0,'kekurangan'=>0,'button_parameter'=>$button_parameter));
					break;
				case "tanggal-terima":
					$button_parameter = "action/tanggal-terima/tanggalterima/".$this->_to_normal_date(trim($this->input->post('tanggal-terima')));
					$tanggal_terima = trim($this->input->post('tanggal-terima'));
					$tanggal_terima = $this->db->escape(to_mysql_date($tanggal_terima));
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima = $tanggal_terima and SS.no_id = $sales order by nota";
					$query = $this->db->query($sql);
					$this->load->view('userreport/service-template-nota',array('query'=>$query,'i'=>0,'uangmuka'=>0,'total'=>0,'kekurangan'=>0,'button_parameter'=>$button_parameter));
					break;
				case "tanggal-awal-akhir":
					$tanggal_awal = to_mysqL_date(trim($this->input->post('tanggal-awal')));
					$tanggal_akhir = to_mysql_date(trim($this->input->post('tanggal-akhir')));
					$button_parameter = "action/tanggal-awal-akhir/tanggalawal/"
						.$this->_to_normal_date($tanggal_awal)."/tanggalakhir/".$this->_to_normal_date($tanggal_akhir);
					$tanggal_awal = $this->db->escape($tanggal_awal);
					$tanggal_akhir = $this->db->escape($tanggal_akhir);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima between $tanggal_awal and $tanggal_akhir and SS.no_id = $sales order by nota";
					$query = $this->db->query($sql);
					$this->load->view('userreport/service-template-nota',array('query'=>$query,'i'=>0,'uangmuka'=>0,'total'=>0,'kekurangan'=>0,'button_parameter'=>$button_parameter));
					break;
				case "tanggal-sekarang":
					$button_parameter = "action/tanggal-sekarang";
					$tanggal_sekarang = date('Y-m-d');
					$tanggal_sekarang = $this->db->escape($tanggal_sekarang);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima = $tanggal_sekarang and SS.no_id = $sales order by nota";
					$query = $this->db->query($sql);
					$this->load->view('userreport/service-template-klien',array('query'=>$query,'i'=>0,'uangmuka'=>0,'total'=>0,'kekurangan'=>0,'button_parameter'=>$button_parameter));
					break;
			}
		}
		
		function preview_klienorder() {
			if($_SERVER["REQUEST_METHOD"] != "POST") {
				die("restricted access");
			}
			
			$action = trim($this->input->post("action"));
			$sales = $this->db->escape($this->session->userdata("users_code"));
			
			switch($action) {
				case "nota" :
					$nota = trim($this->input->post("nonota"));
					$button_parameter = "action/$action/nonota/$nota";
					$nota = $this->db->escape($nota);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										nota = $nota and sales = $sales order by SO.tgl_terima,nota";
					$query = $this->db->query($sql);
					$this->load->view("userreport/service-template-klienorder",array("query"=>$query,"i"=>0,"total"=>0,"button_parameter"=>$button_parameter));
					break;
				
				case "tanggal-sekarang" :
					$tanggal_sekarang = date("Y-m-d");
					$button_parameter = "action/$action/tanggal-sekarang/$tanggal_sekarang";
					$tanggal_sekarang = $this->db->escape($tanggal_sekarang);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima = $tanggal_sekarang and sales = $sales order by SO.tgl_terima,nota";
					$query = $this->db->query($sql);
					$this->load->view("userreport/service-template-klienorder",array("query"=>$query,"i"=>0,"total"=>0,"button_parameter"=>$button_parameter));
					break;
					
				case "tanggal-terima" :
					$tanggal_terima = to_mysql_date(trim($this->input->post("tanggal-terima")));
					$button_parameter = "action/$action/tanggalterima/$tanggal_terima";
					$tanggal_terima = $this->db->escape($tanggal_terima);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima = $tanggal_terima and sales = $sales order by SO.tgl_terima,nota";
					$query = $this->db->query($sql);
					$this->load->view("userreport/service-template-klienorder",array("query"=>$query,"i"=>0,"total"=>0,"button_parameter"=>$button_parameter));
					break;
			
				case "tanggal-awal-akhir" :
					$tanggal_awal = to_mysql_date(trim($this->input->post("tanggal-awal")));
					$tanggal_akhir = to_mysql_date(trim($this->input->post("tanggal-akhir")));
					$button_parameter = "action/$action/tanggal-awal/$tanggal_awal/tanggal-akhir/$tanggal_akhir";
					$tanggal_awal = $this->db->escape($tanggal_awal);
					$tanggal_akhir = $this->db->escape($tanggal_akhir);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima between $tanggal_awal and $tanggal_akhir and sales = $sales order by SO.tgl_terima,nota";
					$query = $this->db->query($sql);
					$this->load->view("userreport/service-template-klienorder",array("query"=>$query,"i"=>0,"total"=>0,"button_parameter"=>$button_parameter));
					break;
			}
		}	
		
		function preview() {
			$_nota = trim($this->input->post('nota'));
			$_sc = trim($this->input->post('sc'));
			$action = $this->input->post('action');
			$sc = $this->db->escape(trim($this->input->post('sc')));
			$tanggal_awal = trim($this->input->post('tglawal'));
			$tanggal_akhir = trim($this->input->post('tglakhir'));
			$tanggal_terima = trim($this->input->post('tanggalterima'));
			
			$_tanggal_awal = "";$_tanggal_akhir="";$_tanggal_terima="";
			
			#ini terkena format tanggal mssql sialan , ubah ke tanggal format tanggal mysql
			
			if($tanggal_awal != "") {
				$_tanggal_awal = $this->db->escape(to_mysql_date($tanggal_awal));
				$tanggal_awal = to_mysql_date($tanggal_awal);
			}
			if($tanggal_akhir != "") {
				$_tanggal_akhir = $this->db->escape(to_mysql_date($tanggal_akhir));
				$tanggal_akhir = to_mysql_date($tanggal_akhir);
			}
			if($tanggal_terima != "") {
				$_tanggal_terima = $this->db->escape(to_mysql_date($tanggal_terima));
				$tanggal_terima = to_mysql_date($tanggal_terima);
			}
				
			$nota = $this->db->escape(trim($this->input->post('nota')));
			$data['total_uang_muka'] 	= 0;
			$data['total_jumlah']		 	= 0;
			$data['i']								= 0;
			switch($action) {
				case 'tanggal-sekarang' :
					$tanggal = date('Y-m-d');
					$sql = "select 
								sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
								sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
						from
								sim_salescounter,sim_nota_order
						where
								sim_nota_order.tgl_terima = '$tanggal' and
								sim_nota_order.sales = $sc and
								sim_salescounter.no_id = sim_nota_order.sales;";
								
					$this->paymentQuery .= " where sales_no=$sc and tanggal= '" . $tanggal . "' order by nota";
					$this->button_parameter = "action/tanggal-sekarang/sc/$_sc/tanggal/$tanggal";
					$data['query'] 				= $this->db->query($sql);
					$data['payment_sql'] 	= $this->paymentQuery;
					$data['button_parameter'] = $this->button_parameter;
					$this->load->view('userreport/service-template',$data);
					break;
					
				case "tanggal-awal-akhir":
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima between $_tanggal_awal and $_tanggal_akhir and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
						
					$this->button_parameter = "action/tanggal-awal-akhir/sc/$_sc/tanggalawal/$tanggal_awal/tanggalakhir/$tanggal_akhir";
					$this->paymentQuery .= " where sales_no=$sc and tanggal between $_tanggal_awal and $_tanggal_akhir order by nota;";
					$data['query'] = $this->db->query($sql);
					$data['payment_sql'] = $this->paymentQuery;
					$data['button_parameter'] = $this->button_parameter;
					$this->load->view('userreport/service-template',$data);
					break;
				case "tanggal-terima" :
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima = $_tanggal_terima and sim_nota_order.sales = $sc and 				
						sim_salescounter.no_id = sim_nota_order.sales order by nota;";
					$this->button_parameter = "action/tanggal-terima/sc/$_sc/tanggalterima/$tanggal_terima";
					$this->paymentQuery .= " where sales_no=$sc and tanggal=$_tanggal_terima order by nota";
					$data['query'] = $this->db->query($sql);
					$data['payment_sql'] = $this->paymentQuery;
					$data['button_parameter'] = $this->button_parameter;
					$this->load->view('userreport/service-template',$data);
					break;
				case "nota" :
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.nota = $nota and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
					$this->button_parameter = "action/nota/$_nota/sc/$_sc";
					$this->paymentQuery .= " where nota=$nota and SC.no_id = $sc order by nota";
					$data['query'] = $this->db->query($sql);
					$data['payment_sql'] = $this->paymentQuery;
					$data['button_parameter'] = $this->button_parameter;
					$this->load->view('userreport/service-template',$data);
					//echo $sql;
					break;
			}
		}
	
		function cetak_klien() {
			$action = trim(get_parameter('action'));
			$sc_name = $this->_get_sc_name_from_session();
			$sc = $this->session->userdata('users_code');
			switch($action) {
				case "nota" :
					$nota = trim(get_parameter('nonota'));
					$keterangan = "Nomor Nota : $nota"; 
					$nota = $this->db->escape($nota);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where nota = $nota and SS.no_id = $sc order by nota";
					$this->_cetak_pdf_klien($sql,$keterangan,$sc_name);
					break;
				
				case "tanggal-sekarang":
					$tanggal_sekarang = date('Y-m-d');
					$keterangan = "Tanggal : $tanggal_sekarang"; 
					$tanggal_sekarang = $this->db->escape($tanggal_sekarang);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima = $tanggal_sekarang and SS.no_id = $sc order by nota";
					$this->_cetak_pdf_klien($sql,$keterangan,$sc_name);
					break;
				
				case "tanggal-terima" :
					$tanggal_terima = trim(get_parameter('tanggalterima'));
					$keterangan = "Tanggal Terima : $tanggal_terima";
					$tanggal_terima = explode("-",$tanggal_terima);
					$tanggal_terima = $tanggal_terima[2]."-".$tanggal_terima[0]."-".$tanggal_terima[1];
					$tanggal_terima = $this->db->escape($tanggal_terima);
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima = $tanggal_terima and SS.no_id = $sc order by nota";
					$this->_cetak_pdf_klien($sql,$keterangan,$sc_name);
					break;
				
				case "tanggal-awal-akhir" :
					$tanggal_awal = trim(get_parameter('tanggalawal'));
					$tanggal_akhir = trim(get_parameter('tanggalakhir'));
					$tanggal_awal = $this->db->escape($tanggal_awal);
					$tanggal_akhir = $this->db->escape($tanggal_akhir);
					$keterangan = "Tanggal $tanggal_awal S/D $tanggal_akhir";
					
					$sql = "select 
										SO.no_id as NoNota,SS.nama as sale,SC.nama as klie,SO.*,SS.*,SC.* 
									from 
										sim_nota_order SO left outer join sim_client SC on SO.klien=SC.no_id 
										left outer join sim_salescounter SS on SO.sales=SS.no_id 
									where tgl_terima between $tanggal_awal and $tanggal_akhir and SS.no_id = $sc order by nota";
					$this->_cetak_pdf_klien($sql,$keterangan,$sc_name);
					break;
			}
		}
		
		function cetak_klienorder() {
			$action = trim(get_parameter('action'));
			$sc_name = $this->_get_sc_name_from_session();
			$sales = $this->session->userdata('users_code');
			
			switch($action) {
				case "nota" :
					$nota = trim(get_parameter("nonota"));
					$keterangan = "Nomor Nota : $nota"; 
					$nota = $this->db->escape($nota);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										nota = $nota and sales = $sales order by SO.tgl_terima,nota";
					$this->_cetak_pdf_klien_order($sql,$keterangan,$sc_name);
					break;
					
				case "tanggal-sekarang" :
					$tanggal_sekarang = date('Y-m-d');
					$keterangan = "Tanggal : $tanggal_sekarang"; 
					$tanggal_sekarang = $this->db->escape($tanggal_sekarang);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima = $tanggal_sekarang and sales = $sales order by SO.tgl_terima,nota";
					$this->_cetak_pdf_klien_order($sql,$keterangan,$sc_name);
					break;
				
				case "tanggal-terima" :
					$tanggal_terima = trim(get_parameter('tanggalterima'));
					$keterangan = "Tanggal Terima : $tanggal_terima"; 
					$tanggal_terima = $this->db->escape($tanggal_terima);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima = $tanggal_terima and sales = $sales order by SO.tgl_terima,nota";
					$this->_cetak_pdf_klien_order($sql,$keterangan,$sc_name);
					break;
					
				case "tanggal-awal-akhir" :
					$tanggal_awal = trim(get_parameter('tanggal-awal'));
					$tanggal_akhir = trim(get_parameter('tanggal-akhir'));
					$keterangan = "Tanggal $tanggal_awal S/D $tanggal_akhir"; 
					$tanggal_awal = $this->db->escape($tanggal_awal);
					$tanggal_akhir = $this->db->escape($tanggal_akhir);
					$sql = "select 
										SO.no_id as NoNota,SC.nama as jeneng,SP.nama as nama_produk,SO.*,SD.*,SP.*,SC.* 
									from 
										sim_nota_order SO 
									left outer join sim_nota_order_detail SD on SO.no_id=SD.no_nota 
									left outer join sim_produk SP on SD.no_produk=SP.no_id 
									left outer join sim_client SC on SO.klien=SC.no_id 
									where 
										SO.tgl_terima between $tanggal_awal and $tanggal_akhir and sales = $sales order by SO.tgl_terima,nota";
					$this->_cetak_pdf_klien_order($sql,$keterangan,$sc_name);
					break;
			}
		}
		
		function cetak() {
			$action = get_parameter("action");
			$sc = get_parameter("sc");
			$tanggal_awal = get_parameter("tanggalawal");
			$tanggal_akhir = get_parameter("tanggalakhir");
			$tanggal_terima = get_parameter("tanggalterima");
			$nota = get_parameter("nota");
			$row = $this->db->query("select user_name from sim_user where no_user = $sc")->row_array();
			$sc_name = $row['user_name'];
			switch($action) {
				case "tanggal-awal-akhir": 
					$keterangan = $this->_get_formatted_date($tanggal_awal) . " S/D " . $this->_get_formatted_date($tanggal_akhir);
					$tanggal_awal = $this->db->escape($tanggal_awal);
					$tanggal_akhir = $this->db->escape($tanggal_akhir);
					
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima between $tanggal_awal and $tanggal_akhir and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
					$sql_payment = $this->paymentQuery . " where sales_no=$sc and tanggal between $tanggal_awal and $tanggal_akhir order by nota;";
					
					$this->_cetak_pdf($sql,$sql_payment,$keterangan,$sc_name);
					break;
				case "tanggal-terima" :
					$keterangan = 'Tanggal Terima : ' . $this->_get_formatted_date($tanggal_terima);
					$tanggal_terima = to_mssql_date($tanggal_terima);
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima = '$tanggal_terima' and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
					$sql_payment = $this->paymentQuery . " where sales_no=$sc and tanggal = '$tanggal_terima' order by nota;";
					$this->_cetak_pdf($sql,$sql_payment,$keterangan,$sc_name);
					break;
				case "tanggal-sekarang" :
					$tanggal_sekarang = date('Y-m-d');
					$keterangan = 'Tanggal Sekarang : ' . $this->_get_formatted_date($tanggal_sekarang);
					$tanggal_sekarang = $this->db->escape($tanggal_sekarang);
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota'as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.tgl_terima = $tanggal_sekarang and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
					$sql_payment = $this->paymentQuery . " where sales_no=$sc and tanggal = $tanggal_sekarang order by nota;";
					$this->_cetak_pdf($sql,$sql_payment,$keterangan,$sc_name);
					break;
				case "nota":
					$keterangan = 'Nomor Nota : ' . $nota;
					$sql = "select 
						sim_nota_order.tgl_terima,sim_nota_order.nota, sim_nota_order.jumlah_uangmuka,sim_nota_order.total,
						sim_salescounter.nama,'Transaksi Nota' as 'Keterangan',sim_nota_order.card
					from
						sim_salescounter,sim_nota_order
					where
						sim_nota_order.nota = $nota and sim_nota_order.sales = $sc and 								
						sim_salescounter.no_id = sim_nota_order.sales order by nota";
					$sql_payment = $this->paymentQuery . " where nota=$nota and SC.no_id = $sc order by nota";
					$this->_cetak_pdf($sql,$sql_payment,$keterangan,$sc_name);
					break;
			}
		}
		
		private function _cetak_pdf($sql,$sql_payment,$keterangan,$sc_name) {
			require("lib/fpdf/fpdf.php");
			$line_margin = 10;
			$no = 0;
			$last_line = 0;
			$pdf = new FPDF('P','pt','A4');
			$pdf->Open();
			$pdf->addPage();
			
			/* header */
			$pdf->Image('resources/images/utero.jpg',30,15,70,70,'jpg');
			$pdf->Image('resources/images/logo-utero.jpg',100,15,155,70,'jpg');
			
			$pdf->setFont("ARIAL",'B',13);
			$pdf->text(260,50,"LAPORAN NOTA SALES ::: " .$sc_name);
			
			$pdf->setFont("ARIAL",'B',6);
			$pdf->text(285,60,$keterangan);
			$pdf->text(485,77,"PRINT DATE : " . strftime("%d-%m-%Y %H:%M"));
			
			$pdf->Line(30,90,575,90);
			$pdf->setLineWidth(1);
			$pdf->Line(30,92,575,92);
			$pdf->setLineWidth(0);
			$pdf->Line(30,95,575,95);
			
			$pdf->setFont("ARIAL","B",8);
			$pdf->text(40,105,"No");
			$pdf->text(80,105,"Nota");
			$pdf->text(140,105,"Tanggal");
			$pdf->text(220,105,"Uang Muka");
			$pdf->text(320,105,"Jumlah");
			$pdf->text(400,105,"Keterangan");
			$pdf->text(510,105,"Status");
			$pdf->Line(30,110,575,110);
			$pdf->setFont("ARIAL",'',6);
			$last_line = 120;
			
			$query = $this->db->query($sql);
			foreach($query->result_array() as $row) {
				$pdf->text(42,$last_line,++$no);
				$pdf->text(80,$last_line,$row['nota']);
				$pdf->text(135,$last_line,to_human_date($row['tgl_terima']));
				$pdf->text(220,$last_line,number_format($row['jumlah_uangmuka'],2,',','.'));
				$pdf->text(320,$last_line,number_format($row['total'],2,',','.'));
				$pdf->text(400,$last_line,$row['Keterangan']);
				$pdf->text(510,$last_line,(trim($row['card']) == '' ? "Tunai" : $row['card']));
				$this->total_uang_muka += $row['jumlah_uangmuka'];
				$this->total_jumlah += $row['total'];
				if($last_line > 810) {
					$last_line = 30;
					$pdf->AddPage();
					$pdf->Line(30,10,575,10);
					$pdf->setFont("ARIAL",'B',8);
					$pdf->text(40,20,"No");
					$pdf->text(80,20,"Nota");
					$pdf->text(140,20,"Tanggal");
					$pdf->text(220,20,"Uang Muka");
					$pdf->text(320,20,"Jumlah");
					$pdf->text(400,20,"Keterangan");
					$pdf->text(510,20,"Status");
					$pdf->Line(30,25,575,25);
					$pdf->setFont("ARIAL",'',6);
				}
				$last_line += $line_margin;
			}
			$query->free_result();
			
			$query = $this->db->query($sql_payment);
			foreach($query->result_array() as $row) {
				if($last_line > 810) {
					$last_line = 30;
					$pdf->AddPage();
					$pdf->Line(30,10,575,10);
					$pdf->setFont("ARIAL",'B',8);
					$pdf->text(40,20,"No");
					$pdf->text(80,20,"Nota");
					$pdf->text(140,20,"Tanggal");
					$pdf->text(220,20,"Uang Muka");
					$pdf->text(320,20,"Jumlah");
					$pdf->text(400,20,"Keterangan");
					$pdf->text(510,20,"Status");
					$pdf->Line(30,25,575,25);
					$pdf->setFont("ARIAL",'',6);
				}
				
					$pdf->text(42,$last_line,++$no);
					$pdf->text(80,$last_line,$row['nota']);
					$pdf->text(135,$last_line,to_human_date($row['tanggal']));
					$pdf->text(220,$last_line,number_format($row['dibayar'],2,',','.'));
					$pdf->text(320,$last_line,number_format(0,2,',','.'));
					$pdf->text(400,$last_line,'Pelunasan');
					$pdf->text(510,$last_line,(trim($row['card']) == '' ? "Tunai" : $row['card']));
					$this->total_uang_muka += $row['dibayar'];
					$this->total_jumlah += 0;
				$last_line += $line_margin;
			}
			$query->free_result();

			$pdf->line(30,$last_line,575,$last_line);
			$pdf->setFont("ARIAL","B",8);
			$pdf->text(140,$last_line + 10,'Total : ');
			$pdf->text(220,$last_line + 10,number_format($this->total_uang_muka,2,',','.'));
			$pdf->text(320,$last_line + 10,number_format($this->total_jumlah,2,',','.'));
			$pdf->line(30,$last_line + 15,575,$last_line + 15);
			
			$pdf->output();
		}
		
		private function _cetak_pdf_klien($sql,$keterangan,$sc_name) {
			require("lib/fpdf/fpdf.php");
			$total = 0;
			$dibayar = 0;
			$uangmuka = 0;
			$kekurangan = 0;
			$line_margin = 10;
			$no = 0;
			$last_line = 0;
			$pdf = new FPDF('P','pt','A4');
			$pdf->Open();
			$pdf->addPage();
			
			/* header */
			$pdf->Image('resources/images/utero.jpg',30,15,70,70,'jpg');
			$pdf->Image('resources/images/logo-utero.jpg',100,15,155,70,'jpg');
			
			$pdf->setFont("ARIAL",'B',13);
			$pdf->text(260,50,"LAPORAN PIUTANG KLIEN SALES ::: " .$sc_name);
			
			$pdf->setFont("ARIAL",'B',6);
			$pdf->text(285,60,$keterangan);
			$pdf->text(485,77,"PRINT DATE : " . strftime("%d-%m-%Y %H:%M"));
			
			$pdf->Line(30,90,575,90);
			$pdf->setLineWidth(1);
			$pdf->Line(30,92,575,92);
			$pdf->setLineWidth(0);
			$pdf->Line(30,95,575,95);
			
			$pdf->setFont("ARIAL","B",8);
			$pdf->text(40,105,"No");
			$pdf->text(60,105,"Nota");
			$pdf->text(100,105,"Tanggal");
			$pdf->text(150,105,"Nama");
			$pdf->text(260,105,"Total");
			$pdf->text(340,105,"Dibayar");
			$pdf->text(420,105,"Kekurangan");
			$pdf->text(500,105,"Status");
			$pdf->Line(30,110,575,110);
			$pdf->setFont("ARIAL",'',6);
			$last_line = 120;
			
			$query = $this->db->query($sql);
			foreach($query->result_array() as $row) {
				$pdf->text(42,$last_line,++$no);
				$pdf->text(60,$last_line,$row['nota']);
				$pdf->text(95,$last_line,to_human_date($row['tgl_terima']));
				$pdf->text(150,$last_line,$row['klie']);
				$pdf->text(260,$last_line,number_format($row['total'],2,',','.'));
				
				$other_query = $this->db->query("select sum(dibayar) as dibayar from sim_pembayaran where no_nota='".$row['NoNota']."'");
				if($other_query->num_rows()!=0) { 
					$other_row = $other_query->row_array();
					$dibayar = $other_row['dibayar'];
					$uangmuka += $row['jumlah_tagihan'] + $dibayar;
					$pdf->text(340,$last_line,number_format($row['jumlah_tagihan'] + $dibayar,2,',','.')); # ini buat kolom dibayar
					$other_query->free_result();
				}
				else {
					$uangmuka += $row['jumlah_tagihan'];
					$pdf->text(340,$last_line,number_format($row['jumlah_tagihan'],2,',','.')); # ini buat kolom dibayar
				}
				$pdf->text(420,$last_line,number_format($row['sisa'],2,',','.')); # ini buat kolom kekurangan
				
				$query_status = $this->db->query("select status from sim_slip_order_nota where nota=".$this->db->escape($row['nota']));
				if($query_status->num_rows() != 0) {
					$row_status = $query_status->row_array();
						$pdf->text(490,$last_line,$row_status['status']);
					$query_status->free_result();
				}
				else {
					$pdf->text(490,$last_line,'-');
				}
				
				$total += $row['total'];
				
				if($last_line > 810) {
					$last_line = 30;
					$pdf->AddPage();
					$pdf->Line(30,10,575,10);
					$pdf->setFont("ARIAL",'B',8);
					$pdf->text(40,20,"No");
					$pdf->text(60,20,"Nota");
					$pdf->text(100,20,"Tanggal");
					$pdf->text(150,20,"Nama");
					$pdf->text(260,20,"Total");
					$pdf->text(340,20,"Dibayar");
					$pdf->text(420,20,"Kekurangan");
					$pdf->text(500,20,"Status");
					$pdf->Line(30,25,575,25);
					$pdf->setFont("ARIAL",'',6);
				}
				$last_line += $line_margin;
			}
			$query->free_result();
			$kekurangan = $total - $uangmuka;
			
			$pdf->line(30,$last_line,575,$last_line);
			$pdf->setFont("ARIAL","B",8);
			$pdf->text(140,$last_line + 10,'Total');
			$pdf->text(260,$last_line + 10,number_format($total,2,',','.'));
			$pdf->text(340,$last_line + 10,number_format($uangmuka,2,',','.'));
			$pdf->text(420,$last_line + 10,number_format($kekurangan,2,',','.'));
			$pdf->line(30,$last_line + 15,575,$last_line + 15);
			
			$pdf->output();
		}
		
		private function _cetak_pdf_klien_order($sql,$keterangan,$sc_name) {
			require("lib/fpdf/fpdf.php");
			$total = 0;
			$dibayar = 0;
			$uangmuka = 0;
			$kekurangan = 0;
			$line_margin = 10;
			$no = 0;
			$last_line = 0;
			$pdf = new FPDF('P','pt','A4');
			$pdf->Open();
			$pdf->addPage();
			
			/* header */
			$pdf->Image('resources/images/utero.jpg',30,15,70,70,'jpg');
			$pdf->Image('resources/images/logo-utero.jpg',100,15,155,70,'jpg');
			
			$pdf->setFont("ARIAL",'B',13);
			$pdf->text(260,50,"LAPORAN KLIEN ORDER ::: " .$sc_name);
			
			$pdf->setFont("ARIAL",'B',6);
			$pdf->text(285,60,$keterangan);
			$pdf->text(485,77,"PRINT DATE : " . strftime("%d-%m-%Y %H:%M"));
			
			$pdf->Line(30,90,575,90);
			$pdf->setLineWidth(1);
			$pdf->Line(30,92,575,92);
			$pdf->setLineWidth(0);
			$pdf->Line(30,95,575,95);
			
			$pdf->setFont("ARIAL","B",8);
			$pdf->text(40,105,"No");
			$pdf->text(60,105,"Nota");
			$pdf->text(90,105,"Tanggal");
			$pdf->text(135,105,"Nama");
			$pdf->text(215,105,"Alamat");
			$pdf->text(400,105,"Produk");
			$pdf->Line(30,110,575,110);
			$pdf->setFont("ARIAL",'',6);
			$last_line = 120;
			
			$query = $this->db->query($sql);
			foreach($query->result_array() as $row) {
				$pdf->text(42,$last_line,++$no);
				$pdf->text(60,$last_line,$row['nota']);
				$pdf->text(85,$last_line,to_human_date($row['tgl_terima']));
				$pdf->text(135,$last_line,$row['jeneng']);
				$pdf->text(215,$last_line,$row['alamat']);
				$pdf->text(400,$last_line,$row["nama_produk"]);
				//$pdf->text(260,$last_line,number_format($row['total'],2,',','.'));
				
				if($last_line > 810) {
					$last_line = 30;
					$pdf->AddPage();
					$pdf->setFont("ARIAL",'B',8);
					$pdf->Line(30,10,575,10);
					$pdf->text(40,20,"No.");
					$pdf->text(60,20,"Nota");
					$pdf->text(90,20,"Tanggal");
					$pdf->text(135,20,"Nama");
					$pdf->text(215,20,"Alamat");
					$pdf->text(400,20,"Produk");
					$pdf->Line(30,25,575,25);
					$pdf->setFont("ARIAL",'',6);
				}
				$last_line += $line_margin;
			}
			$query->free_result();
			
			$pdf->output();
		}
		
		private function _get_formatted_date($tanggal) {
			$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli',
			'Agustus','September','Oktober','November','Desember');
			$tanggal = explode("-",$tanggal);
			return $tanggal[2]." ".$bulan[$tanggal[1]-1]." ".$tanggal[0];
		}
	
		private function _get_sc_name_from_session() {
			$query = $this->db->query("select * from sim_user where no_user = " . $this->session->userdata('users_code'));
			$row = $query->row_array();
			$query->free_result();
			return $row['user_name'];
		}
	
		private function _to_normal_date($tanggal) {
			return str_replace("/","-",$tanggal);
		}
	}