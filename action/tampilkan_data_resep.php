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
        $sub_array['id_bahan_makanan']         = $_SESSION['id_bahan_makanan'][$i];
        $sub_array['input_id_menu']       = '<input type="hidden" name="id_menu" value="'.$_SESSION['id_menu'].'" class="form-control" required>';        
        $sub_array['input_id_bahan_makanan']   = '<input type="hidden" name="id_bahan_makanan[]" value="'.$_SESSION['id_bahan_makanan'][$i].'" class="form-control" required>';        
        $sub_array['takaran']               = '<input type="number" name="takaran[]" class="form-control" min="0" required>';

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