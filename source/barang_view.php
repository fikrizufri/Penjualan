<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$Kode	 = isset($_GET['Kode']) ?  $_GET['Kode'] : ''; 
	$sqlData = "SELECT barang.*, Jenis.nm_Jenis, supplier.nm_supplier
				FROM barang, Jenis, supplier
				WHERE barang.kd_Jenis=Jenis.kd_Jenis AND barang.kd_supplier=supplier.kd_supplier AND barang.kd_barang='$Kode'";
	$qryData = mysql_query($sqlData, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$kolomData= mysql_fetch_array($qryData);
}
else {
	echo "Kode Barang Tidak Terbaca";
	exit;
}
?>

<html>
<head>
<title>Detail Barang Toko H Acmad Ridha</title>
<link href="file:///F|/har/source/css/bootstrap.css" rel="stylesheet">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body>
<h2>DATA LENGKAP BARANG </h2>
<table width="46%" class="table table-hover">
  <i class="icon-print" onClick="javascript:window.print()" ></i>
  <tr>
    <td width="56%"><b>Kode Barang </b></td>
    <td width="3%"><b>:</b></td>
    <td width="41%"><?php echo $kolomData['kd_barang']; ?></td>
  </tr>
  <tr>
    <td><b>Barcode</b></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['barcode']; ?></td>
  </tr>
  <tr>
    <td><b>Nama Barang (20 char) </b></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['nm_pendek']; ?></td>
  </tr>
  <tr>
    <td><b>Judul Barang </b></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
  </tr>
  <tr>
    <td><b>Keterangan</b></td>
    <td><b>:</b></td>
    <td width="41%"><?php echo $kolomData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><b>Harga Beli (Rp) </b></td>
    <td><b>:</b></td>
    <td><?php echo format_angka($kolomData['harga_beli']); ?></td>
  </tr>
  <tr>
    <td><b>Harga Jual (Rp) </b></td>
    <td><b>:</b></td>
    <td><?php echo format_angka($kolomData['harga_jual']); ?></td>
  </tr>
  <tr>
    <td><b>Diskon (%) </b></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['diskon']; ?> %</td>
  </tr>
  <tr>
    <td><b>Stok </b></td>
    <td><b>:</b></td>
    <td width="41%"><?php echo $kolomData['stok']; ?></td>
  </tr>
  <tr>
    <td><b>Stok Opname </b></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['stok_opname']; ?></td>
  </tr>
  
  <tr>
    <td><strong>Jenis </strong></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
  </tr>
  <tr>
    <td><strong>Supplier </strong></td>
    <td><b>:</b></td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
  </tr>
   <tr>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>

</body>
</html>