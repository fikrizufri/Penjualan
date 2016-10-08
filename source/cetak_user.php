<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title> :: Data User/Kasir Toko Ahmad Ridha</title>
<style type="text/css">
<!--
body{
	margin:0px auto 0px;
	padding:3px;
	font-family:"Arial";
	font-size:12px;
	color:#333;
	width:95%;
	background-position:top;
	background-color:#fff;
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
<h2> DAFTAR USER </h2>
<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="32" align="center" ><b>No</b></td>
    <td width="276" ><b>Nama User </b></td>
    <td width="141" ><b>No Telepon </b></td>
    <td width="140" ><b>Username</b></td>
    <td width="85" ><b>Level</b></td>
  </tr>
  <?php
	$mySql 	= "SELECT * FROM user ORDER BY kd_user";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_user']; ?></td>
    <td><?php echo $kolomData['no_telepon']; ?></td>
    <td><?php echo $kolomData['username']; ?></td>
    <td><?php echo $kolomData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>