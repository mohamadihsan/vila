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

$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status == 'masuk') {
    $where = "WHERE barang_masuk != 0";
}else if ($status == 'keluar') {
    $where = "WHERE barang_keluar != 0";
}else{

}

// sql statement
if ($status == 'masuk' OR $status == 'keluar') {
    $sql = "SELECT p.id_bahan_makanan, p.barang_masuk, p.barang_keluar, p.sisa, p.harga_satuan, p.tanggal, bm.nama_bahan_makanan, bm.satuan
            FROM persediaan_bahan_makanan p
            LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan=p.id_bahan_makanan
            $where
            ORDER BY p.id_bahan_makanan ASC, p.tanggal DESC";
}else{
    $sql = "SELECT
            	x.id_bahan_makanan,
            	x.barang_masuk,
            	x.barang_keluar,
            	( x.barang_masuk - x.barang_keluar ) AS sisa,
            	x.harga_satuan,
            	x.tanggal,
            	x.nama_bahan_makanan,
            	x.satuan
            FROM
            	(
            SELECT
            	p.id_bahan_makanan,
            	SUM( p.barang_masuk ) AS barang_masuk,
            	SUM( p.barang_keluar ) AS barang_keluar,
            	p.harga_satuan,
            	DATE_FORMAT( p.tanggal, '%m-%Y' ) AS tanggal,
            	bm.nama_bahan_makanan,
            	bm.satuan
            FROM
            	persediaan_bahan_makanan p
            	LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan = p.id_bahan_makanan
            GROUP BY
            	1,
            	4,
            	5
            ORDER BY
            	p.id_bahan_makanan ASC,
            	tanggal DESC
            	) AS x";
}

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_bahan_makanan']  = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']= $row['nama_bahan_makanan'];
    $sub_array['barang_masuk']      = $row['barang_masuk'];
    $sub_array['barang_keluar']     = $row['barang_keluar'];
    $sub_array['sisa']              = $row['sisa'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['harga_satuan']      = Rupiah($row['harga_satuan']);
    $sub_array['tanggal']           = $row['tanggal'];
    //$sub_array['action']            = ' <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_bahan_makanan'].'\',\''.$row['tanggal'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';
    $sub_array['action']            = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_makanan'].'\',\''.$row['barang_masuk'].'\',\''.$row['barang_keluar'].'\',\''.$row['harga_satuan'].'\',\''.$row['tanggal'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_bahan_makanan'].'\',\''.$row['tanggal'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
