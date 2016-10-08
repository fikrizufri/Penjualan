<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		
		$pesanError = array();
		if (trim($_POST['txtJenis'])=="") {
			$pesanError[] = "Data <b>Nama Jenis</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbKategorisub'])=="BLANK") {
			$pesanError[] = "Data <b>Kategori</b> belum dipilih !";		
		}
		
		
		$txtJenis	= $_POST['txtJenis'];
		$cmbKategorisub= $_POST['cmbKategorisub'];
		
		
		if (count($pesanError)>=1 ){
            echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><p>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</p></div> <br>"; 
		}
		else {
			
			$kodeBaru	= buatKode("Jenis", "J");
			$mySql	= "INSERT INTO Jenis (kd_Jenis, nm_Jenis, kd_subkategori) VALUES ('$kodeBaru','$txtJenis','$cmbKategorisub')";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataJenis'>";
			}
			exit;
		}	
	} 
	
	$dataKode	= buatKode("Jenis", "J");
	$dataJenis	= isset($_POST['txtJenis']) ? $_POST['txtJenis'] : '';
	$dataLabel	= isset($_POST['txtLabel']) ? $_POST['txtLabel'] : '';
	$dataKategorisub= isset($_POST['cmbKategorisub']) ? $_POST['cmbKategorisub'] : '';
}
?>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Tambah Daftar Jenis</h2>
	</div>
	<div class="modal-body">
	<form action="?page=DataJenis" method="post" name="frmadd" target="_self">
		<table class="table-list" width="400" style="margin-top:0px;"><tr>
			  <td width="35%"><b>Kode</b></td>
			  <td width="1%"><b>:</b></td>
			  <td>
              <input class="span1" type="text" name="textfield" value="<?php echo $dataKode; ?>" readonly="readonly"/>								 			  </td>
              </tr><tr>
			  <td ><b>Jenis </b></td>
			  <td><b>:</b></td>
			  <td class="input-append"><input class="span3" type="text" name="txtJenis" value="<?php echo $dataJenis; ?>" /></td>
			</tr><tr>
			  <td><strong>Kategori</strong></td>
			  <td><b>:</b></td>
			  <td class="input-append"><select name="cmbKategorisub">
				<option value="BLANK"> </option>
				<?php
				$mySql = "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori, kategori_sub 
							WHERE kategori_sub.kd_kategori=kategori.kd_kategori 
							ORDER BY kd_kategori, kd_subkategori";
				$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
				while ($myData = mysql_fetch_array($myQry)) {
					if ($myData['kd_subkategori']== $dataKategorisub) {
						$cek = " selected";
					} else { $cek=""; }
					echo "<option value='$myData[kd_subkategori]' $cek> <b>$myData[nm_kategori] </b> => $myData[nm_subkategori]</option>";
				}
				$sqlData ="";
			  ?>
			  </select></td>
            </tr>
		</table>
	
	</div>
	<div class="modal-footer">
    <input type="submit" name="btnSave" value=" SIMPAN " class="btn btn-primary">
	</div>
    </form>
</div>
	