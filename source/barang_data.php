<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "source/barang_add.php";


$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<style>
html {
  width:1024;
}
</style>
<div class='hero-unit'><h2 align="left"> Daftar Barang</h2>
</div>
<hr>
<table width="900" border="0" cellpadding="2" cellspacing="1" class="table table-condensed">
  <tr>
  	<ul class="pager">
  		<li class="previous">
   		<a data-toggle="modal" href="#ShowModal"><i class="icon-plus"></i>Tambah Barang</a>
  		</li>
 		<li class="next">
    	<a href="?page=PencarianBarang">Cari Barang</a>
  		</li>
	</ul>
  </tr>
  <tr>
    <td colspan="2">
	<table width="100%" border="0" cellspacing="1" cellpadding="3" class="table hover">
      <tr>
        <th width="26" align="center"><b>No</b></th>
        <th width="58" align="center">Kode</th>
        <th width="112" align="center">Barcode</th>
        <th width="440"><b>Nama Barang</b></th>
        <th width="48" align="right"><strong>Diskon</strong></th>
        <th width="100"><b>Harga (Rp)</b></th>
        <td width="45" align="center" ><b>Edit</b></td>
        <td width="45" align="center" ><b>Delete</b></td>
      </tr>
      <?php
	$mySql = "SELECT * FROM barang ORDER BY kd_barang ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		
		
	?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td align="center"><b><?php echo $myData['kd_barang']; ?></b></td>
        <td align="center"><b><?php echo $myData['barcode']; ?></b></td>
        <td><?php echo $myData['nm_panjang']; ?></td>
        <td align="right"><?php echo $myData['diskon']; ?> % </td>
        <td align="center"><?php echo format_angka($myData['harga_jual']); ?></td>
        <td><a href="?page=EditBarang&amp;Kode=<?php echo $myData['kd_barang']; ?>"><i class="icon-wrench"></i></a>
        </td>
        <td align="center"><a href="?page=DeleteBarang&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Anda yakin menghapus <?php echo $myData['nm_panjang']; ?> ... ?')"><i class="icon-trash"></i></a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td align="right"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=DataBarang&hal=$list[$h]'>$h</a> ";
	}
	?>
    </td>
  </tr>
</table>





    