<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembayaran";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Laporan Pembayaran</h2>
</div>
<table class="table table-condensed" width="750" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="33" align="center" ><strong>No</strong></td>
    <td width="91" align="center" ><strong>No. Bayar </strong></td>
    <td width="91" ><strong>Tgl. Bayar </strong></td>
    <td width="180" ><strong>Tgl. Periode </strong></td>
    <td width="179" ><strong>Supplier</strong></td>
    <td width="104" align="right" ><strong> Bayar (Rp) </strong></td>
    <td width="36" align="center" ><strong>Tool</strong></td>
  </tr>
  <?php
	$mySql = "SELECT pembayaran.*, supplier.nm_supplier FROM pembayaran, supplier 
				WHERE pembayaran.kd_supplier=supplier.kd_supplier 
				ORDER BY pembayaran.no_pembayaran DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$noBayar = $kolomData['no_pembayaran'];
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td align="center"><?php echo $kolomData['no_pembayaran']; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_pembayaran']); ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_periode_start']); ?> <b>s/d</b> <?php echo IndonesiaTgl($kolomData['tgl_periode_end']); ?></td>
    <td><?php echo $kolomData['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($kolomData['total_bayar']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_pembayaran_cetak.php?noBayar=<?php echo $noBayar; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" align="left" ><b>Jumlah Data :</b> <?php echo $jml; ?></td>
    <td colspan="4" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanPembayaran&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>