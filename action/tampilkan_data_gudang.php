<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	a.kategori_bahan_makanan,
        	b.bahan_makanan,
        	c.permintaan_bahan,
        	d.barang_keluar,
        	e.barang_masuk
        FROM
        	(
        		SELECT
        			COUNT(*) AS kategori_bahan_makanan
        		FROM
        			kategori_bahan_makanan
        	) AS a
        JOIN (
        	SELECT
        		COUNT(*) AS bahan_makanan
        	FROM
        		bahan_makanan
        ) AS b
        JOIN (
        	SELECT
        		COUNT(*) AS permintaan_bahan
        	FROM
        		permintaan_kebutuhan_bahan_makanan
        ) AS c
        JOIN (
        	SELECT
        		COUNT(*) AS barang_keluar
        	FROM
        		persediaan_bahan_makanan
        	WHERE
        		barang_keluar != 0
        ) AS d
        JOIN (
        	SELECT
        		COUNT(*) AS barang_masuk
        	FROM
        		persediaan_bahan_makanan
        	WHERE
        		barang_masuk != 0
        ) AS e";
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['kategori_bahan_makanan']     = $row['kategori_bahan_makanan'];
    $sub_array['bahan_makanan']   = $row['bahan_makanan'];
    $sub_array['permintaan_bahan']          = $row['permintaan_bahan'];
    $sub_array['barang_masuk']        = $row['barang_masuk'];
    $sub_array['barang_keluar']  = $row['barang_keluar'];

    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>
