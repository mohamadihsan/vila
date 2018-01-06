<?php
// buka koneksi
require_once '../config/connection.php';

$sql = "SELECT DATE_FORMAT(tanggal_reservasi, '%Y') as periode FROM reservasi ORDER BY tanggal_reservasi DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_periode = $row['periode'];

// inisialisasi
$periode            = isset($_GET['periode']) ? $_GET['periode']: $data_periode;

// sql statement
$sql = "SELECT
        	x.tanggal,
        	x.jumlah_orang
        FROM
        	(
        		SELECT
        			DATE_FORMAT(r.tanggal_reservasi, '%m') AS tanggal,
        			SUM(r.jumlah_orang) AS jumlah_orang
        		FROM
        			reservasi r
        		WHERE
        			DATE_FORMAT(r.tanggal_reservasi, '%Y') = '$periode'
        		GROUP BY
        			1
        	) AS x
        ORDER BY
        	tanggal";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $periode = $row['tanggal'];
    $sub_array['periode']   = $row['tanggal'];
    $sub_array['tahun']   = $data_periode;
    $sub_array['jumlah_orang']   = $row['jumlah_orang'];

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
