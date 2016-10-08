<?php


$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang";
$pageQry = mysql_query($pageSql, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>

<div class='hero-unit'><h2 align="left">Laporan Barang</h2>
</div>
<hr>
<table width="100%" class="table table-condensed"><tr>
    <td  ><b>No</b></td>
    <td  ><strong>Kode</strong></td>
    <td ><b>Nama Barang</b></td>
    <td ><strong>Jenis</strong></td>
    <td ><b>Harga (Rp) </b></td>
    <td align="center" ><strong>Disk</strong></td>
    <td align="center" ><strong>Stok</strong></td>
    <td align="center" ><strong>Stok Op </strong> </td>
    <td align="center" ><strong>Print</strong></td>
  </tr>
  <?php
	
	$mySql 	= "SELECT barang.*, Jenis.nm_Jenis FROM barang, Jenis 
				WHERE barang.kd_Jenis=Jenis.kd_Jenis ORDER BY barang.kd_barang ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $hal; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];
		
		
		
	?>
  <tr >
    <td><?php echo $nomor; ?></td>
    <td><?php echo $kolomData['kd_barang']; ?></td>
    <td><?php echo $kolomData['nm_panjang']; ?></td>
    <td><?php echo $kolomData['nm_Jenis']; ?></td>
    <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
    <td align="center"><?php echo $kolomData['diskon']; ?>%</td>
    <td align="center"><?php echo $kolomData['stok']; ?></td>
    <td align="center"><?php echo $kolomData['stok_opname']; ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/barang_view.php?Kode=<?php echo $Kode; ?>', width='900',height=330, left=0)"><i class="icon-print"></i></a></td>
  </tr>
  <?php } ?><tr>
    <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td colspan="6" align="right" ><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=LaporanBarang&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="#" onclick="javascript:window.open('source/cetak_barang.php', width='900',height=330, left=0)"><i class="icon-print" ></i></a>