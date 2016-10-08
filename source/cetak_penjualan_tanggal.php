<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$tglStart 	= isset($_GET['tglStart']) ? $_GET['tglStart'] : "01-".date('m-Y');
	$tglEnd 	= isset($_GET['tglEnd']) ? $_GET['tglEnd'] : date('d-m-Y');

	$SqlPeriode = " ( P.tgl_penjualan BETWEEN '".InggrisTgl($tglStart)."' AND '".InggrisTgl($tglEnd)."')";
}
?>
<html>
<head>
<title> Penjualan Pertanggal Toko Ahmad Ridha</title>
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
<h2>HASIL PENJUALAN - per Tanggal</h2>
<table width="400" border="0"  class="table table-condensed">
  <tr>
    <td colspan="3" ><strong>KETERANGAN</strong></td>
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
    <td width="25" align="center" ><b>No</b></td>
    <td width="124" align="center" ><strong>Tanggal</strong></td>
    <td width="76" align="center" ><b>Kode</b></td>
    <td width="311" ><b>Nama Barang </b></td>
    <td width="108" ><b>Jenis</b></td>
    <td width="125" align="center" ><b>Qty Terjual</b></td>
  </tr>
	<?php
	$dataSql = "SELECT P.tgl_penjualan, barang.kd_barang, barang.nm_panjang, Jenis.nm_Jenis, SUM(PI.jumlah) As terjual 
		 FROM barang, Jenis, penjualan As P, penjualan_detail As PI
		 WHERE barang.kd_barang = PI.kd_barang AND barang.kd_Jenis=Jenis.kd_Jenis
		 AND P.no_penjualan = PI.no_penjualan AND $SqlPeriode
		 GROUP BY barang.kd_barang, P.tgl_penjualan ORDER BY P.tgl_penjualan DESC";
 
	$dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
	$nomor = 0; $qtyTerjual = 0;
	while ($dataRow = mysql_fetch_array($dataQry)) {
		$nomor++;
		$qtyTerjual = $qtyTerjual + $dataRow['terjual'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><strong><?php echo IndonesiaTgl($dataRow['tgl_penjualan']); ?></strong></td>
    <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
    <td><?php echo $dataRow['nm_panjang']; ?></td>
    <td><?php echo $dataRow['nm_Jenis']; ?></td>
    <td align="center"><?php echo $dataRow['terjual']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right" ><strong>Total Terjual</strong><b> :</b></td>
    <td align="center" ><strong><?php echo $qtyTerjual; ?></strong></td>
  </tr>
</table>
</body>
</html>