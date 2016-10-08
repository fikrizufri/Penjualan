<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>Data Supplier Toko Ahmad Ridha</title>
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
</head>
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
<body>
<h2> DAFTAR SUPPLIER </h2>
<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="39" align="center" ><b>No</b></td>
    <td width="186" ><b>Nama Supplier </b></td>
    <td width="338" ><b>Alamat Lengkap </b> </td>
    <td width="116" ><strong>No Telepon </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM supplier ORDER BY nm_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
    <td><?php echo $kolomData['alamat']; ?></td>
    <td><?php echo $kolomData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>