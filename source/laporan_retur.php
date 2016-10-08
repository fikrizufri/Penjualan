<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM retur";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Transaksi Retur</h2>
</div>
<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="40" align="center" ><b>No</b></td>
    <td width="100" ><b>Tanggal</b></td>
    <td width="140" ><b>No. Retur</b></td>  
    <td width="230" ><b>Supplier </b></td>
    <td width="114" align="right" ><strong>Qty Barang </strong></td>
    <td width="45" align="center" ><b>View</b></td>
  </tr>
<?php
	$mySql = "SELECT retur.*, supplier.nm_supplier FROM retur, supplier 
				WHERE retur.kd_supplier=supplier.kd_supplier 
				ORDER BY retur.no_retur ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query retur salah : ".mysql_error());
	$nomor  = 0; 
	while ($myRow = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $myRow['no_retur'];
		
		$my2Sql = "SELECT SUM(jumlah) as qty_barang FROM retur_detail WHERE no_retur='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myRow['tgl_retur']); ?></td>
    <td><?php echo $myRow['no_retur']; ?></td>
    <td><?php echo "[ ".$myRow['kd_supplier']." ] ".$myRow['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($kolom2Data['qty_barang']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_retur_cetak.php?noNota=<?php echo $noNota; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="3" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanRetur&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table> 
