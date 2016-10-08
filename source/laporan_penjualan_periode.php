<?php
include_once "library/inc.seslogin.php";



$SqlPeriode	= ""; 
$startTgl	= ""; 
$endTgl		= "";

$tglStart 	= isset($_POST['cmbTglStart']) ? $_POST['cmbTglStart'] : "01-".date('m-Y');
$tglEnd 	= isset($_POST['cmbTglEnd']) ? $_POST['cmbTglEnd'] : date('d-m-Y');

if($_GET) {
	if (isset($_POST['btnShow'])) {
		$SqlPeriode = "( tgl_penjualan BETWEEN '".InggrisTgl($_POST['cmbTglStart'])."' AND '".InggrisTgl($_POST['cmbTglEnd'])."')";
	}
	else {
		$startTgl 	= isset($_GET['startTgl']) ? $_GET['startTgl'] : $tglStart;
		$endTgl 	= isset($_GET['endTgl']) ? $_GET['endTgl'] : $tglEnd; 
		$SqlPeriode = " ( tgl_penjualan BETWEEN '".InggrisTgl($startTgl)."' AND '".InggrisTgl($endTgl)."')";
	}
}
?>
<div class='hero-unit'><h2 align="left">Transaksi Penjualan Perpiode</h2>
</div>
<form action="?page=LaporanPenjualanPeriode" method="post" name="form1" target="_self" id="form1">
  <table width="500" border="0"  class="table table-condensed"><tr>
      <td colspan="3" ><strong>PERIODE PENJUALAN </strong></td>
    </tr><tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td class="input-append"><input name="cmbTglStart" type="text" class="datepicker" id="dp1" value="<?php echo $tglStart; ?>" />
        <i class="add-on">s/d</i>
        <input name="cmbTglEnd" type="text" lass="datepicker" id="dp2" value="<?php echo $tglEnd; ?>" /></td>
        
    </tr><tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnShow" type="submit" value=" Tampilkan " class="btn btn-primary" /></td>
    </tr>
  </table>
</form>

Daftar <strong>Transaksi Penjualan</strong> dari tanggal <b><?php echo $tglStart; ?></b> s/d <b><?php echo $tglEnd; ?></b><br />
<br />
<table class="table table-condensed" width="650" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="24" align="center" ><b>No</b></td>
    <td width="100" ><b>Tanggal</b></td>
    <td width="202" ><b>No. Penjualan</b></td>  
    <td width="118" align="center" ><strong>Qty Barang </strong></td>
    <td width="132" align="right" ><strong>Total Belanja (Rp) </strong></td>
    <td width="43" align="center" ><b>View</b></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM penjualan WHERE $SqlPeriode ORDER BY no_penjualan DESC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $kolomData['no_penjualan'];
		
		$my2Sql = "SELECT SUM(jumlah) as qty_total FROM penjualan_detail WHERE no_penjualan='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
		$my3Sql = "SELECT SUM((harga_jual - (harga_jual * diskon_jual / 100)) * jumlah) as uang_total FROM penjualan_detail WHERE no_penjualan='$noNota'";
		$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
		$kolom3Data = mysql_fetch_array($my3Qry);
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tgl_penjualan']); ?></td>
    <td><?php echo $kolomData['no_penjualan']; ?></td>
    <td align="center"><?php echo $kolom2Data['qty_total']; ?></td>
    <td align="right"><?php echo format_angka($kolom3Data['uang_total']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_penjualan_cetak.php?noNota=<?php echo $noNota; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></a></td>
  </tr>
  <?php } ?>
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