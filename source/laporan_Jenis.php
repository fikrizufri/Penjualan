<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM Jenis";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Laporan Jenis Barang</h2>
</div>
<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="28" align="center" ><b>No</b></td>
    <td width="140" ><strong>kategori</strong></td>
    <td width="175" ><b>Sub kategori</b></td>
    <td width="244" ><strong>Jenis Barang </strong></td>
    <td width="87" align="center" ><b>Qty Barang</b></td>  
  </tr>
  <?php
	$mySql = "SELECT Jenis.*, kategori_sub.nm_subkategori, kategori.nm_kategori FROM kategori, kategori_sub, Jenis
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori 
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori 
				ORDER BY kategori.kd_kategori, Jenis.kd_Jenis ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_Jenis'];

		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis WHERE barang.kd_Jenis=Jenis.kd_Jenis
					AND Jenis.kd_Jenis='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
  ?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_kategori']; ?></td>
    <td><?php echo $kolomData['nm_subkategori']; ?></td>
    <td><strong><?php echo $kolomData['nm_Jenis']; ?></strong></td>
    <td align="center"><?php echo $kolom2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="2" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanJenis&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<i class="icon-print" onclick="javascript:window.open('source/cetak_Jenis.php', width='900',height=330, left=0)"></i>
