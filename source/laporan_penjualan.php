<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Transaksi Penjualan</h2>
</div>
<table class="table table-condensed" width="600" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="29" align="center" ><b>No</b></td>
    <td width="83" ><b>Tanggal</b></td>
    <td width="194" ><b>No. Penjualan </b> </td>  
    <td width="95" align="right" ><strong>Qty Barang </strong></td>
    <td width="125" align="right" ><strong>Total Belanja (Rp) </strong></td>
    <td width="43" align="center" ><b>View</b></td>
  </tr>
<?php
	$mySql = "SELECT * FROM penjualan ORDER BY no_penjualan DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $kolomData['no_penjualan'];
		
		$my2Sql = "SELECT SUM(jumlah) as qty_total FROM penjualan_detail WHERE no_penjualan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
		$my3Sql = "SELECT SUM((harga_jual - (harga_jual * diskon_jual / 100)) * jumlah) as uang_total FROM penjualan_detail WHERE no_penjualan='$noNota'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$kolom3Data = mysql_fetch_array($my3Qry);
		
		
	?>
  <tr  >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
    <td><?php echo $kolomData['no_penjualan']; ?></td>
    <td align="right"><?php echo $kolom2Data['qty_total']; ?></td>
    <td align="right"><?php echo format_angka($kolom3Data['uang_total']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_penjualan_cetak.php?noNota=<?php echo $noNota; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="3" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanPenjualan&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
