<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

if($_GET) {
	if(isset($_POST['btnUpdate'])){
		
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
		
		
		$sqlCek="SELECT * FROM barang WHERE nm_pendek='$txtNmPendek' AND NOT(nm_pendek='".$_POST['txtLama']."')";
		$qryCek=mysql_query($sqlCek, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($qryCek)>=1){
			$pesanError[] = "Maaf, Nama Pendek Barang <b> $txtNmPendek </b> sudah dipakai, ganti dengan yang lain";
		}
		
		
		
		if (count($pesanError)>=1 ){
            echo "<div class='mssgBox'>";
			echo "<img src='images/attention.png'> <br><hr>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			echo "</div> <br>"; 
		}
		else {
			
			$mySql	= "UPDATE barang SET barcode='$txtBarcode', 
											nm_pendek='$txtNmPendek',
											nm_panjang='$txtNmPanjang',
											satuan='$cmbSatuan',
											keterangan='$txtKeterangan',
											harga_beli='$txtHargaBeli',
											harga_jual='$txtHargaJual',
											diskon='$txtDiskon', 
											stok='$txtStok', 											 
											kd_Jenis='$cmbJenis',
											kd_supplier='$cmbSupplier'
								WHERE kd_barang ='".$_POST['txtKode']."'";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataBarang'>";
			}
			exit;
		}	
	} 
	
	
	$Kode	 = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	$myData= mysql_fetch_array($myQry);
	
		
		$dataKode	= $myData['kd_barang'];
		$dataBarcode= isset($myData['barcode']) ?  $myData['barcode'] : $_POST['txtBarcode'];
		$dataNmPendek	= isset($myData['nm_pendek']) ?  $myData['nm_pendek'] : $_POST['txtNmPendek'];
		$dataNmLama		= $myData['nm_pendek'];
		$dataNmPanjang	= isset($myData['nm_panjang']) ?  $myData['nm_panjang'] : $_POST['txtNmPanjang'];
		$dataSatuan		= isset($myData['satuan']) ?  $myData['satuan'] : $_POST['cmbSatuan'];
		$dataKeterangan	= isset($myData['keterangan']) ?  $myData['keterangan'] : $_POST['txtKeterangan']; 
		$dataHargaBeli	= isset($myData['harga_beli']) ?  $myData['harga_beli'] : $_POST['txtHargaBeli'];
		$dataHargaJual	= isset($myData['harga_jual']) ?  $myData['harga_jual'] : $_POST['txtHargaJual'];
		$dataDiskon		= isset($myData['diskon']) ?  $myData['diskon'] : $_POST['txtDiskon'];
		$dataStok		= isset($myData['stok']) ?  $myData['stok'] : $_POST['txtStok'];
		$dataJenis		= isset($myData['kd_Jenis']) ?  $myData['kd_Jenis'] : $_POST['cmbJenis'];
		$dataSupplier	= isset($myData['kd_supplier']) ?  $myData['kd_supplier'] : $_POST['cmbSupplier'] ;
}
?>
        <div class='hero-unit'><h2 align="left">Ubah Data Barang</h2>
        </div>
		<form action="?page=EditBarang" method="post" name="frmedit">
			<table class="table table-condensed" width="100%" style="margin-top:0px;">
             	<th></th>
            	<tr>
					<td width="25%"><b>Kode Barang </b></td>
					<td width="1%"><b>:</b></td>
					<td width="84%"><input name="textfield" type="text" class="input-small" value="<?php echo $dataKode; ?>" size="14" maxlength="10" 
                     readonly="readonly"/>
						<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" 
                        onblur="if (value == '') {value = '<?php echo $dataKode; ?>'}" 
					onfocus="if (value == '<?php echo $$dataKode; ?>') {value =''}"/></td>
				</tr><tr>
					<td><b>Barcode</b></td>
					<td><b>:</b></td>
					<td><input name="txtBarcode" class="input-small" value="<?php echo $dataBarcode; ?>" size="40" maxlength="20" 
					onblur="if (value == '') {value = '<?php echo $dataBarcode; ?>'}" 
					onfocus="if (value == '<?php echo $dataBarcode; ?>') {value =''}"/></td>
				</tr><tr>
					<td><b>Nama Pendek (20char) </b></td>
					<td><b>:</b></td>
					<td><input name="txtNmPendek" type="text" value="<?php echo $dataNmPendek; ?>" size="40" maxlength="20" />
						
						<input name="txtLama" type="hidden" value="<?php echo $dataNmLama; ?>" placeholder="Max.20(Char)"/>
					</td>
				</tr><tr>
					 <td><strong>Nama Panjang Barang </strong></td>
					 <td><b>:</b></td>
					 <td><input name="txtNmPanjang" type="text" class="input-large" value="<?php echo $dataNmPanjang; ?>" size="80" maxlength="200" /></td>
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
				  <td><b>Harga Beli (Rp) </b></td>
				  <td><b>:</b></td>
				  <td><input name="txtHargaBeli" type="text" class="input-medium" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12" /></td>
				</tr><tr>
				  <td><b>Harga Jual (Rp) </b></td>
				  <td><b>:</b></td>
				  <td><input name="txtHargaJual" type="text" class="input-medium" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12" /></td>
				</tr><tr>
				  <td><b>Diskon (%) </b></td>
				  <td><b>:</b></td>
				  <td class="input-append" ><input type="text" class="input-small" name="txtDiskon" value="<?php echo $dataDiskon; ?>" size="10" maxlength="4" />
				  <span class="add-on">%</span></td>
				</tr><tr>
				  <td><b>Stok</b></td>
				  <td><b>:</b></td>
				  <td><input name="txtStok" type="text" class="input-small" value="<?php echo $dataStok; ?>" size="10" maxlength="30" /></td>
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
				  </select></td>
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
				  </b></td>
				</tr><tr><td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td><input name="btnUpdate" type="submit" class="btn btn-primary"  value=" Update " />
                  		
                  </td>
				</tr>
			</table>
		</form>
