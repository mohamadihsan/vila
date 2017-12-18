<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_kategori, nama_kategori
        FROM kategori_bahan_makanan
        ORDER BY id_kategori ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                    = $no++;
    $sub_array['id_kategori']      = $row['id_kategori'];
    $sub_array['nama_kategori']    = ucwords($row['nama_kategori']);
	$sub_array['action']		         = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_kategori'].'\',\''.$row['nama_kategori'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_kategori'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
