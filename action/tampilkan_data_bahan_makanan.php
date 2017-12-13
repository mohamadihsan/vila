<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_bahan_makanan, nama_bahan_makanan, satuan, kategori
        FROM bahan_makanan
        ORDER BY id_bahan_makanan ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                    = $no++;
    $sub_array['id_bahan_makanan']      = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']    = ucwords($row['nama_bahan_makanan']);
    $sub_array['satuan']                = $row['satuan'];
    $sub_array['kategori']              = $row['kategori'];
	$sub_array['action']		         = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_makanan'].'\',\''.$row['nama_bahan_makanan'].'\',\''.$row['satuan'].'\',\''.$row['kategori'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_bahan_makanan'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';   
	
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>