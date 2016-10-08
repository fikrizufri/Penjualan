<?php
include_once "library/inc.seslogin.php";



if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['txtKodeBarcode'])=="") {
		$pesanError[] = "<b>Kode Barang / Barcode  belum diisi</b>, ketik secara manual atau dari <b>barcode reader</b>";		
	}
	if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
		$pesanError[] = "<b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKodeBarcode	= $_POST['txtKodeBarcode'];
	$txtKodeBarcode	= str_replace("'","&acute;",$txtKodeBarcode);
	
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtKeterangan = str_replace("'","&acute;",$txtKeterangan);
	
	$txtJumlah	= $_POST['txtJumlah'];


	
	$cekSql	= "SELECT supplier.* FROM barang, supplier WHERE barang.kd_supplier=supplier.kd_supplier
				AND ( kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode' )";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cekRow = mysql_fetch_array($cekQry);
	if ($cekRow['kd_supplier'] != $cmbSupplier) {
		$pesanError[] = "<b> SALAH MEMILIH SUPPLIER</b>, untuk Barang dengan kode
			<b>$txtKodeBarcode</b> suppliernya <b> $cekRow[kd_supplier] | $cekRow[nm_supplier]</b>!";
	}

	
	$cek2Sql	= "SELECT stok_opname FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
	$cek2Qry = mysql_query($cek2Sql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cek2Row = mysql_fetch_array($cek2Qry);
	if ($cek2Row['stok_opname'] < $txtJumlah) {
		$pesanError[] = "<b>Stok Opname</b> untuk kode <b>$txtKodeBarcode</b> adalah <b> $cek2Row[stok_opname]</b>, jadi tidak dapat diretur!";
	}

	
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><br/>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
				
		$cekSql ="SELECT * FROM tmp_retur As tmp, barang 
				  WHERE barang.kd_barang=tmp.kd_barang AND ( barang.kd_barang='$txtKodeBarcode' OR barang.barcode='$txtKodeBarcode' )
				  AND tmp.kd_user='".$_SESSION['SES_LOGIN']."'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			
			$cekRow = mysql_fetch_array($cekQry);
			$kodeBarang	= $cekRow['kd_barang'];

			
			$tmpSql = "UPDATE tmp_retur SET jumlah=jumlah + $txtJumlah 
						WHERE kd_barang='$kodeBarang' AND kd_user='".$_SESSION['SES_LOGIN']."'";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
		}
		else {
			
			$mySql ="SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
			$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			$myRow = mysql_fetch_array($myQry);
			$myQty = mysql_num_rows($myQry);
			if ($myQty >= 1) {
				
				$kodeBarang	= $myRow['kd_barang'];
				
				
				$tmpSql 	= "INSERT INTO tmp_retur (kd_supplier, kd_barang, jumlah, keterangan, kd_user) 
							VALUES ('$cmbSupplier','$kodeBarang', '$txtJumlah','$txtKeterangan','".$_SESSION['SES_LOGIN']."')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
				$txtKodeBarcode	= "";
				$txtJumlah	= "";
				$txtKeterangan = "";
			}
			else {
				$pesanError[] = "Tidak ada barang dengan kode <b>$txtKodeBarcode'</b>, silahkan ganti";
			}
		}
	}

}


