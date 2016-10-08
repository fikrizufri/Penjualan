<?php

if($_GET) {
	
	switch ($_GET['page']){				
		case '' :				
			if(!file_exists ("source/main.php")) die ("Empty Main Page!"); 
			include "source/main.php";	break;
			
		case 'HalamanUtama' :				
			if(!file_exists ("source/main.php")) die ("Sorry Empty Page!"); 
			include "source/main.php";	break;
			
		case 'Login' :				
			if(!file_exists ("source/login.php")) die ("Sorry Empty Page!"); 
			include "source/login.php"; break;
			
		case 'ValidasiLogin' :				
			if(!file_exists ("source/login_validasi.php")) die ("Sorry Empty Page!"); 
			include "source/login_validasi.php"; break;
			
		case 'Logout' :				
			if(!file_exists ("source/login_out.php")) die ("Sorry Empty Page!"); 
			include "source/login_out.php"; break;		

		
		case 'DataUser' :
			if(!file_exists ("source/user_data.php")) die ("Sorry Empty Page!"); 
			include "source/user_data.php";	 break;	
		case 'TambahUser' :
			if(!file_exists ("source/user_add.php")) die ("Sorry Empty Page!"); 
			include "source/user_add.php";	 break;		
		case 'DeleteUser' :
			if(!file_exists ("source/user_delete.php")) die ("Sorry Empty Page!"); 
			include "source/user_delete.php"; break;		
		case 'EditUser' :				
			if(!file_exists ("source/user_edit.php")) die ("Sorry Empty Page!"); 
			include "source/user_edit.php"; break;	

		
		case 'DataKategori' :
			if(!file_exists ("source/kategori_data.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_data.php"; break;		
		case 'Tambahkategori' :
			if(!file_exists ("source/kategori_add.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_add.php";	break;		
		case 'Deletekategori' :
			if(!file_exists ("source/kategori_delete.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_delete.php"; break;		
		case 'EditKategori' :				
			if(!file_exists ("source/kategori_edit.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_edit.php"; break;	
			
		
		case 'DataSubKategori' :
			if(!file_exists ("source/kategori_sub_data.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_sub_data.php"; break;		
		case 'TambahSubKategori' :
			if(!file_exists ("source/kategori_sub_add.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_sub_add.php";	break;		
		case 'DeleteSubKategori' :
			if(!file_exists ("source/kategori_sub_delete.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_sub_delete.php"; break;		
		case 'EditSubKategori' :				
			if(!file_exists ("source/kategori_sub_edit.php")) die ("Sorry Empty Page!"); 
			include "source/kategori_sub_edit.php"; break;	

		
		case 'DataJenis' :
			if(!file_exists ("source/Jenis_data.php")) die ("Sorry Empty Page!"); 
			include "source/Jenis_data.php"; break;		
		case 'TambahJenis' :
			if(!file_exists ("source/Jenis_add.php")) die ("Sorry Empty Page!"); 
			include "source/Jenis_add.php";	break;		
		case 'DeleteJenis' :
			if(!file_exists ("source/Jenis_delete.php")) die ("Sorry Empty Page!"); 
			include "source/Jenis_delete.php"; break;		
		case 'EditJenis' :				
			if(!file_exists ("source/Jenis_edit.php")) die ("Sorry Empty Page!"); 
			include "source/Jenis_edit.php"; break;	
			
		
		case 'PencarianBarang' :
			if(!file_exists ("source/barang_pencarian.php")) die ("Sorry Empty Page!"); 
			include "source/barang_pencarian.php"; break;		
		case 'FilterBarang' :
			if(!file_exists ("source/barang_filter.php")) die ("Sorry Empty Page!"); 
			include "source/barang_filter.php"; break;		
		case 'DataBarang' :
			if(!file_exists ("source/barang_data.php")) die ("Sorry Empty Page!"); 
			include "source/barang_data.php"; break;		
		case 'TambahBarang' :
			if(!file_exists ("source/barang_data.php")) die ("Sorry Empty Page!"); 
			include "source/barang_data.php"; break;		
		case 'DeleteBarang' :
			if(!file_exists ("source/barang_delete.php")) die ("Sorry Empty Page!"); 
			include "source/barang_delete.php"; break;		
		case 'EditBarang' :				
			if(!file_exists ("source/barang_edit.php")) die ("Sorry Empty Page!"); 
			include "source/barang_edit.php"; break;	

		case 'Barcode' :				
			if(!file_exists ("source/barcode128_print.php")) die ("Sorry Empty Page!"); 
			include "source/barcode128_print.php"; break;
			
		case 'Print' :				
			if(!file_exists ("cetak/barang_view.php")) die ("Sorry Empty Page!"); 
			include "cetak/barang_view.php"; break;
	
		case 'StokBarang' :
			if(!file_exists ("source/barang_stok_kontrol.php")) die ("Sorry Empty Page!"); 
			include "source/barang_stok_kontrol.php"; break;
		
		case 'EditStokBarang' :
			if(!file_exists ("source/barang_stok_edit.php")) die ("Sorry Empty Page!"); 
			include "source/barang_stok_edit.php"; break;		

		
		case 'DataSupplier' :
			if(!file_exists ("source/supplier_data.php")) die ("Sorry Empty Page!"); 
			include "source/supplier_data.php";	 break;		
		case 'TambahSupplier' :
			if(!file_exists ("source/supplier_add.php")) die ("Sorry Empty Page!"); 
			include "source/supplier_add.php";	 break;		
		case 'DeleteSupplier' :
			if(!file_exists ("source/supplier_delete.php")) die ("Sorry Empty Page!"); 
			include "source/supplier_delete.php"; break;		
		case 'EditSupplier' :				
			if(!file_exists ("source/supplier_edit.php")) die ("Sorry Empty Page!"); 
			include "source/supplier_edit.php"; break;	

		
		case 'TransaksiPembelian' :
			if(!file_exists ("source/transaksi_Pembelian.php")) die ("Sorry Empty Page!"); 
			include "source/transaksi_Pembelian.php"; break;
		case 'DeletePembelian' :
			if(!file_exists ("source/Pembelian_delete.php")) die ("Sorry Empty Page!"); 
			include "source/Pembelian_delete.php"; break;		
		case 'TransaksiRetur' :
			if(!file_exists ("source/transaksi_retur.php")) die ("Sorry Empty Page!"); 
			include "source/transaksi_retur.php"; break;
		case 'DeleteRetur' :
			if(!file_exists ("source/retur_delete.php")) die ("Sorry Empty Page!"); 
			include "source/retur_delete.php"; break;
			case 'TransaksiPengembalianBarang' :
			if(!file_exists ("source/transaksi_pengembalian.php")) die ("Sorry Empty Page!"); 
			include "source/transaksi_pengembalian.php"; break;
		case 'TransaksiPengembalianBarang' :
			if(!file_exists ("source/retur_deleteback.php")) die ("Sorry Empty Page!"); 
			include "source/retur_deleteback.php"; break;		
		case 'TransaksiPenjualan' :
			if(!file_exists ("source/transaksi_penjualan.php")) die ("Sorry Empty Page!"); 
			include "source/transaksi_penjualan.php"; break;
		case 'DeletePenjualan' :
			if(!file_exists ("source/penjualan_delete.php")) die ("Sorry Empty Page!"); 
			include "source/penjualan_delete.php"; break;
		case 'TransaksiPembayaran' :
			if(!file_exists ("source/transaksi_Pembayaran.php")) die ("Sorry Empty Page!"); 
			include "source/transaksi_Pembayaran.php"; break;
		case 'DaftarPembayaran' :
			if(!file_exists ("source/pembayaran_list.php")) die ("Sorry Empty Page!"); 
			include "source/pembayaran_list.php"; break;
		case 'DeletePembayaran' :
			if(!file_exists ("source/pembayaran_delete.php")) die ("Sorry Empty Page!"); 
			include "source/pembayaran_delete.php"; break;		
						
		case 'PrintBarang' :				
				if(!file_exists ("source/barang_view.php")) die ("Sorry Empty Page!"); 
				include "source/barang_view.php"; break;
		case 'PrintPenjualan' :				
				if(!file_exists ("source/transaksi_penjualan_nota.php")) die ("Sorry Empty Page!"); 
				include "source/transaksi_penjualan_nota.php"; break;
		
		case 'PagePembayaran' :
			if(!file_exists ("source/pagepembayaran.php")) die ("Sorry Empty Page!"); 
			include "source/pagepembayaran.php"; break;						
		case 'Laporan' :				
				if(!file_exists ("source/menu_laporan.php")) die ("Sorry Empty Page!"); 
				include "source/menu_laporan.php"; break;
			
			case 'LaporanUser' :				
				if(!file_exists ("source/laporan_user.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_user.php"; break;
	
			case 'LaporanSupplier' :				
				if(!file_exists ("source/laporan_supplier.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_supplier.php"; break;
				
			case 'LaporanKategori' :				
				if(!file_exists ("source/laporan_kategori.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_kategori.php"; break;
				
			case 'LaporanKategoriSub' :				
				if(!file_exists ("source/laporan_kategori_sub.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_kategori_sub.php"; break;
				
			case 'LaporanJenis' :				
				if(!file_exists ("source/laporan_Jenis.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_Jenis.php"; break;

			case 'LaporanBarang' :				
				if(!file_exists ("source/laporan_barang.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_barang.php"; break;
					
			case 'LaporanBarangByKategori' :				
				if(!file_exists ("source/laporan_barang_by_kategori.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_barang_by_kategori.php"; break;
				
			case 'LaporanBarangBySupplier' :				
				if(!file_exists ("source/laporan_barang_by_supplier.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_barang_by_supplier.php"; break;
			
			
			case 'LaporanPenjualan' :				
				if(!file_exists ("source/laporan_penjualan.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_penjualan.php"; break;
			case 'LaporanPenjualanPeriode' :				
				if(!file_exists ("source/laporan_penjualan_periode.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_penjualan_periode.php"; break;
			case 'LaporanPenjualanTanggal' :				
				if(!file_exists ("source/laporan_penjualan_tanggal.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_penjualan_tanggal.php"; break;
			case 'LaporanPenjualanJenis' :				
				if(!file_exists ("source/laporan_penjualan_Jenis.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_penjualan_Jenis.php"; break;
			case 'LaporanPenjualanSupplier' :				
				if(!file_exists ("source/laporan_penjualan_supplier.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_penjualan_supplier.php"; break;
			case 'LaporanLabaRugi' :				
				if(!file_exists ("source/laporan_laba_rugi_tanggal.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_laba_rugi_tanggal.php"; break;
			
			
			case 'LaporanPembelian' :				
				if(!file_exists ("source/laporan_Pembelian.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_Pembelian.php"; break;
			case 'LaporanPembelianPeriode' :				
				if(!file_exists ("source/laporan_Pembelian_periode.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_Pembelian_periode.php"; break;

			
			case 'LaporanRetur' :				
				if(!file_exists ("source/laporan_retur.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_retur.php"; break;				
			case 'LaporanPengembalianBarang' :				
				if(!file_exists ("source/laporan_pengembalian.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_pengembalian.php"; break;
				
			case 'LaporanPembayaran' :				
				if(!file_exists ("source/laporan_pembayaran.php")) die ("Sorry Empty Page!"); 
				include "source/laporan_pembayaran.php"; break;
				
			
			case 'Cetak-Barcode' :				
				if(!file_exists ("source/barcode_buku.php")) die ("Sorry Empty Page!"); 
				include "source/barcode_buku.php"; break;
				
		default:
			if(!file_exists ("source/main.php")) die ("Empty Main Page!"); 
			include "source/main.php";						
		break;
	}
}
else {
	
	if(!file_exists ("source/main.php")) die ("Empty Main Page!"); 
	include "source/main.php";	
}
?>