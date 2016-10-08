<?php

include "Jenis_add.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM Jenis";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Daftar Jenis Barang</h2>
</div>
<hr>
<table width="750" border="0" cellpadding="2" cellspacing="1" class="table table-condensed">
  <tr>
  	<ul class="pager">
  		<li class="previous">
   		<a data-toggle="modal" href="#windowTitleDialog"><i class="icon-plus"></i>Tambah Barang</a>
  		</li> 		
	</ul>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="33" align="center"><b>No</b></th>
        <th width="252"><b>Kategori</b></th>
        <th width="250"><b>Nama Jenis</b></th>
        <th width="88" align="center"><b>Qty Barang</b></th>
        <td width="45" align="center"><b>Edit</b></td>
        <td width="45" align="center"><b>Delete</b></td>
      </tr>
      <?php
	$mySql = "SELECT Jenis.*, kategori.nm_kategori FROM kategori, kategori_sub, Jenis
				WHERE kategori.kd_kategori=kategori_sub.kd_kategori 
				AND kategori_sub.kd_subkategori=Jenis.kd_subkategori 
				ORDER BY kategori.kd_kategori, Jenis.kd_Jenis ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_Jenis'];

		
		$my2Sql = "SELECT COUNT(*) As qty_barang FROM barang, Jenis WHERE barang.kd_Jenis=Jenis.kd_Jenis
					AND Jenis.kd_Jenis='$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);
		
		
		
	?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td><?php echo $myData['nm_Jenis']; ?></td>
        <td align="center"><?php echo $my2Data['qty_barang']; ?></td>
        <td align="center"><a href="?page=EditJenis&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><i class="icon-wrench"></i></a></td>
        <td align="center"><a href="?page=DeleteJenis&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Anda yakin menghapus <?php echo $myData['nm_Jenis']; ?> ... ?')"><i class="icon-trash"></i></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=DataJenis&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
