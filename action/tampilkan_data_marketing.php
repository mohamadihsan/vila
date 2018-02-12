<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	a.tamu,
        	b.reservasi
        FROM
        	(
        		SELECT
        			COUNT(*) AS tamu
        		FROM
        			tamu
        	) AS a
        JOIN (
        	SELECT
        		COUNT(*) AS reservasi
        	FROM
        		reservasi
        ) AS b";
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['tamu']     = $row['tamu'];
    $sub_array['reservasi']   = $row['reservasi'];
    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>
