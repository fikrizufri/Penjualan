<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>Daftar Sub Kategori Toko Ahmad</title>
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
<h2>DAFTAR SUB KATEGORI </h2>
<table class="table table-condensed" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" ><b>No</b></td>
    <td width="140" ><strong>Kategori</strong></td>
    <td width="327" ><b>Sub Kategori</b></td>
    <td width="84" align="center" ><b>Qty Barang</b></td>
  </tr>
  <?php
	$mySql = "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori, kategori_sub 
				WHERE kategori_sub.kd_kategori=kategori.kd_kategori ORDER BY kd_kategori, kd_subkategori ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_subkategori'];
		
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis 
					WHERE barang.kd_Jenis=Jenis.kd_Jenis 
					AND Jenis.kd_subkategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
  ?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_kategori']; ?></td>
    <td><strong><?php echo $kolomData['nm_subkategori']; ?></strong></td>
    <td align="center"><?php echo $kolom2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>