<?php 
// route untuk manage user karyawan

session_start();

$divisi = strtolower(isset($_SESSION['divisi']) ? $_SESSION['divisi'] : '');
//$divisi 	= 'pemilik';
$menu 		= isset($_GET['menu']) ? $_GET['menu']: '';
$sub 		= isset($_GET['sub']) ? $_GET['sub']: '';
$base_url 	= 'http://127.0.0.1/vila/';
$url_api 	= 'http://127.0.0.1/vila/action/';

if ($divisi!='') {
	// load _header
	include_once '../users/_header.php';
}

switch ($divisi) {

	case 'banquet manager':
			include_once '../users/banquet-manager/_sidebar.php';
			// load content
			switch ($menu) {
				case 'bahan-makanan':
					include_once '../users/banquet-manager/bahan_makanan.php';
					break;

				case 'detail-resep':
					include_once '../users/banquet-manager/detail_resep.php';
					break;

				case 'kebutuhan_bahan_baku':
					include_once '../users/banquet-manager/kebutuhan_bahan_baku.php';
					break;

				case 'menu':
					include_once '../users/banquet-manager/menu.php';
					break;	
				
				case 'resep':
					include_once '../users/banquet-manager/resep.php';
					break;
				
				case 'peramalan':
					include_once '../users/banquet-manager/peramalan.php';
					break;

				case 'permintaan-menu':
					include_once '../users/banquet-manager/permintaan_menu.php';
					break;	
				
				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/banquet-manager/beranda.php';
					break;
			}
		break;
	
	case 'purchasing':
			include_once '../users/purchasing/_sidebar.php';
			// load content
			switch ($menu) {
				case 'bahan-makanan':
					include_once '../users/purchasing/bahan_makanan.php';
					break;

				case 'supplier':
					include_once '../users/purchasing/supplier.php';
					break;

				case 'pemesanan':
					include_once '../users/purchasing/pemesanan_bahan_makanan.php';
					break;		
				
				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/purchasing/beranda.php';
					break;
			}
		break;

	case 'staff gudang':
			include_once '../users/staff-gudang/_sidebar.php';
			// load content
			switch ($menu) {
				case 'bahan-makanan':
					include_once '../users/staff-gudang/bahan_makanan.php';
					break;

				case 'pemesanan-bahan':
					include_once '../users/staff-gudang/pemesanan_bahan.php';
					break;	
				
				case 'persediaan':
					include_once '../users/staff-gudang/persediaan.php';
					break;
				
				case 'permintaan-kebutuhan-bahan-makanan':
					include_once '../users/staff-gudang/permintaan_kebutuhan_bahan_makanan.php';
					break;
				
				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/staff-gudang/beranda.php';
					break;
			}
		break;				
	
	case 'marketing':
			include_once '../users/marketing/_sidebar.php';
			// load content
			switch ($menu) {
				case 'tamu':
					include_once '../users/marketing/tamu.php';
					break;

				case 'reservasi':
					include_once '../users/marketing/reservasi.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/marketing/beranda.php';
					break;
			}
		break;

	case 'general manager':
			include_once '../users/general-manager/_sidebar.php';
			// load content
			switch ($menu) {
				case 'peramalan':
					include_once '../users/general-manager/peramalan.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;
					
				default:
					include_once '../users/general-manager/beranda.php';
					break;
			}
		break;		
			
	default:
			include_once '../users/general-pages/login_karyawan.php';
		break;
}

if ($divisi!='') {
	// load footer
	include_once '../users/_footer.php';
}

?>