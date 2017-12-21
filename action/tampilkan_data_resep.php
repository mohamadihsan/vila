<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

$id_bahan_makanan = isset($_SESSION['id_bahan_makanan']) ? $_SESSION['id_bahan_makanan'] : '';
$data = array();
if($id_bahan_makanan == ''){

    $sub_array['id_bahan_makanan']          = NULL;
    $sub_array['input_id_menu']             = NULL;
    $sub_array['input_id_bahan_makanan']    = NULL;
    $sub_array['takaran']                   = NULL;

    $data[] = $sub_array;

}else{

    for ($i=0; $i < count($_SESSION['id_bahan_makanan']); $i++) {
        $id_bahan_makanan[$i] = $_SESSION['id_bahan_makanan'][$i];
        $sql = "SELECT satuan, nama_bahan_makanan FROM bahan_makanan WHERE id_bahan_makanan='$id_bahan_makanan[$i]'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            $satuan[$i] = $row['satuan'];
        }else{
            $satuan[$i] = '';
        }

        $nama_bahan_makanan[$i] = $row['nama_bahan_makanan'];

        $sub_array['satuan']                    = $satuan[$i];
        $sub_array['nama_bahan']                = $nama_bahan_makanan[$i];
        $sub_array['id_bahan_makanan']         = $_SESSION['id_bahan_makanan'][$i].' - '.strtoupper($nama_bahan_makanan[$i]);
        $sub_array['input_hidden']       = '<input type="hidden" name="id_menu" value="'.$_SESSION['id_menu'].'" class="form-control" required>
                                            <input type="hidden" name="id_bahan_makanan[]" value="'.$_SESSION['id_bahan_makanan'][$i].'" class="form-control" required>';
        $sub_array['takaran']               = '<input type="number" name="takaran[]" class="form-control" min="0" required>';
        $sub_array['satuan']               = '<input type="text" name="satuan[]" class="form-control" value="'.$satuan[$i].'" required readonly>';

        $data[] = $sub_array;
    }

}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
