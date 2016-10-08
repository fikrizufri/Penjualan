<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM Pembelian";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Transaksi Pembelian</h2>
</div>
<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="28" align="center" ><b>No</b></td>
    <td width="78" ><b>Tanggal</b></td>
    <td width="107" ><b>No. Pembelian</b></td>  
    <td width="150" ><b>Supplier </b></td>
    <td width="191" ><strong>Keterangan</strong></td>
    <td width="77" align="right" ><strong>Qty Barang </strong></td>
    <td width="33" align="center" ><b>View</b></td>
  </tr>
<?php
	$mySql = "SELECT Pembelian.*, supplier.nm_supplier FROM Pembelian, supplier 
				WHERE Pembelian.kd_supplier=supplier.kd_supplier 
				ORDER BY Pembelian.no_Pembelian ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query Pembelian salah : ".mysql_error());
	$nomor  = 0; 
	while ($myRow = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $myRow['no_Pembelian'];
		
		$my2Sql = "SELECT SUM(jumlah) as qty_barang FROM Pembelian_detail WHERE no_Pembelian='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myRow['tgl_Pembelian']); ?></td>
    <td><?php echo $myRow['no_Pembelian']; ?></td>
    <td><?php echo $myRow['nm_supplier']; ?></td>
    <td><?php echo $myRow['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($kolom2Data['qty_barang']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_Pembelian_cetak.php?noNota=<?php echo $noNota; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></a>
    </td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="4" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanPembelian&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table> 
