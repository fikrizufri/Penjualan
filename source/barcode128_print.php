<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/bar128.php";

$Kode  = isset($_GET['Kode']) ?  $_GET['Kode'] : ''; 
$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myRow = mysql_fetch_array($myQry);
?>

<style type="text/css">
      tabel{
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f54654;
      }          
</style>
<h2> Cetak Barcode</h2>
<table border="0" cellspacing="1" cellpadding="4">
  <tr>
    <td valign="top">
	<?php 
		if($myRow['barcode'] !="") {
			  echo $myRow['nm_pendek'];
			  echo "<br>Rp. ". format_angka($myRow['harga_jual']);
			  echo " (". $myRow['diskon']." %) <br>"; 
			  echo bar128(stripslashes($myRow['barcode'])); 
		} 
	?></td>
  </tr>
</table>
</body>
</html>