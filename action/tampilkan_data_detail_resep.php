<?php
// buka koneksi
require_once '../config/connection.php';

$id_menu = isset($_GET['id']) ? $_GET['id']: '';
$id_menu = trim($id_menu);

// sql statement
if($id_menu==''){
    $sql = "SELECT k.id_menu, k.id_bahan_makanan, k.takaran, p.nama_menu, b.nama_bahan_makanan, b.satuan
            FROM resep k
            LEFT JOIN menu p ON p.id_menu = k.id_menu
            LEFT JOIN bahan_makanan b ON b.id_bahan_makanan = k.id_bahan_makanan
            ORDER BY k.id_menu ASC";
}else{
    $sql = "SELECT k.id_menu, k.id_bahan_makanan, k.takaran, p.nama_menu, b.nama_bahan_makanan, b.satuan
            FROM resep k
            LEFT JOIN menu p ON p.id_menu = k.id_menu
            LEFT JOIN bahan_makanan b ON b.id_bahan_makanan = k.id_bahan_makanan
            WHERE k.id_menu = '$id_menu'
            ORDER BY k.id_menu ASC";
}            
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_menu']         = $row['id_menu'].' - '.$row['nama_menu'];
    $sub_array['id_bahan_makanan']     = $row['id_bahan_makanan'].' - '.$row['nama_bahan_makanan'];
    $sub_array['takaran']           = $row['takaran'].' '.$row['satuan'];
    
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>