<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_tamu, nama_tamu, no_telp, email
        FROM tamu
        ORDER BY id_tamu ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']            = $no++;
    $sub_array['id_tamu']     = $row['id_tamu'];
    $sub_array['nama_tamu']   = ucwords($row['nama_tamu']);
    $sub_array['no_telp']         = $row['no_telp'];
    $sub_array['email']         = $row['email'];
    $sub_array['action']	    = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_tamu'].'\',\''.$row['nama_tamu'].'\',\''.$row['no_telp'].'\',\''.$row['email'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_tamu'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';  

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>