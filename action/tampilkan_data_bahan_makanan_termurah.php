<?php
// buka koneksi
require_once '../config/connection.php';

$id_bahan_makanan = $_GET['id_bahan_makanan'];
// sql statement
$sql = "SELECT s.id_supplier, s.nama_supplier, s.waktu_pengiriman, ds.harga
        FROM supplier s
        LEFT JOIN detail_supplier ds ON ds.id_supplier=s.id_supplier
        WHERE ds.id_bahan_makanan='$id_bahan_makanan'
        ORDER BY ds.harga, s.waktu_pengiriman ASC";
$result = mysqli_query($conn, $sql);
$data = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['id_supplier']       = $row['id_supplier'];
        $sub_array['nama_supplier']     = $row['nama_supplier'];
        $sub_array['waktu_pengiriman']  = $row['waktu_pengiriman'].' hari';
        $sub_array['harga']             = $row['harga'];

        $data[] = $sub_array;
    }
}else{
    $sub_array['id_supplier']       = '';
    $sub_array['nama_supplier']     = 'supplier tidak tersedia';
    $sub_array['waktu_pengiriman']  = '';
    $sub_array['harga']             = '';

    $data[] = $sub_array;
}


$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
