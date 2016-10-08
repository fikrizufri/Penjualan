<?php
include_once "library/inc.seslogin.php";

$SqlPeriode = ""; 
$startTgl	= ""; 
$endTgl		= "";

$tglStart 	= isset($_POST['cmbTglStart']) ? $_POST['cmbTglStart'] : "01-".date('m-Y');
$tglEnd 	= isset($_POST['cmbTglEnd']) ? $_POST['cmbTglEnd'] : date('d-m-Y');

if($_GET) {
	if (isset($_POST['btnShow'])) {
		$SqlPeriode = "( tgl_Pembelian BETWEEN '".InggrisTgl($_POST['cmbTglStart'])."' AND '".InggrisTgl($_POST['cmbTglEnd'])."')";
	}
	else {
		$startTgl 	= isset($_GET['startTgl']) ? $_GET['startTgl'] : $tglStart;
		$endTgl 	= isset($_GET['endTgl']) ? $_GET['endTgl'] : $tglEnd; 
		$SqlPeriode = " ( tgl_Pembelian BETWEEN '".InggrisTgl($startTgl)."' AND '".InggrisTgl($endTgl)."')";
	}
}
?>
<div class='hero-unit'><h2 align="left">Transaksi Pembelian Perperiode</h2>
</div>
<form action="?page=LaporanPembelianPeriode" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table table-condensed"><tr>
      <td colspan="3" ><strong>PERIODE Pembelian </strong></td>
    </tr><tr>
      <td width="90"><strong>Periode </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="391"  class="datepicker"><input name="cmbTglStart" type="text" value="<?php echo $tglStart; ?>" id="dp1"/>
        s/d
        <input name="cmbTglEnd" type="text" value="<?php echo $tglEnd; ?>" id="dp2"/></td>
    </tr><tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnShow" type="submit" value=" Tampilkan " class="btn btn-primary"/></td>
    </tr>
  </table>
</form>

Transaksi Pembelian dari tanggal <b><?php echo $tglStart; ?></b> s/d <b><?php echo $tglEnd; ?></b><br />
<br />

<table class="table table-condensed" width="700" border="0" cellspacing="1" cellpadding="2"><tr>
    <td width="32" align="center" ><b>No</b></td>
    <td width="90" ><b>Tanggal</b></td>
    <td width="121" ><b>No. Pembelian</b></td>  
    <td width="246" ><b>Supplier </b></td>
    <td width="130" align="right" ><strong>Qty Barang  </strong></td>
    <td width="50" align="center" ><b>View</b></td>
  </tr>
	<?php
	$mySql = "SELECT Pembelian.*, supplier.nm_supplier FROM Pembelian, supplier 
				WHERE Pembelian.kd_supplier=supplier.kd_supplier AND $SqlPeriode
				ORDER BY Pembelian.no_Pembelian ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query Pembelian salah : ".mysql_error());
	$nomor  = 0; 
	while ($myRow = mysql_fetch_array($myQry)) {
		$nomor++;
		
		$noNota = $myRow['no_Pembelian'];
		
		$my2Sql = "SELECT SUM(jumlah) as qty_barang FROM Pembelian_detail WHERE no_Pembelian='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
		$kolom2Data = mysql_fetch_array($my2Qry);
		
		
	?>
  <tr >
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myRow['tgl_Pembelian']); ?></td>
    <td><?php echo $myRow['no_Pembelian']; ?></td>
    <td><?php echo $myRow['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($kolom2Data['qty_barang']); ?></td>
    <td align="center"><a href="#" onclick="javascript:window.open('source/transaksi_Pembelian_cetak.php?noNota=<?php echo $noNota; ?>', width='900',height=330, left=0)"><i class="icon-print" ></i></td>
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