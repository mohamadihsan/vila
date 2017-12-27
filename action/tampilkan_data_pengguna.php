<?php
// buka koneksi
require_once '../config/connection.php';

$id_karyawan	= isset($_GET['id']) ? $_GET['id']: '';
$id_karyawan = trim($id_karyawan);

// sql statement
if($id_karyawan==''){
    $sql = "SELECT id_karyawan, nama_karyawan, email, divisi, nama_pengguna
            FROM pengguna
            ORDER BY id_karyawan ASC";
}else{
    $sql = "SELECT id_karyawan, nama_karyawan, email, divisi, nama_pengguna
            FROM pengguna
            WHERE id_karyawan = '$id_karyawan'";
}
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']             = $no++;
    $sub_array['id_karyawan']     = $row['id_karyawan'];
    $sub_array['nama_karyawan']   = $row['nama_karyawan'];
    $sub_array['email']          = $row['email'];
    $sub_array['divisi']        = $row['divisi'];
    $sub_array['nama_pengguna']  = $row['nama_pengguna'];
    if ($sub_array['divisi'] == "general manager") {
        $sub_array['action']	     = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_karyawan'].'\',\''.$row['nama_karyawan'].'\',\''.$row['email'].'\',\''.$row['divisi'].'\',\''.$row['nama_pengguna'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>';
    }else{
        $sub_array['action']	     = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_karyawan'].'\',\''.$row['nama_karyawan'].'\',\''.$row['email'].'\',\''.$row['divisi'].'\',\''.$row['nama_pengguna'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                         <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_karyawan'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';
    }


    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>
