<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$kategoriSQL	= "";
$kategoriSubSQL	= "";
$JenisSQL		= "";

$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';
$kodeKategorisub= isset($_GET['kodeKategorisub']) ? $_GET['kodeKategorisub'] : '';
$kodeJenis		= isset($_GET['kodeJenis']) ? $_GET['kodeJenis'] : '';

if($_GET) {
	if ($kodeKategori =="BLANK") {
		$kategoriSQL = "";
		$namaKategori= "-";
	}
	else {
		$kategoriSQL = "AND kategori.kd_kategori='$kodeKategori'";
		
		$infoSql = "SELECT nm_kategori FROM kategori WHERE kd_kategori='$kodeKategori'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		$namaKategori= $infoData['nm_kategori'];
	}
	
	if ($kodeKategorisub =="BLANK") {
		$kategoriSubSQL = "";
		$namaKategorisub = "-";
	}
	else {
		$kategoriSubSQL = "AND kategori_sub.kd_subkategori='$kodeKategorisub'";

		$info2Sql = "SELECT nm_subkategori FROM kategori_sub WHERE kd_subkategori='$kodeKategorisub'";
		$info2Qry = mysql_query($info2Sql, $koneksidb);
		$info2Data= mysql_fetch_array($info2Qry);
		$namaKategorisub= $info2Data['nm_subkategori'];
	}
	
	if ($kodeJenis =="BLANK") {
		$namaJenis = "-";
	}
	else {
		$JenisSQL = "AND Jenis.kd_Jenis='$kodeJenis'";

		$info3Sql = "SELECT nm_Jenis FROM Jenis WHERE kd_Jenis='$kodeJenis'";
		$info3Qry = mysql_query($info3Sql, $koneksidb);
		$info3Data= mysql_fetch_array($info3Qry);
		$namaJenis= $info3Data['nm_Jenis'];
	}
} 
else {
	$kategoriSQL= "";
	$kategoriSubSQL= "";
	$JenisSQL	= "";
}
?>
<html>
<head>
<title> Daftar Barang per Kategori </title>
<style type="text/css">
<!--
body,td,th {
	font-family: Courier New, Courier, monospace;
}
body {
	margin-top: 1px;
}
.table-list {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 10px 0px;
	background:#fff;	
}
.table-list td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 3px 5px;
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
<h2>LAPORAN  BARANG - Per Kategori </h2>
<table width="500" border="0"  class="table-list">
<tr>
  <td colspan="3" ><strong>BERDASARKAN </strong></td>
</tr>
<tr>
  <td width="132"><b>Nama Kategori </b></td>
  <td width="5"><b>:</b></td>
  <td width="349"><?php echo $namaKategori; ?></td>
</tr>
<tr>
  <td><b>Nama Sub Kategori </b></td>
  <td><b>:</b></td>
  <td><?php echo $namaKategorisub; ?></td>
</tr>
<tr>
  <td><b>Nama Jenis </b></td>
  <td><b>:</b></td>
  <td><?php echo $namaJenis; ?></td>
</tr>
</table>
  
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center"><b>No</b></td>
    <td width="67"><strong>Kode</strong></td>
    <td width="442"><b>Nama Barang</b></td>
    <td width="80" align="right"><b>Harga (Rp)</b></td>
    <td width="45" align="center"><strong>Disk</strong></td>
    <td width="45" align="center"><b>Stok </b></td>
    <td width="55" align="center"><strong>Stok Op</strong> </td>
  </tr>
  <?php
	$mySql = "SELECT barang.* FROM kategori, kategori_sub, Jenis, barang
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori
				AND Jenis.kd_Jenis=barang.kd_Jenis
				$kategoriSQL $kategoriSubSQL $JenisSQL  ORDER BY barang.stok DESC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];

		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
    <td align="center"><?php echo $kolomData['diskon']; ?></td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="center"><?php echo $kolomData['stok_opname']; ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>