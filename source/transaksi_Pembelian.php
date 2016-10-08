<?php
include_once "library/inc.seslogin.php";



if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['txtKodeBarcode'])=="") {
		$pesanError[] = "Data <b>Kode barang / Barcode</b> belum diisi, harus Anda isi !";		
	}
	if (trim($_POST['txtHargaBeli'])=="" OR ! is_numeric(trim($_POST['txtHargaBeli']))) {
		$pesanError[] = "Harga Beli belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($_POST['txtJumlah'])=="" OR ! is_numeric(trim($_POST['txtJumlah']))) {
		$pesanError[] = "Data <b>Jumlah (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}

	
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKodeBarcode	= $_POST['txtKodeBarcode'];
	$txtKodeBarcode	= str_replace("'","&acute;",$txtKodeBarcode);
	
	$txtHargaBeli	= $_POST['txtHargaBeli'];
	$txtHargaBeli	= str_replace("'","&acute;",$txtHargaBeli);
	$txtHargaBeli	= str_replace(".","",$txtHargaBeli);
	
	$txtJumlah		= $_POST['txtJumlah'];


	
	$cekSql	= "SELECT supplier.* FROM barang, supplier WHERE barang.kd_supplier=supplier.kd_supplier
				AND ( kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode' )";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cekRow = mysql_fetch_array($cekQry);
	if ($cekRow['kd_supplier'] != $cmbSupplier) {
		$pesanError[] = "<b> SALAH MEMILIH SUPPLIER</b>, untuk Barang dengan kode <b>$txtKodeBarcode</b> 
						 suppliernya <b> $cekRow[kd_supplier] | $cekRow[nm_supplier]</b>";
	}
		
	
	if (count($pesanError)>=1 ){
		
		echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button>
				<strong>PERINGATAN !</strong><br>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
				
		$cekSql ="SELECT * FROM tmp_Pembelian As tmp, barang As barang 
				  WHERE barang.kd_barang=tmp.kd_barang AND ( tmp.kd_barang='$txtKodeBarcode' OR barang.barcode='$txtKodeBarcode' )
				  AND tmp.kd_user='".$_SESSION['SES_LOGIN']."'"; 
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
		if (mysql_num_rows($cekQry) >= 1) {
			
			$cekRow = mysql_fetch_array($cekQry);
			$kodeBarang	= $cekRow['kd_barang'];
			
			
			$tmpSql = "UPDATE tmp_Pembelian SET jumlah=jumlah + $txtJumlah 
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
				
				
				$tmpSql 	= "INSERT INTO tmp_Pembelian (kd_supplier, kd_barang, harga_beli, jumlah, kd_user) 
							VALUES ('$cmbSupplier','$kodeBarang','$txtHargaBeli', '$txtJumlah','".$_SESSION['SES_LOGIN']."')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());				
			}
			else {
				$pesanError[] = "Barang dengan Kode / Barcode <b>$txtKodeBarcode'</b> belum tercatat dalam daftar barang";
			}
		}
	}

}

if(isset($_POST['btnSave'])){
	$pesanError = array();
	if (trim($_POST['cmbSupplier'])=="BLANK") {
		$pesanError[] = "Data <b> Nama Supplier</b> belum diisi, pilih pada combo !";		
	}
	if (trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada combo !";		
	}

	
	
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$cmbTanggal 	= $_POST['cmbTanggal'];
			
	
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_Pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpRow = mysql_fetch_array($tmpQry);
	if ($tmpRow['qty'] < 1) {
		$pesanError[] = "Maaf...., <b>Daftar Barang</b> belum ada yang dimasukan, <b>minimal 1 data dengan supplier yang sama</b>.";
	}

	
	$tmp2Sql ="SELECT supplier.* FROM tmp_Pembelian, supplier WHERE supplier.kd_supplier=tmp_Pembelian.kd_supplier 
				AND kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmp2Qry = mysql_query($tmp2Sql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmp2Row = mysql_fetch_array($tmp2Qry);
	if ($tmp2Row['kd_supplier'] != $cmbSupplier) {
		$pesanError[] = "<b>SUPPLIER TIDAK SAMA</b>, Barang yang dimasukkan adalah milik <b>$tmp2Row[kd_supplier] - $tmp2Row[nm_supplier]</b>";
	}
			
	
	if (count($pesanError)>=1 ){
			echo "<div class='alert fade in'>
			<button type='button' class='close' data-dismiss='alert'>×</button><strong>Peringatan</strong><br />";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		
		$noTransaksi = buatKode("Pembelian", "NP");
		$mySql	= "INSERT INTO Pembelian SET 
						no_Pembelian='$noTransaksi', 
						tgl_Pembelian='".InggrisTgl($_POST['cmbTanggal'])."', 
						keterangan='$txtKeterangan', 
						kd_supplier='$cmbSupplier', 
						kd_user='".$_SESSION['SES_LOGIN']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			
			$tmpSql ="SELECT * FROM tmp_Pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
			$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
			while ($tmpRow = mysql_fetch_array($tmpQry)) {
				$dataKode 	= $tmpRow['kd_barang'];
				$dataHarga 	= $tmpRow['harga_beli'];
				$dataJumlah	= $tmpRow['jumlah'];
				
				
				$itemSql = "INSERT INTO Pembelian_detail SET 
										no_Pembelian='$noTransaksi', 
										kd_barang='$dataKode', 
										harga_beli='$dataHarga',
										jumlah='$dataJumlah'";
				mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());

				
				$stokSql = "UPDATE barang SET stok=stok + $dataJumlah, 
										stok_opname=stok_opname + $dataJumlah 
							WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Update Stok".mysql_error());
			}
			
			
			$hapusSql = "DELETE FROM tmp_Pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
			mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
			
			
			echo "<script>";
			echo "window.open('source/transaksi_Pembelian_cetak.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
			echo "</script>";
		}
		else{
			$pesanError[] = "Gagal penyimpanan ke database";
		}
	}	
}


