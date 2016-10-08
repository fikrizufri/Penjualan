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
<h2>Laba Rugi - per Tanggal</h2>
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
<table class="table table-condensed" width="995" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td width="20" align="center" ><b>No</b></td>
      <td width="119" align="center" ><strong>Tanggal</strong></td>
      <td width="60" align="center" ><b>Kode</b></td>
      <td width="134" ><b>Nama Barang</b></td>
      <td width="90" ><b>Jenis</b></td>
      <td width="109" align="center" ><b>Harga Beli</b></td>
      <td width="119" align="center" ><b>Harga Jual</b></td>
      <td width="40" align="center" ><b>Stok</b></td>
      <td width="124" align="center" ><b>Laba Satuan</b></td>
      <td width="129" align="center" ><b>Laba Barang</b></td>
  </tr>
      <?php
      $dataSql = "SELECT P.tgl_penjualan, barang.kd_barang, barang.harga_beli, barang.harga_jual, barang.stok, barang.nm_panjang, Jenis.nm_Jenis, 
           SUM(PI.jumlah) As terjual 
           FROM barang, Jenis, penjualan As P, penjualan_detail As PI
           WHERE barang.kd_barang = PI.kd_barang AND barang.kd_Jenis=Jenis.kd_Jenis
           AND P.no_penjualan = PI.no_penjualan AND $SqlPeriode
           GROUP BY barang.kd_barang, P.tgl_penjualan ORDER BY P.tgl_penjualan DESC";
   
      $dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
      $nomor = 0; $jmlh = 0;
      
      while ($dataRow = mysql_fetch_array($dataQry)) {
          $nomor++;
          $labaSatuan = $dataRow['harga_jual'] - $dataRow['harga_beli'];
          $labaBarang = $labaSatuan * $dataRow['stok'] ;
          $jmlh = $jmlh + $labaBarang;
          
      ?>
    <tr >
      <td align="center"><?php echo $nomor; ?></td>
      <td align="center"><strong><?php echo IndonesiaTgl($dataRow['tgl_penjualan']); ?></strong></td>
      <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
      <td><?php echo $dataRow['nm_panjang']; ?></td>
      <td><?php echo $dataRow['nm_Jenis']; ?></td>
      <td><?php echo format_angka($dataRow['harga_beli']); ?></td>
      <td><?php echo format_angka($dataRow['harga_jual']); ?></td>
      <td><?php echo $dataRow['stok']; ?></td>
      <td align="center"><?php echo format_angka($labaSatuan); ?></td>
      <td align="center"><?php echo format_angka($labaBarang); ?></td>
    </tr>
    <?php } ?><tr>
      <td colspan="9" align="right"><p ><strong>Total Laba</strong><b> :</b></p></td>
      <td colspan="3" align="left" ><p ><strong><?php echo format_angka($jmlh); ?></strong></p></td>
    </tr>

</table>
</body>
</html>