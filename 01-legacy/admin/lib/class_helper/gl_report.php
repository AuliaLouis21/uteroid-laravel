<?
class GlReportHelper {
	private $total = 0;
	private $db = null;
	private $tanggal_awal 	= "";
	private $tanggal_akhir 	= "";
	public function GLReportHelper($db,$tanggal_awal,$tangal_akhir) {
		$this->db = $db;
		$this->tanggal_awal = $tanggal_awal;
		$this->tanggal_akhir = $tangal_akhir;
	}
	public function first_step() {
		$sql="";
	}
	
	private function _to_mssql_date($date) {
		$date = explode("-",$date);
		return $date[1]."/".$date[0]."/".$date[2];
	}
}