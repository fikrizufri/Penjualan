<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$tglStart 	= isset($_GET['tglStart']) ? $_GET['tglStart'] : "01-".date('m-Y');
	$tglEnd 	= isset($_GET['tglEnd']) ? $_GET['tglEnd'] : date('d-m-Y');
	$kodeJenis = isset($_GET['kodeJenis']) ? $_GET['kodeJenis'] : 'ALL';

	if (trim($kodeJenis)=="ALL") {
		$filterSQL 	= "";
		$infoJenis = "All Jenis";
	}
	else {
		$mySql = "SELECT * FROM Jenis WHERE kd_Jenis='$kodeJenis'";
		$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$kolomData = mysql_fetch_array($myQry);
		$infoJenis = $kolomData['nm_Jenis']." [ ".$kolomData['kd_Jenis']." ]";
		
		$filterSQL 	= "barang.kd_Jenis ='$kodeJenis' AND ";
	}

	$SqlPeriode = $filterSQL." ( P.tgl_penjualan BETWEEN '".InggrisTgl($tglStart)."' AND '".InggrisTgl($tglEnd)."')";

}
?>
<html>
<head>
<title>Hasil Penjualan per Jenis</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Courier New, Courier, monospace;
}
body {
	margin-top: 1px;
}
.table table-condensed {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 5px 0px;
	background:#fff;	
}
.table table-condensed td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 2px 3px;
	border-bottom:1px #CCCCCC solid;
}

-->
</style>

<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">
<h2>HASIL PENJUALAN</h2>
<table width="400" border="0"  class="table table-condensed">
  <tr>
    <td colspan="3" ><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td><strong> Jenis </strong></td>
    <td><strong>:</strong></td>
    <td><?php echo $infoJenis; ?></td>
  </tr>
  <tr>
    <td width="90"><strong>Periode </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="391"><?php echo $tglStart; ?> <strong>s/d</strong> <?php echo $tglEnd; ?></td>
  </tr>
</table>
<br />
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="37" align="center" ><b>No</b></td>
    <td width="102" align="center" ><b>Kode</b></td>
    <td width="538" ><b>Nama Barang </b></td>
    <td width="102" align="center" ><b>Qty Terjual</b></td>
  </tr>
	<?php
	$dataSql = "SELECT barang.*, SUM(PI.jumlah) As terjual 
		 FROM barang, penjualan As P, penjualan_detail As PI
		 WHERE barang.kd_barang = PI.kd_barang AND P.no_penjualan = PI.no_penjualan AND $SqlPeriode
		 GROUP BY barang.kd_barang ORDER BY terjual DESC";
 
	$dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
	$nomor = 0; $qtyTerjual = 0;
	while ($dataRow = mysql_fetch_array($dataQry)) {
		$nomor++;
		$qtyTerjual = $qtyTerjual + $dataRow['terjual'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
    <td><?php echo $dataRow['nm_panjang']; ?></td>
    <td align="center"><?php echo $dataRow['terjual']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="right" ><strong>Total Terjual</strong><b> :</b></td>
    <td align="center" ><strong><?php echo $qtyTerjual; ?></strong></td>
  </tr>
</table>
</body>
</html>