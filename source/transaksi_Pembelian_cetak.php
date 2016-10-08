<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	
	$kodeTransaksi = $_GET['noNota'];
	
	$mySql = "SELECT Pembelian.*, supplier.nm_supplier, user.nm_user 
				FROM Pembelian, supplier, user 
				WHERE Pembelian.kd_supplier=supplier.kd_supplier AND Pembelian.kd_user=user.kd_user 
				AND no_Pembelian='$kodeTransaksi'";
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
<title>Cetak Pembelian</title>
<link href="../css/bootstrap.css" rel="stylesheet">
<style type="text/css">
body {
	margin-top: 1px;
}


-->
</style>
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body>
<h2> PEMBELIAN BARANG </h2>
<table width="600" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="139"><b>No. Pembelian </b></td>
    <td width="5"><b>:</b></td>
    <td width="378" valign="top"><strong><?php echo $kolomData['no_Pembelian']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Pembelian </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($kolomData['tgl_Pembelian']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['keterangan']; ?></td>
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
<table class="table-list" width="849" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="6" ><strong>DAFTAR BARANG</strong></td>
  </tr>
  <tr>
    <td width="33" align="center" ><b>No</b></td>
    <td width="71" ><strong>Kode </strong></td>
    <td width="282" ><b>Nama Barang</b></td>
    <td width="186" align="center" ><strong>Harga Beli(Rp)</strong> </td>
    <td width="60" align="center" ><b>Jumlah</b></td>
    <td width="177" align="center" ><strong>Subtotal(Rp) </strong></td>
    <td width="8"></td>
  </tr>
  <?php
$mySql ="SELECT Pembelian_detail.*, barang.nm_panjang, Jenis.nm_Jenis
		  FROM Pembelian_detail, barang, Jenis
		  WHERE barang.kd_Jenis=Jenis.kd_Jenis AND Pembelian_detail.kd_barang=barang.kd_barang 
		  AND Pembelian_detail.no_Pembelian='$kodeTransaksi' ORDER BY Pembelian_detail.kd_barang";
$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
while($myData = mysql_fetch_array($myQry)) {
	$qtyItem= $qtyItem + $myData['jumlah'];
	$subTotal		= $myData['harga_beli'] * $myData['jumlah']; 
	$totalBelanja	= $totalBelanja + $subTotal;
	$nomor++;
?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_panjang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="center"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotal); ?></td>
  </tr>
  <?php 
}?>
  <tr>
    <td colspan="4" align="right" ><b> Gran Total   : </b></td>
    <td align="center" ><strong><?php echo $qtyItem; ?></strong></td>
    <td align="right" ><strong>Rp. <?php echo format_angka($subTotal); ?></strong></td>
  </tr>
  <tr>
    <td colspan="6" align="right" ><p class="text-right">Mengetahui</p></td>
    
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
    <td colspan="6" align="right" ><?php echo $kolomData['nm_user']; ?></strong></td>
    </tr>
</table>
<br/>

</body>
</html>