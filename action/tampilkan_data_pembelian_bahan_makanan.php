<?php
// buka koneksi
require_once '../config/connection.php';

$id_supplier = isset($_GET['id']) ? $_GET['id']: '';
$id_supplier = trim($id_supplier);

// sql statement
if($id_supplier==''){
    $sql = "SELECT nomor_faktur, id_supplier, id_karyawan, status_pembelian, tanggal_pembelian
            FROM pembelian_bahan_makanan
            ORDER BY tanggal_pembelian DESC";
}else{
    $sql = "SELECT nomor_faktur, id_supplier, id_karyawan, status_pembelian, tanggal_pembelian
            FROM pembelian_bahan_makanan
            WHERE id_supplier = '$id_supplier'
            ORDER BY tanggal_pembelian DESC";
}

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['nomor_faktur']      = $row['nomor_faktur'];
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['id_karyawan']        = $row['id_karyawan'];
    $sub_array['status_pembelian']  = $row['status_pembelian'];
    $sub_array['tanggal_pembelian'] = $row['tanggal_pembelian'];
	$sub_array['action']	        = ' <a href="./index.php?menu=pemesanan&faktur='.$row['nomor_faktur'].'" class="btn btn-warning btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</a>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';
    $sub_array['action_diterima']    = ' <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#terima" onclick="return terima(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-check-square bigger-120"></i> Terima</button>';

    // ubah tampilan data
    if ($sub_array['status_pembelian'] == 'SP') {
        $sub_array['status_pembelian'] = '<span class="label label-info label-white middle">
                                                sedang diproses
                                            </span>';
    }else{
        $sub_array['status_pembelian'] = '<span class="label label-info label-white middle">
                                                <i class="ace-icon fa fa-check-square bigger-120"></i>
                                                barang sudah diterima
                                            </span>';
    }

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
