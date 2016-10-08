<?php
include_once "library/inc.seslogin.php";
?>

<div class='hero-unit'><h2 align="left">Laporan Barang Dari Kategori</h2>
</div>
<table class="table table-hover" ><tr>
    <td width="38" align="center" ><b>No</b></td>
    <td width="446" ><b>Nama kategori</b></td>
    <td width="100" align="center" ><b>Qty Barang</b></td>  
  </tr>
  <?php
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_kategori'];
		
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis, kategori_sub 
					WHERE barang.kd_Jenis=Jenis.kd_Jenis AND Jenis.kd_subkategori=kategori_sub.kd_subkategori
					AND kategori_sub.kd_kategori='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
  ?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['nm_kategori']; ?></td>
    <td align="center"><?php echo $kolom2Data['qty_barang']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="#" onclick="javascript:window.open('source/cetak_kategori.php', width='900',height=330, left=0)"><i class="icon-print" ></i></a>