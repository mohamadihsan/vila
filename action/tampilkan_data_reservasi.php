<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_reservasi, id_tamu, jumlah_orang, tanggal_reservasi, status_reservasi
        FROM reservasi
        ORDER BY id_reservasi ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_reservasi']      = $row['id_reservasi'];
    $sub_array['id_tamu']           = $row['id_tamu'];
    $sub_array['jumlah_orang']      = $row['jumlah_orang'];
    $sub_array['tanggal_reservasi'] = $row['tanggal_reservasi'];
    $sub_array['status_reservasi']  = $row['status_reservasi'];
    $sub_array['action']	       = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_reservasi'].'\',\''.$row['id_tamu'].'\',\''.$row['jumlah_orang'].'\',\''.$row['tanggal_reservasi'].'\',\''.$row['status_reservasi'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_reservasi'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';  

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>