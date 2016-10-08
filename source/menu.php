<?php
if(isset($_SESSION['SES_ADMIN'])){

?>
<div class="nav-collapse collapse">
            <ul class="nav">
             <li><a href='?page' title='Halaman Utama'>Home</a></li>
             <li class="dropdown">             	
                <a href='' class="dropdown-toggle" data-toggle="dropdown">Master<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href='?page=DataBarang' title='Barang'>Daftar Barang</a></li>
				  <li><a href='?page=DataSupplier' title='Supplier'>Daftar Supplier</a></li>                   
				  <li><a href='?page=DataJenis' title='Data Jenis'>Daftar Jenis</a></li>
                  <li><a href='?page=DataUser' title='User Login'>Daftar User</a></li>
                  <li class="divider"></li>
		 		  <li><a href='?page=DataKategori' title='Data Kategori'>Daftar Kategori</a></li>
				  <li><a href='?page=DataSubKategori' title='Data Sub Kategori'>Daftar Sub Kategori</a></li>
                 
                </ul>
              </li>
			<li class="dropdown">             	
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pencarian<b class="caret"></b></a>
                <ul class="dropdown-menu">
                	<li><a href='?page=PencarianBarang' title='Barang'>Pencarian Dari Kategori</a></li>
					<li><a href='?page=FilterBarang' title='Barang'>Pencarian Dari Supplier</a></li>
             	</ul>
            </li>
            <li><a href='?page=StokBarang' title='Barang'>Stok</a></li>
            <li class="dropdown">             	
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tranksaksi<b class="caret"></b></a>
                <ul class="dropdown-menu">
                	<li><a href='?page=TransaksiPembelian' title='TransaksiPembelian'>Transaksi Pembelian</a> </li>
					<li><a href='?page=TransaksiRetur' title='Transaksi Retur'>Transaksi Retur</a> </li>
                    <li><a href='?page=TransaksiPengembalianBarang' title='Transaksi Retur'>Transaksi Pengembalian Barang</a> </li>
					<li><a href='?page=TransaksiPembayaran' title='Transaksi Pembayaran'>Transaksi Pembayaran</a> </li>
					<li><a href='?page=TransaksiPenjualan' title='Transaksi Penjualan'>Transaksi Penjualan</a></li>
             	</ul>
            </li>
			<li><a href='?page=Laporan' title='Laporan'>Laporan</a></li>
	        
          
    		</ul>
            <?php $mySql = "SELECT user.nm_user FROM  user 
			WHERE kd_user='".$_SESSION['SES_LOGIN']."' ";
			$myQry = mysql_query($mySql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
			$kolomData = mysql_fetch_array($myQry); ?>
            <div class="pull-right">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome,<?php echo $kolomData['nm_user']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href=""><i class="icon-cog"></i> Preferences</a></li>
                            <li><a href=""><i class="icon-envelope"></i> Contact Support</a></li>
                            <li class="divider"></li>
                            <li><a href='?page=Logout' title='Logout (Exit)'><i class="icon-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
              </div>
            
</div>

<?php
}
elseif(isset($_SESSION['SES_KASIR'])){

?>
<div class="nav-collapse collapse">
            <ul class="nav">
             <li><a href='?page' title='Halaman Utama'>Home</a></li>
            <li class="dropdown">             	
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tranksaksi<b class="caret"></b></a>
                <ul class="dropdown-menu">
                	<li><a href='?page=TransaksiPembelian' title='TransaksiPembelian'>Transaksi Pembelian</a> </li>
					<li><a href='?page=TransaksiRetur' title='Transaksi Retur'>Transaksi Retur</a> </li>
                    <li><a href='?page=TransaksiPengembalianBarang' title='Transaksi Pengembalian Barang'>Transaksi Pengembalian Barang</a> </li>
					<li><a href='?page=TransaksiPenjualan' title='Transaksi Penjualan'>Transaksi Penjualan</a></li>
             	</ul>
            </li>
    		</ul>
            <?php $mySql = "SELECT user.nm_user FROM  user 
			WHERE kd_user='".$_SESSION['SES_LOGIN']."' ";
			$myQry = mysql_query($mySql, $koneksidb)  or die ("Query penjualan salah : ".mysql_error());
			$kolomData = mysql_fetch_array($myQry); ?>
            <div class="pull-right">
                <ul class="nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome,<?php echo $kolomData['nm_user']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href=""><i class="icon-cog"></i> Preferences</a></li>
                            <li><a href=""><i class="icon-envelope"></i> Contact Support</a></li>
                            <li class="divider"></li>
                            <li><a href='?page=Logout' title='Logout (Exit)'><i class="icon-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
              </div>
            
</div>
<?php
}
else {

?>
<div class="nav-collapse collapse">
           
</div>
<?php
}
?>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>