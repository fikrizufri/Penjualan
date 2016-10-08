<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>Daftar Jenis Barang Toko Ahmad Ridha</title>

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
	margin: 0px 0px 10px 0px;
	background:#fff;	
}
.table table-condensed td {
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
<h2>DAFTAR Jenis BARANG</h2>

<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="37" align="center" ><b>No</b></td>
    <td width="160" ><strong>kategori</strong></td>
    <td width="231" ><b>Sub kategori</b></td>
    <td width="260" ><strong>Jenis Barang </strong></td>
    <td width="86" align="center" ><b>Qty Barang</b></td>
  </tr>
  <?php
	$mySql = "SELECT Jenis.*, kategori_sub.nm_subkategori, kategori.nm_kategori FROM kategori, kategori_sub, Jenis
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori 
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori 
				ORDER BY kategori.kd_kategori, Jenis.kd_Jenis ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_Jenis'];

		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis WHERE barang.kd_Jenis=Jenis.kd_Jenis
					AND Jenis.kd_Jenis='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
  ?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_kategori']; ?></td>
    <td><?php echo $kolomData['nm_subkategori']; ?></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
    <td align="center"><?php echo $kolom2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>

</body>
</html>