<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	$noNota = $_GET['noNota'];
	
	$mySql = "SELECT retur.*, supplier.nm_supplier, user.nm_user 
				FROM retur, supplier, user 
				WHERE retur.kd_supplier=supplier.kd_supplier AND retur.kd_user=user.kd_user 
				AND no_retur='$noNota'";
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
<title>Cetak Retur</title>
<link href="../css/bootstrap.css" rel="stylesheet">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body>
<h2> RETUR BARANG </h2>
<table width="600" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="139"><b>No. Retur </b></td>
    <td width="5"><b>:</b></td>
    <td width="378" valign="top"><strong><?php echo $kolomData['no_retur']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl.Retur</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($kolomData['tgl_retur']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['nm_supplier']; ?></td>
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
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="5" ><strong>DAFTAR BARANG</strong></td>
  </tr>
  <tr>
    <td width="29" align="center" ><b>No</b></td>
    <td width="82" ><strong>Kode </strong></td>
    <td width="473" ><b>Nama Barang</b></td>
    <td width="140" ><b>Jenis</b></td>
    <td width="50" align="center" ><b>Jumlah</b></td>
  </tr>
  <?php
$mySql ="SELECT retur_detail.*, barang.nm_panjang, Jenis.nm_Jenis
		  FROM retur_detail, barang, Jenis
		  WHERE barang.kd_Jenis=Jenis.kd_Jenis AND retur_detail.kd_barang=barang.kd_barang 
		  AND retur_detail.no_retur='$noNota' ORDER BY retur_detail.kd_barang";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $qtyItem = 0;
while($myRow = mysql_fetch_array($myQry)) {
	$qtyItem= $qtyItem + $myRow['jumlah'];
	
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myRow['kd_barang']; ?></td>
    <td><?php echo $myRow['nm_panjang']; ?></td>
    <td><?php echo $myRow['nm_Jenis']; ?></td>
    <td align="center"><?php echo $myRow['jumlah']; ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="4" align="right" ><b> Total   : </b></td>
    <td align="center" ><strong><?php echo $qtyItem; ?></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right" ><p class="text-right">Mengetahui</p></td>
    
  </tr>
  <tr>
    <td colspan="4" align="right" ></td>
    
  </tr>
  <tr>
    <td colspan="4" align="right" ></td>
    
  </tr>
    
    <td colspan="4" align="right" ></td>
    
  </tr>
   <tr>
    <td colspan="4" align="right" ></td>
    
  </tr>
  <tr>
    <td colspan="4" align="right" ></td>
    
  </tr>
    
    <td colspan="4" align="right" ></td>
    
  </tr>
  <tr>
    <td colspan="5" align="right" ><?php echo $kolomData['nm_user']; ?></strong></td>
    </tr>
</table>
<br/>

</body>
</html>