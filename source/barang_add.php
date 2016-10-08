<style>
			.divDemoBody  {
				width: 300px;
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
				$('#ShowModal').bind('show', function () {
					document.getElementById ("xlInput").value = document.title;
					});
				});
			function closeDialog () {
				$('#ShowModal').modal('hide'); 
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
		if (trim($_POST['txtNmPendek'])=="") {
			$pesanError[] = "Data <b>Nama Pendek</b> Barang tidak boleh kosong !";		
		}
		if (trim($_POST['txtNmPanjang'])=="") {
			$pesanError[] = "Data <b>Nama Panjang (lengkap)</b> Barang tidak boleh kosong !";		
		}
		if (trim($_POST['cmbSatuan'])=="BLANK") {
			$pesanError[] = "Data <b>Satuan Barang</b> belum dipilih !";		
		}
		if (trim($_POST['txtKeterangan'])=="") {
			$pesanError[] = "Data <b>Keterangan</b> Barang tidak boleh kosong !";		
		}
		if (trim($_POST['txtHargaBeli'])=="" OR ! is_numeric(trim($_POST['txtHargaBeli']))) {
			$pesanError[] = "Data <b>Harga Beli (Rp)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
		}
		if (trim($_POST['txtHargaJual'])=="" OR ! is_numeric(trim($_POST['txtHargaJual']))) {
			$pesanError[] = "Data <b>Harga Jual (Rp)</b> jual tidak boleh kosong, harus diisi angka  atau 0 !";		
		}
		if (trim($_POST['txtDiskon'])=="" OR ! is_numeric(trim($_POST['txtDiskon']))) {
			$pesanError[] = "Data <b>Diskon (%)</b> Barang tidak boleh kosong, harus diisi angka atau 0 !";		
		}
		if (trim($_POST['txtStok'])=="" OR ! is_numeric(trim($_POST['txtStok']))) {
			$pesanError[] = "Data <b>Stok</b> jual tidak boleh kosong, harus diisi angka atau 0 !";		
		}
		if (trim($_POST['cmbJenis'])=="BLANK") {
			$pesanError[] = "Data <b>Jenis Barang</b> belum dipilih !";		
		}
		if (trim($_POST['cmbSupplier'])=="BLANK") {
			$pesanError[] = "Data <b>Supplier Barang</b> belum dipilih !";		
		}
		
		
		$txtBarcode		= $_POST['txtBarcode'];
		
		$txtNmPendek	= $_POST['txtNmPendek'];
		$txtNmPendek	= str_replace("'","&acute;",$txtNmPendek); 
		
		$txtNmPanjang	= $_POST['txtNmPanjang'];
		$txtNmPanjang	= str_replace("'","&acute;",$txtNmPanjang); 
		
		$cmbSatuan		= $_POST['cmbSatuan'];
		
		$txtKeterangan	= $_POST['txtKeterangan'];
		$txtKeterangan	= str_replace("'","&acute;",$txtKeterangan); 
		
		$txtHargaBeli	= $_POST['txtHargaBeli'];
		$txtHargaBeli	= str_replace(".","",$txtHargaBeli); 
		
		$txtHargaJual	= $_POST['txtHargaJual'];
		$txtHargaJual	= str_replace(".","",$txtHargaJual); 
		
		$txtDiskon		= $_POST['txtDiskon'];
		$txtStok		= $_POST['txtStok'];
		
		$cmbJenis		= $_POST['cmbJenis'];
		$cmbSupplier	= $_POST['cmbSupplier'];
		
		
		$sqlCek="SELECT * FROM barang WHERE nm_pendek='$txtNmPendek'";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$pesanError[] = "Maaf, Nama Pendek Barang <b> $txtNmPendek </b> sudah dipakai, ganti dengan yang lain";
		}


		
		if (count($pesanError)>=1 ){
			echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><p>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</p></div><br>"; 
		}
		else {
			
			$kodeBaru	= buatKode("barang", "B");
			$mySql	= "INSERT INTO barang (kd_barang, barcode, nm_pendek, nm_panjang, satuan, keterangan, harga_beli, harga_jual,
												 diskon, stok, stok_opname, kd_Jenis, kd_supplier) 
								VALUES ('$kodeBaru',
										'$txtBarcode',
										'$txtNmPendek',
										'$txtNmPanjang',
										'$cmbSatuan',
										'$txtKeterangan',
										'$txtHargaBeli',
										'$txtHargaJual',
										'$txtDiskon',
										'$txtStok',
										'$txtStok',
										'$cmbJenis',
										'$cmbSupplier')";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=TambahBarang'>";
			}
			exit;
		}

	} 
		
	
	$dataKode	= buatKode("barang", "B");
	$barcode	= substr($dataKode, -6, 6); 
	$dataBarcode= isset($_POST['txtBarcode']) ? $_POST['txtBarcode'] : $barcode;
	$dataNmPendek	= isset($_POST['txtNmPendek']) ? $_POST['txtNmPendek'] : '';
	$dataNmPanjang	= isset($_POST['txtNmPanjang']) ? $_POST['txtNmPanjang'] : '';
	$dataSatuan		= isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : '';
	$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
	$dataHargaBeli	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : '0';
	$dataHargaJual	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : '0';
	$dataDiskon 	= isset($_POST['txtDiskon']) ? $_POST['txtDiskon'] : '0';
	$dataStok		= isset($_POST['txtStok']) ? $_POST['txtStok'] : '0';
	$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
	$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
} 
?>
<div id="ShowModal"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Tambah Daftar Barang</h2>
	</div>
	<div class="modal-body">
		<form action="?page=TambahBarang" method="post" name="frmadd" target="_self">
			<table width="500" cellpadding="2" cellspacing="1" style="margin-top:0px;" ><tr>
					<td width="35%"><b>Kode Barang</b></td>
					<td width="1%"><b>:</b></td>
					<td width="" class="input-small" >
                    <input type="text" name="textfield" value="<?php echo $dataKode; ?>" readonly="readonly"/>
                    </td>
                </tr><tr>
					<td><b>Barcode</b></td>
					<td><b>:</b></td>
					<td class="input-append" ><input type="text" name="txtBarcode" value="<?php echo $dataBarcode; ?>" size="40" maxlength="20" 
							onblur="if (value == '') {value = '<?php echo $dataBarcode; ?>'}" 
							onfocus="if (value == '<?php echo $dataBarcode; ?>') {value =''}"/></td>
				</tr><tr>
					<td><b>Nama Pendek</b></td>
					<td><b>:</b></td>
					<td class="input-append" >
                    <input type="text" name="txtNmPendek" value="<?php echo $dataNmPendek; ?>" placeholder="Max.20(Char)" />
                    
                    </td>
				</tr><tr>
					<td><strong>Nama Panjang Barang </strong></td>
					<td><b>:</b></td>
					<td class="input-append" ><input type="text" name="txtNmPanjang" value="<?php echo $dataNmPanjang; ?>" size="80" maxlength="200" /></td>
				</tr><tr>
					<td><b>Keterangan</b></td>
					<td><b>:</b></td>
					<td><textarea name="txtKeterangan" cols="60" rows="2"><?php echo $dataKeterangan; ?></textarea></td>
				</tr><tr>
					<td><strong>Satuan</strong></td>
					<td><b>:</b></td>
					<td><b>
					<select name="cmbSatuan">
					<option value="BLANK">....</option>
					<?php
						include_once "library/inc.pilihan.php";
						foreach ($satuan as $nilai) {
						if ($dataSatuan == $nilai) {
							$cek=" selected";
						} else { $cek = ""; }
						echo "<option value='$nilai' $cek>$nilai</option>";
						}
					?>
					</select>
					</b></td>
				</tr><tr>
					<td><b>Harga Beli</b></td>
					<td><b>:</b></td>
					<td class="input-append">
        				<i class="add-on">Rp</i>
                        <input type="text" class="input-small" name="txtHargaBeli" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12" 
						onblur="if (value == '') {value = '0'}" 
						onfocus="if (value == '0') {value =''}"/></td>
				</tr><tr>
					<td><b>Harga Jual</b></td>
					<td><b>:</b></td>
					<td class="input-append">
        				<i class="add-on">Rp</i>
                        <input type="text" name="txtHargaJual" class="input-small" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12" 
						onblur="if (value == '') {value = '0'}" 
						onfocus="if (value == '0') {value =''}"/></td>
				</tr><tr>
					<td><b>Diskon (%) </b></td>
					<td><b>:</b></td>
					<td class="input-append" ><input type="text"  name="txtDiskon" value="<?php echo $dataDiskon; ?>" class="input-small" 
						id="appendedInput"
						onblur="if (value == '') {value = '0'}" 
						onfocus="if (value == '0') {value =''}"/>
						<span class="add-on">%</span>
					</td>
				</tr><tr>
					<td><b>Stok </b></td>
					<td><b>:</b></td>
					<td class="input-append" ><input type="text" name="txtStok" value="<?php echo $dataStok; ?>" size="10" maxlength="4" 
						class="input-small" 
						onblur="if (value == '') {value = '0'}" 
						onfocus="if (value == '0') {value =''}"/></td>
				</tr><tr>
					<td><strong>Jenis Barang </strong></td>
					<td><b>:</b></td>
					<td><select name="cmbJenis">
						<option value="BLANK"> </option>
						<?php
							$mySql = "SELECT Jenis.*, kategori.nm_kategori FROM kategori, kategori_sub, Jenis
							WHERE kategori.kd_kategori=kategori_sub.kd_kategori 
							AND kategori_sub.kd_subkategori=Jenis.kd_subkategori 
							ORDER BY kategori.kd_kategori, Jenis.kd_Jenis";
							$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
							while ($myData = mysql_fetch_array($myQry)) {
							if ($myData['kd_Jenis']== $dataJenis) {
							$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$myData[kd_Jenis]' $cek> $myData[nm_kategori]  | $myData[nm_Jenis] </option>";
							}
							$sqlData ="";
						?>
						</select>
						</td>
				</tr><tr>
					<td><b>Supplier</b></td>
					<td><b>:</b></td>
					<td><b>
						<select name="cmbSupplier">
						<option value="BLANK">....</option>
						<?php
							$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
							$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
							while ($kolomData = mysql_fetch_array($myQry)) {
							if ($dataSupplier == $kolomData['kd_supplier']) {
							$cek = " selected";
							} else { $cek=""; }
							echo "<option value='$kolomData[kd_supplier]' $cek> $kolomData[nm_supplier]</option>";
							}
							$mySql ="";
						?>
						</select>
					</b>
					</td>
				</tr>				
			</table>
		</div>
			<div class="modal-footer">
			<button class="btn btn-primary" type="submit" name="btnSave">Simpan</button>
			</form>
            </div>
</div>
	