<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT DISTINCT DATE_FORMAT(tanggal_pembelian, '%Y') as tahun
        FROM pembelian_bahan_makanan";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['tahun']           = $row['tahun'];
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
