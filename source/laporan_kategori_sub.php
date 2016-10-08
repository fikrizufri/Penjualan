<?php
include_once "library/inc.seslogin.php";

$row = 30;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori_sub";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Laporan Barang Sub Kategori</h2>
</div>
<table class="table table-hover" ><tr>
    <td  ><b>No</b></td>
    <td ><strong>kategori</strong></td>
    <td ><b>Sub kategori</b></td>
    <td><b>Qty Barang</b></td>  
  </tr>
  <?php
	$mySql = "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori, kategori_sub 
				WHERE kategori_sub.kd_kategori=kategori.kd_kategori ORDER BY kd_kategori, kd_subkategori ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_subkategori'];
		
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis 
					WHERE barang.kd_Jenis=Jenis.kd_Jenis 
					AND Jenis.kd_subkategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
  ?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_kategori']; ?></td>
    <td><strong><?php echo $kolomData['nm_subkategori']; ?></strong></td>
    <td align="center"><?php echo $kolom2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="#" onclick="javascript:window.open('source/cetak_kategori_sub.php', width='900',height=330, left=0)"><i class="icon-print" ></i></a>
