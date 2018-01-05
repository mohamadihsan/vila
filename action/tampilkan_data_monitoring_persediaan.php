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
        	y.tanggal,
        	x.hasil_peramalan,
        	y.barang_keluar
        FROM
        	(
        		SELECT
        			DATE_FORMAT(periode, '%m') AS periode,
        			SUM(hasil_peramalan) AS hasil_peramalan
        		FROM
        			peramalan
        		WHERE
        			DATE_FORMAT(periode, '%Y') = '$periode'
        		AND peramalan.id_bahan_makanan = '$id_bahan_makanan'
        		GROUP BY
        			1
        	) AS x
        RIGHT JOIN (
        	SELECT
        		DATE_FORMAT(tanggal, '%m') AS tanggal,
        		SUM(barang_keluar) AS barang_keluar
        	FROM
        		persediaan_bahan_makanan
        	WHERE
        		DATE_FORMAT(tanggal, '%Y') = '$periode'
        	AND persediaan_bahan_makanan.id_bahan_makanan = '$id_bahan_makanan'
        	GROUP BY
        		1
        ) AS y ON x.periode = y.tanggal
        ORDER BY
	       periode ASC";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $periode = $row['tanggal'];
    $sub_array['periode']   = $row['tanggal'];
    $sub_array['tahun']   = $data_periode;
    $sub_array['hasil_peramalan']   = $row['hasil_peramalan'];
    $sub_array['pengeluaran']   = $row['barang_keluar'];

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
