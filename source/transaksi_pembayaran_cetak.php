<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	
	$noBayar = $_GET['noBayar'];
	
	
	$mySql = "SELECT pembayaran.*, supplier.nm_supplier, user.nm_user 
				FROM pembayaran, supplier, user 
				WHERE pembayaran.kd_supplier=supplier.kd_supplier AND pembayaran.kd_user=user.kd_user 
				AND no_pembayaran='$noBayar'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$kolomData = mysql_fetch_array($myQry);
	
	
	$dataSupplier= $kolomData['kd_supplier'];
	$dataTglStart	= $kolomData['tgl_periode_start'];
	$dataTglEnd		= $kolomData['tgl_periode_end'];
	
	
	$SqlPeriode = "P.kd_supplier ='$dataSupplier' AND ( P.tgl_Pembelian BETWEEN '$dataTglStart' AND '$dataTglEnd')";
}
else {
	echo "Nomor Transaksi Tidak Terbaca";
	exit;
}
?>
<html>
<head>
<title>Cetak Pembayaran Toko Ahmad Ridha</title>

<style>
	body {
	margin-top: 1px;
}
.table-list {
	clear: both;
	text-align: left;
	border-collapse: collapse;
	margin: 0px 0px 5px 0px;
	background:#fff;	
}
.table-list td {
	color: #333;
	font-size:12px;
	border-color: #fff;
	border-collapse: collapse;
	vertical-align: center;
	padding: 2px 3px;
	border-bottom:1px #CCCCCC solid;
}
</style>
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
 </head>
<body>

<h2> PEMBAYARAN KE SUPPLIER </h2>
<table width="800" border="0" cellspacing="1" cellpadding="4" class="">
  <tr>
    <td width="155"><b>No. Pembayaran </b></td>
    <td width="12"><b>:</b></td>
    <td width="605" valign="top"><strong><?php echo $kolomData['no_pembayaran']; ?></strong></td>
  </tr>
  <tr>
    <td width="155"><b>Tgl. Pembayaran </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($kolomData['tgl_pembayaran']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $kolomData['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td><strong>Tgl. Periode </strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl($kolomData['tgl_periode_start']); ?> <b>s/d</b> <?php echo IndonesiaTgl($kolomData['tgl_periode_end']); ?></td>
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
<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="7">DAFTAR BARANG </th>
  </tr>
  <tr>
    <td width="34" align="center" ><b>No</b></td>
    <td width="113" align="center" ><strong>Tgl. Masuk </strong></td>
    <td width="86" align="center" ><b>Kode</b></td>
    <td width="259" ><b>Nama Barang</b></td>
    <td width="92" align="right" ><strong>Harga(Rp)</strong> </td>
    <td width="60" align="center" ><strong>Jumlah</strong></td>
    <td width="120" align="right" ><strong>Subtotal(Rp)</strong></td>
  </tr>
  <?php
	$dataSql = "SELECT P.tgl_Pembelian, PI.*, barang.kd_barang, barang.nm_panjang, Jenis.nm_Jenis 
		 FROM barang, Jenis, Pembelian As P, Pembelian_detail As PI
		 WHERE barang.kd_barang = PI.kd_barang AND barang.kd_Jenis=Jenis.kd_Jenis
		 AND P.no_Pembelian = PI.no_Pembelian AND $SqlPeriode
		 ORDER BY P.tgl_Pembelian, PI.kd_barang ASC";
	$dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
	$nomor = 0; $qtyTerjual = 0; $totalBayar = 0;
	while ($dataRow = mysql_fetch_array($dataQry)) {
		$nomor++;
		$subSotal 	= $dataRow['harga_beli'] * $dataRow['jumlah'];
		$qtyTerjual = $qtyTerjual + $dataRow['jumlah'];
		$totalBayar	= $totalBayar + $subSotal;

		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><strong><?php echo IndonesiaTgl($dataRow['tgl_Pembelian']); ?></strong></td>
    <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
    <td><?php echo $dataRow['nm_panjang']; ?></td>
    <td align="right"><?php echo format_angka($dataRow['harga_beli']); ?></td>
    <td align="center"><?php echo $dataRow['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subSotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right" ><strong>Grand Total (Rp) </strong><b> :</b></td>
    <td align="center" ><strong><?php echo $qtyTerjual; ?></strong></td>
    <td align="right" ><strong>Rp. <?php echo format_angka($totalBayar); ?></strong></td>
   </tr>
  <tr>
    <td colspan="7"align="right" ><p class="text-right">Mengetahui</p></td>
    
  </tr>
  <tr>
    <td></td>
    
  </tr>
  <tr>
    <td></td>
    
  </tr>
  <tr>
    <td></td>
    
  </tr>
  <tr>
    <td></td>
    
  </tr>
  <tr>
    <td colspan="7" align="right" ><?php echo $kolomData['nm_user']; ?></strong></td>
    </tr>
</table>
  
* <strong>Tgl. Periode</strong> : Periode hasil penjualan yang dibayar <br/><br/>

</body>
</html>
