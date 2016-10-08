<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$noNota = $_GET['noNota'];
	
	$mySql = "SELECT penjualan.*, user.nm_user 
				FROM penjualan, user 
				WHERE penjualan.kd_user=user.kd_user AND no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>:: Cetak Penjualan</title>
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
<body>
<h2> PENJUALAN BARANG </h2>
<table width="600" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="139"><b>No. Penjualan </b></td>
    <td width="5"><b>:</b></td>
    <td width="378" valign="top"><strong><?php echo $kolomData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Penjualan </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Operator</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['nm_user']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7" ><strong>DAFTAR BARANG</strong></td>
  </tr>
  <tr>
    <td width="28" align="center" ><b>No</b></td>
    <td width="75" ><strong>Kode </strong></td>
    <td width="443" ><b>Nama Barang</b></td>
    <td width="87" align="right" ><b>Harga (Rp) </b></td>
    <td width="44" align="center" ><strong>Disc</strong></td>
    <td width="44" align="center" ><b>Jumlah</b></td>
    <td width="92" align="right" ><strong>Subtotal(Rp)</strong></td>
  </tr>
  <?php
	$mySql ="SELECT penjualan_detail.*, barang.nm_panjang FROM penjualan_detail, barang 
			  WHERE penjualan_detail.kd_barang=barang.kd_barang AND penjualan_detail.no_penjualan='$noNota' 
			  ORDER BY penjualan_detail.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  $harga_jualDiskon=0; $totalBayar = 0; $qtyItem = 0;  $uangKembali=0;
	while($myRow = mysql_fetch_array($myQry)) {
		$nomor++;
		$harga_jualDiskon= $myRow['harga_jual'] - ( $myRow['harga_jual'] * $myRow['diskon_jual'] / 100 );
		$subSotal 	= $myRow['jumlah'] * $harga_jualDiskon;
		$totalBayar	= $totalBayar + $subSotal;
		$qtyItem	= $qtyItem + $myRow['jumlah'];
		$uangKembali= $kolomData['uang_bayar'] - $totalBayar;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myRow['kd_barang']; ?></td>
    <td><?php echo $myRow['nm_panjang']; ?></td>
    <td align="right"><?php echo format_angka($myRow['harga_jual']); ?></td>
    <td align="center"><?php echo $myRow['diskon_jual']; ?>%</td>
    <td align="center"><?php echo $myRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="5" align="right"><b> Total (Rp)  : </b></td>
    <td align="center" ><strong><?php echo $qtyItem; ?></strong></td>
    <td align="right" ><strong><?php echo format_angka($totalBayar); ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><b>Bayar (Rp)   :</b></td>
    <td align="center" >&nbsp;</td>
    <td align="right" ><strong><?php echo format_angka($kolomData['uang_bayar']); ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right"><b>Kembali (Rp)   :</b></td>
    <td align="center" >&nbsp;</td>
    <td align="right" ><strong><?php echo format_angka($uangKembali); ?></strong></td>
  </tr>
</table>
<br/>
</body>
</html>