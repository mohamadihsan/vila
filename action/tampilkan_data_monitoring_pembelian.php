<?php
// buka koneksi
require_once '../config/connection.php';

//set default bahan baku
$sql = "SELECT id_bahan_makanan FROM bahan_makanan LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_id = $row['id_bahan_makanan'];

$sql = "SELECT DATE_FORMAT(tanggal, '%Y') as periode FROM persediaan_bahan_makanan ORDER BY tanggal DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_periode = $row['periode'];

// inisialisasi
$periode            = isset($_GET['periode']) ? $_GET['periode']: $data_periode;
$id_bahan_makanan   = isset($_GET['id']) ? $_GET['id']: $data_id;

// sql statement
$sql = "SELECT
        	DATE_FORMAT(pbm.tanggal_pembelian, '%m') AS tanggal,
        	dpbm.jumlah_pembelian
        FROM
        	pembelian_bahan_makanan pbm
        LEFT JOIN detail_pembelian_bahan_makanan dpbm ON dpbm.nomor_faktur = pbm.nomor_faktur
        WHERE
        	DATE_FORMAT(pbm.tanggal_pembelian, '%Y') = '$periode'
        AND dpbm.id_bahan_makanan = '$id_bahan_makanan'
        ORDER BY
        	pbm.tanggal_pembelian ASC";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $periode = $row['tanggal'];
    $sub_array['id_bahan_makanan']   = $data_id;
    $sub_array['periode']   = $row['tanggal'];
    $sub_array['tahun']   = $data_periode;
    $sub_array['jumlah_pembelian']   = $row['jumlah_pembelian'];

    if ($periode=='01') {
        $sub_array['periode'] = 'Januari';
    }else if ($periode=='02') {
        $sub_array['periode'] = 'Februari';
    }else if ($periode=='03') {
        $sub_array['periode'] = 'Maret';
    }else if ($periode=='04') {
        $sub_array['periode'] = 'April';
    }else if ($periode=='05') {
        $sub_array['periode'] = 'Mei';
    }else if ($periode=='06') {
        $sub_array['periode'] = 'Juni';
    }else if ($periode=='07') {
        $sub_array['periode'] = 'Juli';
    }else if ($periode=='08') {
        $sub_array['periode'] = 'Agustus';
    }else if ($periode=='09') {
        $sub_array['periode'] = 'September';
    }else if ($periode=='10') {
        $sub_array['periode'] = 'Oktober';
    }else if ($periode=='11') {
        $sub_array['periode'] = 'November';
    }else if ($periode=='12') {
        $sub_array['periode'] = 'Desember';
    }

    $data[] = $sub_array;
}

$results = $data;

echo json_encode($results);
?>
