<?php
// buka koneksi
require_once '../config/connection.php';

function Tanggal($tanggal) {
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $tahun = substr($tanggal, 0, 4);
    $bulan = substr($tanggal, 5, 2);
    $tgl = substr($tanggal, 8, 2);

    $hasil = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    return ($hasil);
}

$id_reservasi = isset($_GET['id']) ? $_GET['id']: '';

// sql statement
if($id_reservasi==''){
    $sql = "SELECT
            	r.id_reservasi,
            	r.id_tamu,
            	r.jumlah_orang,
            	r.status_reservasi,
            	r.tanggal_reservasi,
            	pm.status_permintaan
            FROM
            	reservasi r
            LEFT JOIN permintaan_menu_makanan pm ON pm.id_reservasi = r.id_reservasi
            WHERE
            	r.status_reservasi = '1'
            ORDER BY
            	r.tanggal_reservasi DESC";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                = $no++;
        $sub_array['id_reservasi']      = $row['id_reservasi'];
        $sub_array['id_tamu']      = $row['id_tamu'];
        $sub_array['jumlah_orang']        = $row['jumlah_orang'];
        $sub_array['status_reservasi']  = $row['status_reservasi'];
        $sub_array['status_permintaan']  = $row['status_permintaan'];
        $sub_array['tanggal_reservasi'] = $row['tanggal_reservasi'];
    	$sub_array['action']	        = ' <a href="./index.php?menu=permintaan-menu&id='.$row['id_reservasi'].'" type="button" class="btn btn-warning btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</a>';

        // ubah tampilan data
        if ($sub_array['status_reservasi'] == 0) {
            $sub_array['status_reservasi'] = '<span class="label label-warning label-white middle">
                                                    <i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>
                                                    tidak valid
                                                </span>';
        }else{
            $sub_array['status_reservasi'] = '<span class="label label-success label-white middle">
                                                    <i class="ace-icon fa fa-check-square bigger-120"></i>
                                                    vaild
                                                </span>';
        }

        if ($sub_array['status_permintaan'] == 'p') {
            $sub_array['status_permintaan'] = '<span class="label label-warning label-white middle">
                                                    <i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>
                                                    belum selesai
                                                </span>';
        }else{
            $sub_array['status_permintaan'] = '<span class="label label-success label-white middle">
                                                    <i class="ace-icon fa fa-check-square bigger-120"></i>
                                                    selesai
                                                </span>';
        }

        if ($sub_array['tanggal_reservasi'] != NULL) {
            $sub_array['tanggal_reservasi'] = Tanggal($sub_array['tanggal_reservasi']);
        }

        $data[] = $sub_array;
    }
}else{
    $sql = "SELECT
            	r.id_reservasi,
            	r.id_tamu,
            	r.jumlah_orang,
            	r.status_reservasi,
            	r.tanggal_reservasi,
            	pm.status_permintaan,
            	dpm.harga,
            	dpm.id_menu,
            	m.nama_menu,
            	dpm.jumlah_pemesanan
            FROM
            	reservasi r
            LEFT JOIN permintaan_menu_makanan pm ON pm.id_reservasi = r.id_reservasi
            LEFT JOIN detail_permintaan_menu_makanan dpm ON dpm.id_permintaan_menu_makanan = pm.id_permintaan_menu_makanan
            LEFT JOIN menu m ON m.id_menu = dpm.id_menu
            WHERE
            	r.status_reservasi = '1'
            AND r.id_reservasi = '$id_reservasi'";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                = $no++;
        $sub_array['id_menu']      = $row['id_menu'];
        $sub_array['nama_menu']      = $row['nama_menu'];
        $sub_array['jumlah_pemesanan']      = $row['jumlah_pemesanan'];

        $data[] = $sub_array;
    }
}


$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
