<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";


$sql = "";
$sqlPage = "";

if($_GET) {
	
	$kdkategori = isset($_GET['kdkategori']) ? $_GET['kdkategori'] : 'ALL';
	$kodekategori = isset($_POST['cmbkategori']) ? $_POST['cmbkategori'] : $kdkategori;
	
	
	if(isset($_POST['btnFilter'])) {
		$txtKataKunci	= $_POST['txtKataKunci'];
	
		$keyWord 		= explode(" ", $txtKataKunci);
		$filterSql		= "";
		if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$filterSql	.= " OR nm_panjang LIKE'%$kata%'";
			}
		}

		if (trim($_POST['cmbkategori'])=="ALL") {
			
			$filterSQL 	= "SELECT * FROM barang WHERE nm_panjang LIKE '%$txtKataKunci%' $filterSql ORDER BY kd_barang";
		}
		else {
			
			$filterSQL 	= "SELECT barang.* FROM kategori, kategori_sub, Jenis, barang
						WHERE kategori.kd_kategori=kategori_sub.kd_kategori
						AND kategori_sub.kd_subkategori=Jenis.kd_subkategori
						AND Jenis.kd_Jenis=barang.kd_Jenis
						AND kategori.kd_kategori ='$kodekategori' 
						AND barang.nm_panjang LIKE '%txtKataKunci%'  $filterSql ORDER BY barang.stok DESC";
		}
	}
	else {
		
		$filterSQL 	= "SELECT * FROM barang ORDER BY kd_barang";
	}
	
	
	$dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
}


$row = 50;  
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageQry = mysql_query($filterSQL, $koneksidb) or die("error paging:".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class='hero-unit'><h2 align="left">Pencarian Barang</h2>
	
</div>
<hr>
<div class="alert">
  			<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>Silahkan Isi Data Dibawah Ini Untuk Mencari Barang Yang Anda Inginkan  </strong>
		  </div>
<form action="?page=PencarianBarang" method="post" name="form1" target="_self" id="form1">
<table width="900" border="0" cellpadding="2" cellspacing="1" class="">
  <tr>
    <td colspan="2">
	  <table width="500" border="0" >
		<tr>
		  
		</tr>
		<tr>
		  <td width="35%"><strong>Kategori </strong></td>
		  <td width="5"><strong>:</strong></td>
		  <td width="387" class="input-prepend"><select name="cmbkategori">
            <option value="ALL">- ALL -</option>
            <?php
		  $mySql = "SELECT * FROM kategori ORDER BY kd_kategori";
		  $myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($kolomData = mysql_fetch_array($myQry)) {
			if ($kodekategori == $kolomData['kd_kategori']) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$kolomData[kd_kategori]' $cek>$kolomData[nm_kategori]</option>";
		  }
		  $mySql ="";
		  ?>
          </select></td>
		</tr>
		<tr>
		  <td><strong>Nama Barang  </strong></td>
		  <td><strong>:</strong></td>
		  <td class="input-prepend">
          <input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" />
		    <input name="btnFilter" type="submit" value="Filter" class="btn" /></td>
		  </tr>
	  </table>	</td>
  </tr>
  
  <table class="table table-condensed" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="24"><b>No</b></th>
        <th width="71"><strong>Kode</strong></th>
        <th width="442"><b>Nama Barang </b></th>
        <th width="48" align="center"><strong>Diskon</strong></th>
        <th width="49" align="center"><strong>Stok</strong></th>
        <th width="102" align="right"><b>Harga (Rp) </b></th>
        <td width="32" align="center"><b>Edit</b></td>
        <td width="45" align="center"><b>Delete</b></td>
        <td width="35" align="center"><strong>Print</strong></td>
      </tr>
      <?php
	
	$mySql 	= $filterSQL." LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['kd_barang'];

		
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $kolomData['kd_barang']; ?></td>
        <td><?php echo $kolomData['nm_panjang']; ?></td>
        <td align="center"><?php echo $kolomData['diskon']; ?>%</td>
        <td align="center"><?php echo $kolomData['stok']; ?></td>
        <td align="right"><b><?php echo format_angka($kolomData['harga_jual']); ?></b></td>
        <td align="center"><a href="?page=EditBarang&amp;Kode=<?php echo $Kode; ?>" target="_blank" alt="Edit Data"><i class="icon-wrench"></i></a></td>
        <td align="center"><a href="?page=DeleteBarang&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Anda Yakin Menghapus <?php echo $kolomData['nm_panjang']; ?> ... ?')"><i class="icon-trash"></i></a></td>
        <td align="center"><a href="source/barang_view.php?Kode=<?php echo $Kode; ?>" target="_blank"><i class="icon-print"></i></a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3" ><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
        <td colspan="6" align="right" ><b>Halaman ke :</b>
            <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=PencarianBarang&hal=$list[$h]&kdkategori=$kodekategori'>$h</a> ";
	}
	?></td>
     
    </table>
  </tr>
</table>
</form>
