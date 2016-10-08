<?php
include_once "library/inc.seslogin.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		
		$pesanError = array();
		if (trim($_POST['txtkategori'])=="") {
			$pesanError[] = "Data <b>Nama kategori</b> tidak boleh kosong !";		
		}
		
		
		$txtkategori= $_POST['txtkategori'];
		
		
		$cekSql="SELECT * FROM kategori WHERE nm_kategori='$txtkategori'";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, kategori <b> $txtkategori </b> sudah ada, ganti dengan yang lain";
		}

		
		if (count($pesanError)>=1 ){
           echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><p>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
			include_once "kategori_data.php";
		}
		else {
			
			
			$kodeBaru	= buatKode("kategori", "K");
			$mySql	= "INSERT INTO kategori (kd_kategori, nm_kategori) VALUES ('$kodeBaru','$txtkategori')";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataKategori'>";
			}
			exit;
		}	
	} 
	
	$dataKode	= buatKode("kategori", "K");
	$DataKategori	= isset($_POST['txtkategori']) ? $_POST['txtkategori'] : '';
} 
?>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Tambah Data Barang</h2>
	</div>
	<div class="modal-body">
		<form action="?page=Tambahkategori" method="post" name="frmadd" target="_self">
		<table width="450" style="margin-top:0px;">			
			<tr classs="controls controls-row">
			  <td width="45%"><b>Kode</b></td>
			  <td width="1%"><b>:</b></td>
			  <td width="84%" class="input-append"><input class="span1" type="text" name="textfield" value="<?php echo $dataKode; ?>" readonly="readonly"/></td></tr>
			<tr classs="controls controls-row">
			  <td><b>Nama Kategori </b></td>
			  <td><b>:</b></td>
			  <td class="input-append"><input class="span3" type="text" name="txtkategori" value="<?php echo $DataKategori; ?>"  /></td>
			</tr>
			
		</table>
	</div>
			<div class="modal-footer">
			<button class="btn btn-primary" type="submit" name="btnSave">Simpan</button>
			</div>
		</form>
</div>
