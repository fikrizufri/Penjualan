<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";


$noNota = $_GET['noNota'];


$mySql = "SELECT penjualan.*, user.nm_user FROM penjualan, user 
			WHERE penjualan.kd_user=user.kd_user AND no_penjualan='$noNota'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
$kolomData = mysql_fetch_array($myQry);
?>
<html>
<head>
<title>Nota Penjualan</title>
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
<table class="table table-condensed" width="465" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td height="87" colspan="6" align="center"><strong>Toko H.Acmad Ridha</strong><br>
      <strong>NPWP/ PKP : </strong>797.133.SMD.12<br>
      <strong>Tanggal Pengukuhan : </strong>11-12-1999<br>
      Samarinda, Kalimantan Timur </td>
  </tr>
  <tr>
    <td colspan="2"><strong>No Nota :</strong> <?php echo $kolomData['no_penjualan']; ?></td>
    <td colspan="4" align="right"><?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td width="22" align="center" ><b>No</b></td>
    <td width="188" ><b>Daftar Barang </b></td>
    <td width="55" align="center" ><b>Harga</b></td>
    <td width="40" align="center" ><strong>Disc</strong></td>
    <td width="36" align="center" ><strong>Qty</strong></td>
    <td width="93" align="right" ><b>Subtotal</b></td>
  </tr>
	<?php
	$notaSql = "SELECT barang.nm_pendek, penjualan_detail.* FROM barang, penjualan_detail
				WHERE barang.kd_barang=penjualan_detail.kd_barang AND penjualan_detail.no_penjualan='$noNota'
				ORDER BY barang.kd_barang ASC";
	$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list barang salah : ".mysql_error());
	$nomor  = 0;  $hargaDiskon=0; $totalBayar = 0; $qtyItem = 0;  $uangKembali=0;
	while ($notaRow = mysql_fetch_array($notaQry)) {
	$nomor++;
		$hargaDiskon= $notaRow['harga_jual'] - ( $notaRow['harga_jual'] * $notaRow['diskon_jual'] / 100 );
		$subSotal 	= $notaRow['jumlah'] * $hargaDiskon;
		$totalBayar	= $totalBayar + $subSotal;
		$qtyItem	= $qtyItem + $notaRow['jumlah'];
		$uangKembali= $kolomData['uang_bayar'] - $totalBayar;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $notaRow['nm_pendek']; ?></td>
    <td align="right"><?php echo format_angka($notaRow['harga_jual']); ?></td>
    <td align="center"><?php echo $notaRow['diskon_jual']; ?>%</td>
    <td align="center"><?php echo $notaRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="right"><b>Total  (Rp) : </b></td>
    <td colspan="3" align="right"><b><?php echo format_angka($totalBayar); ?></b></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><b>  Bayar (Rp) : </b></td>
    <td colspan="3" align="right"><b><?php echo format_angka($kolomData['uang_bayar']); ?></b></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><b>Kembali  (Rp) : </b></td>
    <td colspan="3" align="right"><b><?php echo format_angka($uangKembali); ?></b></td>
  </tr>
  <tr>
  	<td colspan="3" align="right"><strong>Kasir :</strong></td>
    <td colspan="3" align="right"> <?php echo $kolomData['nm_user']; ?></td>
  </tr>
</table>
<table width="430" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">** TERIMA KASIH ** </td>
  </tr>
</table>
</body>
</html>