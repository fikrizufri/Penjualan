<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "kategori_sub_add.php";

$row = 30;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori_sub";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Daftar Sub Kategori</h2>
</div>
<hr>
<table width="700" border="0" cellpadding="2" cellspacing="1" class="table table-condensed">
  <ul class="pager">
  		<li class="previous">
   		<a data-toggle="modal" href="#windowTitleDialog"><i class="icon-plus"></i>Tambah Barang</a>
  		</li>
  </ul>  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="33" align="center"><b>No</b></th>
        <th width="196">Kategori</th>
        <th width="349"><b>Nama Sub Kategori</b></th>
        <td width="45" align="center" ><b>Edit</b></td>
        <td width="45" align="center" ><b>Delete</b></td>
      </tr>
      <?php
	$mySql = "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori, kategori_sub 
				WHERE kategori_sub.kd_kategori=kategori.kd_kategori ORDER BY kd_kategori, kd_subkategori ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_subkategori'];
				
		
		
	?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td><?php echo $myData['nm_subkategori']; ?></td>
        <td align="center"><a href="?page=EditSubKategori&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data"><i class="icon-wrench"></i></a></td>
        <td align="center"><a href="?page=DeleteSubKategori&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Anda yakin menghapus <?php echo $myData['nm_kategori']; ?> ... ?')"><i class="icon-trash"></a></td>
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
		echo " <a href='?page=DataSubKategori&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
