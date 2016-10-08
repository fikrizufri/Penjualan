<?php
include_once "library/inc.seslogin.php";
if($_GET) {
	if(empty($_GET['id'])){
		echo "<b>Data yang dihapus tidak ada</b>";
	}
	else {
		$mySql = "DELETE FROM pembayaran WHERE no_pembayaran='".$_GET['noBayar']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($mySql){
			echo "<meta http-equiv='refresh' content='200; url='?page=TransaksiPembayaran'>";
			include "transaksi_pembayaran.php";
		}
	}
}
?>