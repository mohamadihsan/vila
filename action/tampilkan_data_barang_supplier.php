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

$id_supplier = isset($_GET['id']) ? $_GET['id']: '';
$id_supplier = trim($id_supplier);

// sql statement
if ($id_supplier=='') {
    $sql = "SELECT sp.id_supplier, sp.id_bahan_makanan, b.nama_bahan_makanan, b.satuan, sp.harga
        FROM detail_supplier sp
        LEFT JOIN bahan_makanan b ON b.id_bahan_makanan = sp.id_bahan_makanan
        ORDER BY sp.id_bahan_makanan ASC";
}else{
    $sql = "SELECT sp.id_supplier, sp.id_bahan_makanan, b.nama_bahan_makanan, b.satuan, sp.harga
        FROM detail_supplier sp
        LEFT JOIN bahan_makanan b ON b.id_bahan_makanan = sp.id_bahan_makanan
        WHERE sp.id_supplier = '$id_supplier'
        ORDER BY sp.id_bahan_makanan ASC";
}

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['id_bahan_makanan']     = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']   = $row['nama_bahan_makanan'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['harga']             = Rupiah($row['harga']);
	$sub_array['action']		    = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_makanan'].'\',\''.$row['harga'].'\',\''.$row['minimal_order'].'\',\''.$row['kelipatan_order'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
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
