<?php
// buka koneksi
require_once '../config/connection.php';

function Tanggal($tanggal) {
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $tahun = substr($tanggal, 0, 4);
    $bulan = substr($tanggal, 5, 2);
    $tgl = substr($tanggal, 8, 2);

    $hasil = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    return ($hasil);
}

$nomor_faktur = isset($_GET['nomor_faktur']) ? $_GET['nomor_faktur']: '';
$nomor_faktur = trim($nomor_faktur);

// sql statement
$sql = "SELECT a.nomor_faktur, a.id_supplier, id_karyawan, status_pembelian, tanggal_pembelian, jumlah_pembelian, b.id_bahan_makanan as id_bahan_makanan, nama_bahan_makanan, harga_bahan_makanan, satuan, a.id_supplier as id_supplier, nama_supplier, alamat, no_telp, email, waktu_pengiriman
        FROM pembelian_bahan_makanan a
        LEFT JOIN detail_pembelian_bahan_makanan b ON a.nomor_faktur = b.nomor_faktur
        LEFT JOIN bahan_makanan c ON c.id_bahan_makanan = b.id_bahan_makanan
        LEFT JOIN supplier d ON d.id_supplier = a.id_supplier
        WHERE a.nomor_faktur = '$nomor_faktur'
        ORDER BY tanggal_pembelian DESC";

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['nomor_faktur']      = $row['nomor_faktur'];
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['id_karyawan']        = $row['id_karyawan'];
    $sub_array['status_pembelian']  = $row['status_pembelian'];
    $sub_array['tanggal_pembelian'] = strtoupper($row['tanggal_pembelian']);
    $sub_array['jumlah_pembelian']  = $row['jumlah_pembelian'];
    $sub_array['id_bahan_makanan']     = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']   = $row['nama_bahan_makanan'];
    $sub_array['harga_bahan_makanan']  = $row['harga_bahan_makanan'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['nama_supplier']     = $row['nama_supplier'];
    $sub_array['alamat']            = $row['alamat'];
    $sub_array['no_telp']           = $row['no_telp'];
    $sub_array['email']             = $row['email'];
    $sub_array['waktu_pengiriman']  = $row['waktu_pengiriman'];

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

    if ($sub_array['tanggal_pembelian'] != NULL) {
        $sub_array['tanggal_pembelian'] = Tanggal($sub_array['tanggal_pembelian']);
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
