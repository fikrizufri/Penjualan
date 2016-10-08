<style>
			.divDemoBody  {
				width: 60%;
				margin-left: auto;
				margin-right: auto;
				margin-top: 100px;
				}
			.divDemoBody p {
				font-size: 18px;
				line-height: 140%;
				padding-top: 12px;
				}
			.divButton {
				padding-top: 12px;
				}
				
			$(document).ready(function() {
				$('#windowTitleDialog').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#windowTitleDialog').modal('hide'); 
				};
			function okClicked () {
				document.title = document.getElementById ("xlInput").value;
				closeDialog ();
				};
 </style>
<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnSave'])){
		
		$pesanError = array();
		if (trim($_POST['txtSubkategori'])=="") {
			$pesanError[] = "Data <b>Nama Sub kategori</b> tidak boleh kosong !";		
		}
		if (trim($_POST['cmbkategori'])=="BLANK") {
			$pesanError[] = "Data <b>kategori</b> belum dipilih !";		
		}
		
		
		$txtSubkategori	= $_POST['txtSubkategori'];
		$cmbkategori= $_POST['cmbkategori'];
		
		
		$cekQry=mysql_query("SELECT * FROM kategori_sub WHERE nm_subkategori='$txtSubkategori'", $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, Sub kategori <b> $txtSubkategori </b> sudah ada, ganti dengan yang lain";
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
			include_once "kategori_sub_data.php"; 
		}
		else {
			
			$kodeBaru	= buatKode("kategori_sub", "SK");
			$mySql	= "INSERT INTO kategori_sub (kd_subkategori, nm_subkategori, kd_kategori) VALUES ('$kodeBaru','$txtSubkategori','$cmbkategori')";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataSubKategori'>";
			}
			exit;
		}	
	} 
	
	
	$dataKode	= buatKode("kategori_sub", "SK");
	$dataSubkategori	= isset($_POST['txtSubkategori']) ? $_POST['txtSubkategori'] : '';
	$DataKategori= isset($_POST['cmbkategori']) ? $_POST['cmbkategori'] : '';
}
?>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Tambah Sub Kategori</h2>
	</div>
	<div class="modal-body">
	<form action="?page=TambahSubKategori" method="post" name="frmadd" target="_self">
		<table width="450">
			<tr classs="controls controls-row">
			  <th colspan="3" ></th>
			</tr>
			<tr classs="controls controls-row">
			  <td width="53%"><b>Kode</b></td>
			  <td width="3%"><b>:</b></td>
			  <td width="44%" class="input-append"><input class="span1" type="text" name="textfield" value="<?php echo $dataKode; ?>"  readonly="readonly"/></td></tr>
			<tr classs="controls controls-row">
			  <td><b>Sub Kategori</b></td>
			  <td><b>:</b></td>
			  <td class="input-append"><input class="span3" type="text" name="txtSubkategori" value="<?php echo $dataSubkategori; ?>" /></td>
			</tr><tr>
			  <td><strong>Kategori</strong></td>
			  <td><b>:</b></td>
			  <td><select name="cmbkategori">
				<option value="BLANK"> </option>
				<?php
			  $dataSql = "SELECT * FROM kategori ORDER BY kd_kategori";
			  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
			  while ($dataRow = mysql_fetch_array($dataQry)) {
				if ($dataRow['kd_kategori']== $DataKategori) {
					$cek = " selected";
				} else { $cek=""; }
				echo "<option value='$dataRow[kd_kategori]' $cek>$dataRow[nm_kategori]</option>";
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