<?php
include_once "library/inc.seslogin.php";
include_once "kategori_add.php";


$row = 30;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Daftar Kategori</h2>
</div>
<hr>
<table width="700" border="0" cellpadding="2" cellspacing="1" class="table table-condensed">
  <ul class="pager">
  		<li class="previous">
   		<a data-toggle="modal" href="#windowTitleDialog"><i class="icon-plus"></i>Tambah User</a>
  		</li>
 	</ul>
   <tr>
    <td colspan="2">
	<table class="table table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="33" align="center"><b>No</b></th>
        <th width="550" align="center"><b>Nama Kategori </b></th>
        <td width="45" align="center" ><b>Edit</b></td>
        <td width="45" align="center" ><b>Delete</b></td>
      </tr>
      <?php
	  
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_kategori'];
		
		
		
	?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $kolomData['nm_kategori']; ?></td>
        <td align="center">
		     <a href="?page=EditKategori&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">
		     <i class="icon-wrench"></i></a></td>
        <td align="center">
		      <a href="?page=Deletekategori&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('anda yakin menghapus <?php echo $kolomData['nm_kategori']; ?>... ?')">
			  <i class="icon-trash"></i></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"> <b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=DataKategori&hal=$list[$h]'>$h</a> ";
	}
	?>
	</td>
  </tr>
</table>
