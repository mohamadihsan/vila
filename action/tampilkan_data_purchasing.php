<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	a.supplier,
        	b.pembelian_bahan_makanan
        FROM
        	(
        		SELECT
        			COUNT(*) AS supplier
        		FROM
        			supplier
        	) AS a
        JOIN (
        	SELECT
        		COUNT(*) AS pembelian_bahan_makanan
        	FROM
        		pembelian_bahan_makanan
        ) AS b";
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['supplier']     = $row['supplier'];
    $sub_array['pembelian_bahan_makanan']   = $row['pembelian_bahan_makanan'];
    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>
