<?php
include_once "library/inc.seslogin.php";



$SqlPeriode = ""; $startTgl=""; $endTgl="";

$tglStart 	= isset($_POST['cmbTglStart']) ? $_POST['cmbTglStart'] : "01-".date('m-Y');
$tglEnd 	= isset($_POST['cmbTglEnd']) ? $_POST['cmbTglEnd'] : date('d-m-Y');

if($_GET) {
	if (isset($_POST['btnCetak'])) {
			echo "<script>";
			echo "window.open('source/cetak_laba_rugi_tanggal.php?tglStart=$tglStart&tglEnd=$tglEnd', width=330,height=330,left=100, top=25)";
			echo "</script>";
	}
	
	if (isset($_POST['btnTampil'])) {
		$SqlPeriode = "( P.tgl_penjualan BETWEEN '".InggrisTgl($_POST['cmbTglStart'])."' AND '".InggrisTgl($_POST['cmbTglEnd'])."')";
	}
	else {
		$startTgl 	= isset($_GET['startTgl']) ? $_GET['startTgl'] : $tglStart;
		$endTgl 	= isset($_GET['endTgl']) ? $_GET['endTgl'] : $tglEnd; 
		$SqlPeriode = " ( P.tgl_penjualan BETWEEN '".InggrisTgl($startTgl)."' AND '".InggrisTgl($endTgl)."')";
	}
}
?>
<div class='hero-unit'><h2 align="left">Laporan Laba Rugi</h2>
</div>
<form action="?page=LaporanLabaRugi" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-condensed"><tr>
      <td colspan="3" >&nbsp;</td>
    </tr><tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td class="input-append"><input name="cmbTglStart" type="text"  class="datepicker" id="dp1" value="<?php echo $tglStart; ?>" />
        <i class="add-on">s/d</i>
        <input name="cmbTglEnd" type="text"  class="datepicker" id="dp2" value="<?php echo $tglEnd; ?>" /></td>        
        </td>
    </tr><tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-primary" />
      <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " class="btn btn-primary" /></td>
    </tr>
  </table>
</form>

Daftar <strong>Laba Rugi per tanggal</strong>, periode : <b><?php echo $tglStart; ?></b> s/d <b><?php echo $tglEnd; ?></b><br />
<br />

<table class="table table-condensed" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
      <td width="32" align="center" ><b>No</b></td>
      <td width="90" align="center" ><strong>Tanggal</strong></td>
      <td width="68" align="center" ><b>Kode</b></td>
      <td width="200" ><b>Nama Barang</b></td>
      <td width="100" ><b>Jenis</b></td>
      <td width="70" align="center" ><b>Harga Beli</b></td>
      <td width="70" align="center" ><b>Harga Jual</b></td>
      <td width="50" align="center" ><b>Stok</b></td>
      <td width="70" align="center" ><b>Laba Satuan</b></td>
      <td width="70" align="center" ><b>Laba Barang</b></td>
  </tr>
      <?php
      $dataSql = "SELECT P.tgl_penjualan, barang.kd_barang, barang.harga_beli, barang.harga_jual, barang.stok, barang.nm_panjang, Jenis.nm_Jenis, 
           SUM(PI.jumlah) As terjual 
           FROM barang, Jenis, penjualan As P, penjualan_detail As PI
           WHERE barang.kd_barang = PI.kd_barang AND barang.kd_Jenis=Jenis.kd_Jenis
           AND P.no_penjualan = PI.no_penjualan AND $SqlPeriode
           GROUP BY barang.kd_barang, P.tgl_penjualan ORDER BY P.tgl_penjualan DESC";
   
      $dataQry = mysql_query($dataSql, $koneksidb) or die ("Error Query".mysql_error());
      $nomor = 0; $jmlh = 0;
      
      while ($dataRow = mysql_fetch_array($dataQry)) {
          $nomor++;
          $labaSatuan = $dataRow['harga_jual'] - $dataRow['harga_beli'];
          $labaBarang = $labaSatuan * $dataRow['stok'] ;
          $jmlh = $jmlh + $labaBarang;
          
      ?>
    <tr >
      <td align="center"><?php echo $nomor; ?></td>
      <td align="center"><strong><?php echo IndonesiaTgl($dataRow['tgl_penjualan']); ?></strong></td>
      <td align="center"><?php echo $dataRow['kd_barang']; ?></td>
      <td><?php echo $dataRow['nm_panjang']; ?></td>
      <td><?php echo $dataRow['nm_Jenis']; ?></td>
      <td><?php echo format_angka($dataRow['harga_beli']); ?></td>
      <td><?php echo format_angka($dataRow['harga_jual']); ?></td>
      <td><?php echo $dataRow['stok']; ?></td>
      <td align="center"><?php echo format_angka($labaSatuan); ?></td>
      <td align="center"><?php echo format_angka($labaBarang); ?></td>
    </tr>
    <?php } ?><tr>
      <td colspan="8" ><p class="text-right"><strong>Total Laba</strong><b> :</b></p></td>
      <td colspan="2" align="left" ><p class="text-right"><strong><?php echo format_angka($jmlh); ?></strong></p></td>
    </tr>
</table>
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
            
			$('#dp3').datepicker({
			format: 'dd-mm-yyyy',
                todayBtn: 'linked',
				
			});    
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