$noTransaksi 	= buatKode("Pembelian", "NP");
$tglTransaksi 	= isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';

$kodeSupplier= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : '';
$dataSupplier= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;
?>
<div class='hero-unit'><h2 align="left">Transaksi Pembelian Barang</h2>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="frmadd">
<table width="600" cellspacing="1" class="" style="margin-top:0px;">
	
<hr>
	<tr>
	  <td width="35%"><h4>DATA TRANSAKSI</h4></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width=""><b>No Pembelian </b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="74%">
      <input type="text" class="input-small" name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/>
      </td>
    </tr>
	<tr>
      <td><b>Tanggal Pembelian </b></td>
	  <td><b>:</b></td>
	  <td class="datepicker"><input type="text" name="cmbTanggal" value="<?php echo $tglTransaksi; ?>" id="dp1"></td>
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
	<tr>
      <td><strong>Keterangan</strong></td>
	  <td><b>:</b></td>
	  <td><input type="text" name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" /></td>
    </tr>
    </table>
    <hr>
    <table  width="600" cellspacing="1" class="" style="margin-top:0px;">
	<tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td width="35%"><h4>INPUT BARANG</h4></td>
	  <td >&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td><strong>Kode Barang/Barcode </strong></td>
	  <td><b>:</b></td>
	  <td class="input-append">
	    <input type="text" class="input-small" name="txtKodeBarcode" id="txtKodeBarcode" />
        <a href="?page=PencarianBarang" class="btn" target="_blank">Cari Barang</a>
      </td>
    </tr>
	<tr>
	  <td><strong>Harga Beli</strong></td>
	  <td><b>:</b></td>
	  <td class="input-append">
        <i class="add-on">Rp</i>
	    <input  type="text" class="input-small" name="txtHargaBeli" size="18" maxlength="12" />
        
	   </td>
    </tr>
    <tr>
       <td><b>Jumlah</b></td>
       <td><b>:</b></td>
       <td ><input type="text" class="input-mini"  class="angkaC"  name="txtJumlah" size="3" maxlength="4" value="10" 
	  		 onblur="if (value == '') {value = ''}" 
      		 onfocus="if (value == '') {value =''}"/>
        
        </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-small btn-primary" /></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  
    </tr>
</table>
<hr>
<table class="table table-bordered" width="853" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th colspan="7"><h4>DAFTAR BARANG</h4></th>
    </tr>
  <tr>
    <td width="26" align="center" ><b>No</b></td>
    <td width="55" ><strong>Kode </strong></td>
    <td width="372" ><b>Nama Barang </b></td>
    <td width="122" align="center" ><strong>Harga Beli (Rp) </strong></td>
    <td width="57" align="center" ><b>Jumlah</b></td>
    <td width="116" align="center" ><strong>Subtotal (Rp)</strong></td>
    <td width="69" align="center" >&nbsp;</td>
  </tr>
	<?php 
	$tmpSql ="SELECT tmp_Pembelian.*, barang.nm_panjang FROM tmp_Pembelian, barang
			  WHERE tmp_Pembelian.kd_barang=barang.kd_barang AND tmp_Pembelian.kd_user='".$_SESSION['SES_LOGIN']."' ORDER BY id";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
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
    <td align="center"><?php echo format_angka($tmpRow['harga_beli']); ?></td>
    <td align="center"><?php echo $tmpRow['jumlah']; ?></td>
    <td align="center"><?php echo format_angka($subTotal); ?></td>
    <td align="center" ><a href="?page=DeletePembelian&amp;id=<?php echo $id; ?>" target="_self" alt="Delete" onclick="return confirm('Anda yakin menghapus <?php echo $tmpRow['nm_panjang']; ?> ... ?')"><i class="icon-trash"></i></a></td>
  </tr>
<?php 
}?>
  <tr>
  	<td></td>
    <td></td>
    <td></td>
    
    <td><p class="text-right"><b> Grand Total : </b></p></td>
    <td align="center" ><strong><?php echo $qtyItem; ?></strong></td>
    <td align="center" ><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
    <td align="center" >&nbsp;</td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>  	
    <td>
    <p class="text-right">
    <input name="btnSave" class="btn btn-primary"  type="submit" style="cursor:pointer;" value=" SIMPAN " />
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