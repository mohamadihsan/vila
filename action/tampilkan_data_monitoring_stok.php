<?php
// buka koneksi
require_once '../config/connection.php';

// inisialisasi
$periode    = date('m-Y');

// sql statement
$sql = "SELECT
        	x.id_bahan_makanan,
            x.nama_bahan_makanan,
        	y.sisa
        FROM
        	(
        		SELECT
                    nama_bahan_makanan,
        			id_bahan_makanan
        		FROM
        			bahan_makanan
        	) AS x
        LEFT JOIN (
        	SELECT
        		id_bahan_makanan,
        		SUM(sisa) AS sisa
        	FROM
        		persediaan_bahan_makanan
        	WHERE
        		sisa = 0
        	AND DATE_FORMAT(tanggal, '%m-%Y') = '12-2017'
        	GROUP BY
        		1
        ) AS y ON x.id_bahan_makanan = y.id_bahan_makanan";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['id_bahan_makanan']   = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']   = $row['nama_bahan_makanan'];
    $sub_array['sisa']   = $row['sisa'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