if(isset($_POST['btnSave'])){
	$pesanError = array();
	if (trim($_POST['cmbSupplier'])=="BLANK") {
		$pesanError[] = "Data <b>Nama supplier</b> belum dipilih, silahkan pilih lagi !";		
	}
	if (trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada combo !";		
	}
	
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$cmbTanggal 	= $_POST['cmbTanggal'];

	
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_retur WHERE  kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpRow = mysql_fetch_array($tmpQry);
	if ($tmpRow['qty'] < 1) {
		$pesanError[] = "Daftar <b>Item barang</b> belum ada yang dimasukan, <b>minimal 1 barang</b>.";
	}

	
	$tmp2Sql ="SELECT supplier.* FROM tmp_retur, supplier WHERE supplier.kd_supplier=tmp_retur.kd_supplier 
				AND kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmp2Qry = mysql_query($tmp2Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmp2Row = mysql_fetch_array($tmp2Qry);
	if ($tmp2Row['kd_supplier'] != $cmbSupplier) {
		$pesanError[] = "<b>SUPPLIER TIDAK SAMA</b>, Barang yang dimasukkan adalah milik <b>$tmp2Row[kd_supplier] - $tmp2Row[nm_supplier]</b>.";
	}
		
	
	if (count($pesanError)>=1 ){
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><br/>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		
		$noNota	= buatKode("retur", "RB");
		$mySql	= "INSERT INTO retur (no_retur, tgl_retur, kd_supplier, kd_user) 
					VALUES ('$noNota', 
							'".InggrisTgl($_POST['cmbTanggal'])."',
							'$cmbSupplier',
							'".$_SESSION['SES_LOGIN']."')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			
			$tmp3Sql ="SELECT * FROM tmp_retur WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
			$tmp3Qry = mysql_query($tmp3Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while ($tmp3Row = mysql_fetch_array($tmp3Qry)) {
				
				$mySql = "INSERT INTO retur_detail (no_retur, kd_barang, jumlah, keterangan)
								VALUES ('$noNota', 
										'$tmp3Row[kd_barang]', 
										'$tmp3Row[jumlah]', 
										'$tmp3Row[keterangan]')";
				mysql_query($mySql, $koneksidb) or die ("Gagal Query Simpan detail".mysql_error());

				
				$mySql = "UPDATE barang SET stok=stok - $tmp3Row[jumlah] WHERE kd_barang='$tmp3Row[kd_barang]'";
				mysql_query($mySql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}
			
			mysql_query("DELETE FROM tmp_retur WHERE kd_user='".$_SESSION['SES_LOGIN']."'", $koneksidb) 
					or die ("Gagal kosongkan tmp".mysql_error());
			
			
			echo "<script>";
			echo "window.open('source/transaksi_retur_cetak.php?noNota=$noNota', width=330,height=330,left=100, top=25)";
			echo "</script>";
		}
		else{
			$pesanError[] = "Gagal penyimpanan ke database";
		}
	}	
} 

$nomorTransaksi = buatKode("retur", "RB");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');

$kodeSupplier= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : '';
$dataSupplier= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;
?>
<div class='hero-unit'><h2 align="left">Transaksi Retur Ke Suppiler</h2>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="600" cellspacing="1" class="" style="margin-top:0px;">
	
	<tr>
	  <td width="35%"><h4>DATA TRANSAKSI</h4></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="%"><b>No. Retur </b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="">
      <input type="text" class="input-small" name="txtNomor" value="<?php echo $nomorTransaksi; ?>" readonly="readonly"/>
      </td>
    </tr>
	<tr>
      <td><b>Tgl.  Retur </b></td>
	  <td><b>:</b></td>
	  <td class="datepicker"><input type="text" name="cmbTanggal" class="tcal" value="<?php echo $tglTransaksi; ?>" id="dp1" /></td>
    </tr>
	<tr>
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
	  	echo "<option value='$kolomData[kd_supplier]' $cek>[ $kolomData[kd_supplier] ] $kolomData[nm_supplier]</option>";
	  }
	  $mySql ="";
	  ?>
        </select>
	  </b></td>
    </tr>
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	 </table>
    <hr>
  <table  width="600" cellspacing="1" class="" style="margin-top:0px;">
	<tr>
	  <td width="35%"><h4>INPUT BARANG</h4></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode Barang / Barcode </strong></td>
	  <td><b>:</b></td>
	  <td class="input-append">
	    <input type="text" class="input-small" name="txtKodeBarcode" id="txtKodeBarcode" />
        <a href="?page=PencarianBarang" class="btn" target="_blank">Cari Barang</a>
      </td>
    </tr>
    <tr>
	  <td><b>Jumlah</b></td>
      <td><b>:</b></td>
      <td>		
		<input type="text" class="input-small" class="angkaC" name="txtJumlah"  
					 onblur="if (value == '') {value = '1'}" 
					 onfocus="if (value == '1') {value =''}"/>
		
      </td>
    </tr>
	<tr>
	  <td><b>Keterangan</b></td>
      <td><b>:</b></td>
      <td><b>
        <input name="txtKeterangan" size="35" maxlength="40" />
      </b></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	 
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <td><input name="btnTambah" type="submit" class="btn btn-primary"style="cursor:pointer;" value=" Tambah " class="btn btn-small btn-primary" /></td>
    </tr>
</table>
<hr>
<table class="table table-bordered" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="5">DAFTAR BARANG </th>
  </tr>
  <tr>
    <td width="37" align="center" ><b>No</b></td>
    <td width="100" ><strong>Kode </strong></td>
    <td width="545" ><b>Nama Barang </b></td>
    <td width="76" align="center" ><b>Jumlah</b></td>
    <td width="16" align="center" >&nbsp;</td>
  </tr>
  <?php
	//  tabel menu 
	$tmpSql ="SELECT tmp_retur.*, barang.*
			  FROM tmp_retur, barang 
			  WHERE tmp_retur.kd_barang=barang.kd_barang AND tmp_retur.kd_user='".$_SESSION['SES_LOGIN']."' ORDER BY id";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0; $qtyItem = 0;
	$nomor=0; $subTotal=0; $totalBelanja = 0; $qtyItem = 0; 
	while($tmpRow = mysql_fetch_array($tmpQry)) {
		$id		= $tmpRow['id'];
		$qtyItem= $qtyItem + $tmpRow['jumlah'];
		$subTotal		= $tmpRow['harga_beli'] * $tmpRow['jumlah'];
		$totalBelanja	= $totalBelanja + $subTotal;
		
		$nomor++;
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $tmpRow['kd_barang']; ?></td>
    <td><?php echo $tmpRow['nm_panjang']; ?></td>
    <td align="center"><?php echo $tmpRow['jumlah']; ?></td>
    <td align="center" ><a href="?page=DeleteRetur&amp;id=<?php echo $id; ?>" target="_self" alt="Delete" onclick="return confirm('Anda yakin menghapus <?php echo  $tmpRow['nm_panjang']; ?> ... ?')"><i class="icon-trash"></i></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
    <td><b><p class="text-right">Total Barang :</p></b></td>
    <td align="right"  ><?php echo $qtyItem; ?></td>
    <td align="center" >&nbsp;</td>
    
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
    <p class="text-right">
    <input name="btnSave" class="btn btn-primary"  type="submit" style="cursor:pointer;" value="SIMPAN " />
    </p>
    </td>
   </tr>
</table>

</form>
<script>
$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});
            
			$('#dp2').datepicker({
				format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});            
            
			$('#dp3').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});
                
            //inline    
            $('#dp6').datepicker({
                todayBtn: 'linked'
            });
                
            $('#btn6').click(function(){
                $('#dp6').datepicker('update', '15-05-1984');
            });            
            
            $('#btn7').click(function(){
                $('#dp6').data('datepicker').date = null;
                $('#dp6').find('.active').removeClass('active');                
            });            
		});

</script>