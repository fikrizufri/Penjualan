<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>Daftar Semua Barang</title>
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
<h2>DAFTAR BARANG </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" ><b>No</b></td>
    <td width="76" ><strong>Kode</strong></td>
    <td width="292" ><b>Nama Barang </b></td>
    <td width="131" ><strong>Jenis</strong></td>
    <td width="81" align="right" ><b>Harga (Rp) </b></td>
    <td width="51" align="center" ><strong>Disk</strong></td>
    <td width="51" align="center" ><strong>Stok</strong></td>
    <td width="51" align="center" ><strong>Stok Op </strong> </td>
  </tr>
  <?php
	$mySql 	= "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
				WHERE barang.kd_Jenis=Jenis.kd_Jenis ORDER BY barang.kd_barang";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];
		
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
    <td align="right"><?php echo format_angka($kolomData['harga_jual']); ?></td>
    <td align="center"><?php echo $kolomData['diskon']; ?>%</td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="center"><?php echo $kolomData['stok_opname']; ?></td>
  </tr>
  <?php } ?>
</table>

</body>
</html>