<?php
include_once "library/inc.seslogin.php";
if($_GET) {
	if(empty($_GET['id'])){
		echo "<b>Data yang dihapus tidak ada</b>";
	}
	else {
		$mySql = "DELETE FROM tmp_penjualan WHERE id='".$_GET['id']."' AND kd_user='".$_SESSION['SES_LOGIN']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		if($mySql){
			echo "<meta http-equiv='refresh' content='200; url='?page=PenjualanRetur'>";
			include "transaksi_retur.php";
		}
	}
}
?>