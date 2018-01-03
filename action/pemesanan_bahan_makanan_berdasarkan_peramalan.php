<?php
// buka koneksi
require_once '../config/connection.php';

$peramalan      = $_GET['peramalan'];
if($peramalan=='true'){

    $periode      = $_GET['periode'];

    // jumlah peramalan
    $sql = "SELECT
            	p.id_bahan_makanan,
            	bm.nama_bahan_makanan,
            	SUM( p.hasil_peramalan ) AS hasil_peramalan,
            	bm.satuan
            FROM
            	peramalan p
            	LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan = p.id_bahan_makanan
            WHERE
            	DATE_FORMAT( p.periode, '%m-%Y' ) = '$periode' 
            GROUP BY
            	1";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            $sub_array['id_bahan_makanan']         = $row['id_bahan_makanan'];
            $sub_array['nama_bahan_makanan']       = $row['nama_bahan_makanan'];
            $sub_array['satuan']                = $row['satuan'];
            $sub_array['hasil_peramalan']       = $row['hasil_peramalan'];

            $data[] = $sub_array;
        }
    }else{
        $sub_array['id_bahan_makanan']     = '';
        $sub_array['nama_bahan_makanan']   = '';
        $sub_array['satuan']            = '';
        $sub_array['hasil_peramalan']   = 0;

        $data[] = $sub_array;
    }

    $results = array(
        "sEcho" => 1,
            "jumlahRecord" => count($data),
            "jumlahRecordDitampilkan" => count($data),
            "data"=>$data);

    echo json_encode($results);

} ?>
