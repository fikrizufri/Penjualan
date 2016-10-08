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

if($_GET) {
	if(isset($_POST['btnSave'])){
		
		$pesanError = array();
		if (trim($_POST['txtSupplier'])=="") {
			$pesanError[] = "Data <b>Nama supplier</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtAlamat'])=="") {
			$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";		
		}
		if (trim($_POST['txtTelepon'])=="") {
			$pesanError[] = "Data <b>No Telepon</b> tidak boleh kosong !";		
		}
		
		
		$txtSupplier= $_POST['txtSupplier'];
		$txtAlamat	= $_POST['txtAlamat'];
		$txtTelepon	= $_POST['txtTelepon'];
		
		
		$cekSql="SELECT * FROM supplier WHERE nm_supplier='$txtSupplier'";
		$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
		if(mysql_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, Supplier <b> $txtSupplier </b> sudah ada, ganti dengan yang lain";
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
			include_once "supplier_data.php";
		}
		else {
			
			$kodeBaru	= buatKode("supplier", "S");
			$mySql	= "INSERT INTO supplier (kd_supplier, nm_supplier, alamat, no_telepon) 
						VALUES ('$kodeBaru',
								'$txtSupplier',
								'$txtAlamat',
								'$txtTelepon')";
			$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
			if($myQry){
				echo "<meta http-equiv='refresh' content='0; url=?page=DataSupplier'>";
			}
			exit;
		}	
	} 
	
	$dataKode	= buatKode("supplier", "S");
	$dataNama	= isset($_POST['txtSupplier']) ? $_POST['txtSupplier'] : '';
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
} 

?>
<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">&times;</a>
		<h2 class="form-signin-heading">Tambah Daftar Supplier</h2>
	</div>
	<div class="modal-body">
		<form action="?page=TambahSupplier" method="post" name="frmadd">
			<table width="437" cellpadding="2" cellspacing="1"style="margin-top:0px;">
				<tr classs="controls controls-row">
				  <td width="49%"><b>Kode</b></td>
				  <td width="3%"><b>:</b></td>
				  <td width="48%" class="input-append" ><input class="span1" type="text" name="textfield" value="<?php echo $dataKode; ?>" readonly="readonly"/>
                  </td>
                </tr>
				<tr classs="controls controls-row">
				  <td><b>Nama Supplier </b></td>
				  <td><b>:</b></td>
				  <td class="input-append"><input class="span3" type="text" name="txtSupplier" value="<?php echo $dataNama; ?>" /></td>
				</tr><tr>
				  <td><b>Alamat Lengkap </b></td>
				  <td><b>:</b></td>
				  <td class="input-append"><textarea type="text" name="txtAlamat" value="<?php echo $dataAlamat; ?>"> </textarea></td>
				</tr><tr>
				  <td classs="controls controls-row"><b>No Telepon </b></td>
				  <td><b>:</b></td>
				  <td class="input-append"><input class="span2" type="text" name="txtTelepon" value="<?php echo $dataTelepon; ?>" /></td>
				</tr>
				
				 
				
			</table>
            
	</div>
	<div class="modal-footer">
        <input type="submit" name="btnSave" value=" SIMPAN " class="btn btn-primary">
    </div> 
	    </form>
	
</div>
