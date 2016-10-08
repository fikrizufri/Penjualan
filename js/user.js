(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		
		// deklarasikan variabel
		var kd_user = 0;
		var main = "user_data.php";
		
		// tampilkan data user dari berkas user.data.php 
		// ke dalam <div id="data-user"></div>
		$("#data-user").load(main);
		
		// ketika tombol ubah/tambah di tekan
		$('.ubah, .tambah').live("click", function(){
			
			var url = "user_edit.php";
			// ambil nilai id dari tombol ubah
			kd_user = this.id;
			

			$.post(url, {id: kd_user} ,function(data) {
				// tampilkan user.form.php ke dalam <div class="modal-body"></div>
				$(".modal-body").html(data).show();
			});
		});
		
		// ketika tombol hapus ditekan
		
		
		// ketika tombol simpan ditekan
		
	});
}) (jQuery);
// JavaScript Document