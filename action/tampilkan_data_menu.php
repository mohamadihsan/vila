<?php
// buka koneksi
require_once '../config/connection.php';

function Rupiah($rupiah) {
    //format rupiah
    $jumlah_desimal = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan = ".";

    $hasil = number_format($rupiah, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
    return 'Rp.'.($hasil);
}

// sql statement
$sql = "SELECT id_menu, nama_menu, harga, gambar_menu
        FROM menu
        ORDER BY id_menu ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']            = $no++;
    $sub_array['id_menu']     = $row['id_menu'];
    $sub_array['nama_menu']   = ucwords($row['nama_menu']);
    $sub_array['harga']         = Rupiah($row['harga']);
    $sub_array['gambar_menu'] = '<img src="../assets/images/'.$row['gambar_menu'].'" alt="menu" class="img-responsive" width="80px" height="80px" >';
    $sub_array['nama_file_gambar'] = $row['gambar_menu'];
	$sub_array['action']	    = ' <a class="btn btn-success btn-xs" href="./index.php?id='.$row['id_menu'].'&menu=detail-resep"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Resep</a>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_menu'].'\',\''.$row['nama_menu'].'\',\''.$row['harga'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_menu'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
