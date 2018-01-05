<?php
// buka koneksi
require_once '../config/connection.php';

// inisialisasi
$periode    = date('m-Y');
$sql = "SELECT DATE_FORMAT(tanggal, '%m-%Y') as periode FROM persediaan_bahan_makanan ORDER BY tanggal DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$periode = $row['periode'];

// sql statement
$sql = "SELECT
            x.id_bahan_makanan,
            ( x.barang_masuk - x.barang_keluar ) AS sisa,
            x.nama_bahan_makanan
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

                WHERE
                    DATE_FORMAT( p.tanggal, '%m-%Y' ) = '$periode'
                GROUP BY
                    1,
                    4,
                    5
                ORDER BY
                    p.id_bahan_makanan ASC,
                    tanggal DESC
            ) AS x
        WHERE ( x.barang_masuk - x.barang_keluar ) = 0";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['id_bahan_makanan']   = $row['id_bahan_makanan'];
    $sub_array['nama_bahan_makanan']   = $row['nama_bahan_makanan'];
    $sub_array['sisa']   = $row['sisa'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
