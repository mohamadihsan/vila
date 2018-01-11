<?php
function buat_kode($id_terakhir_tersimpan, $init)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[4] == '0' && $kode[5] == '0'){
        $urutan = (int)$kode[6] + 1;
        if($urutan < 10){
            $id_baru =  $init.'-00'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = $init.'-0'.$urutan;
        }else{
            $id_baru = $init.'-'.$urutan;
        }

    }else if($kode[4] == '0' && (int)$kode[5] > 0){
        $urutan = $kode[5].''.$kode[6];
        $urutan = (int)$urutan + 1;
        if($urutan < 100){
            $id_baru =  $init.'-0'.$urutan;
        }else if($urutan >= 100 && $urutan < 1000){
            $id_baru = $init.'-'.$urutan;
        }
    }else if((int)$kode[4] > 0){
        $urutan = $kode[4].''.$kode[5].''.$kode[6];
        $urutan = (int)$urutan + 1;
        if($urutan < 1000){
            $id_baru =  $init.'-'.$urutan;
        }
    }

    return $id_baru;
}

function buat_kode_kategori($id_terakhir_tersimpan, $init)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[1] == '0' && (int)$kode[2] < 10){
        $urutan = (int)$kode[2] + 1;
        if($urutan < 10){
            $id_baru =  $init.'0'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = $init.''.$urutan;
        }

    }else if((int)$kode[1] > 0){
        $urutan = $kode[1].''.$kode[2];
        $urutan = (int)$urutan + 1;
        if($urutan < 100){
            $id_baru =  $init.''.$urutan;
        }
    }

    return $id_baru;
}

function buat_kode_menu($id_terakhir_tersimpan, $init)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[2] == '0' && $kode[3] == '0'){
        $urutan = (int)$kode[4] + 1;
        if($urutan < 10){
            $id_baru =  $init.'00'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = $init.'0'.$urutan;
        }else{
            $id_baru = $init.''.$urutan;
        }

    }else if($kode[2] == '0' && (int)$kode[3] > 0){
        $urutan = $kode[3].''.$kode[4];
        $urutan = (int)$urutan + 1;
        if($urutan < 100){
            $id_baru =  $init.'0'.$urutan;
        }else if($urutan >= 100 && $urutan < 1000){
            $id_baru = $init.''.$urutan;
        }
    }else if((int)$kode[2] > 0){
        $urutan = $kode[2].''.$kode[3].''.$kode[4];
        $urutan = (int)$urutan + 1;
        if($urutan < 1000){
            $id_baru =  $init.''.$urutan;
        }
    }

    return $id_baru;
}

function buat_kode_tamu($id_terakhir_tersimpan, $init)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[3] == '0' && $kode[4] == '0'){
        $urutan = (int)$kode[5] + 1;
        if($urutan < 10){
            $id_baru =  $init.'00'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = $init.'0'.$urutan;
        }else{
            $id_baru = $init.''.$urutan;
        }

    }else if($kode[3] == '0' && (int)$kode[4] > 0){
        $urutan = $kode[4].''.$kode[5];
        $urutan = (int)$urutan + 1;
        if($urutan < 100){
            $id_baru =  $init.'0'.$urutan;
        }else if($urutan >= 100 && $urutan < 1000){
            $id_baru = $init.''.$urutan;
        }
    }else if((int)$kode[3] > 0){
        $urutan = $kode[2].''.$kode[4].''.$kode[5];
        $urutan = (int)$urutan + 1;
        if($urutan < 1000){
            $id_baru =  $init.''.$urutan;
        }
    }

    return $id_baru;
}

function buat_kode_user($string, $init, $id_terakhir_tersimpan)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[7] == '0' && $kode[8] == '0' && $kode[9] == '0'){
        $urutan = (int)$kode[10] + 1;
        if($urutan < 100){
            $id_baru =  $init.'000'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = $init.'00'.$urutan;
        }else if($urutan >= 100 && $urutan < 1000){
            $id_baru = $init.'0'.$urutan;
        }else{
            $id_baru = $init.''.$urutan;
        }
    }else if($kode[7] == '0' && $kode[8] == '0' && (int)$kode[9] > 0){
        $urutan = $kode[9].''.$kode[10];
        $urutan = (int)$urutan + 1;
        if($urutan < 100 ){
            $id_baru = $init.'00'.$urutan;
        }else if($urutan >= 100 && $urutan < 1000){
            $id_baru = $init.'0'.$urutan;
        }else{
            $id_baru = $init.''.$urutan;
        }
    }else if($kode[7] == '0' && (int)$kode[8] > 0){
        $urutan = $kode[8].''.$kode[9].''.$kode[10];
        $urutan = (int)$urutan + 1;
        if($urutan < 1000){
            $id_baru =  $init.'0'.$urutan;
        }else if($urutan >= 1000 && $urutan < 10000){
            $id_baru = $init.''.$urutan;
        }
    }else if((int)$kode[7] > 0){
        $urutan = $kode[7].''.$kode[8].''.$kode[9].''.$kode[10];
        $urutan = (int)$urutan + 1;
        if($urutan < 10000){
            $id_baru =  $init.''.$urutan;
        }
    }

    return $string.''.$id_baru;
}

function buat_kode_pegawai($init, $string, $id_terakhir_tersimpan)
{
    // buat ID baru
    $kode = str_split($id_terakhir_tersimpan);

    // cek kode
    if($kode[6] == '0' && $kode[7] == '0'){
        $urutan = (int)$kode[8] + 1;
        if($urutan < 10){
            $id_baru =  '00'.$urutan;
        }else if($urutan >= 10 && $urutan < 100){
            $id_baru = '0'.$urutan;
        }else{
            $id_baru = $urutan;
        }
    }else if($kode[6] == '0' && (int)$kode[7] > 0){
        $urutan = $kode[7].''.$kode[8];
        $urutan = (int)$urutan + 1;
        if($urutan < 100 ){
            $id_baru = '0'.$urutan;
        }else{
            $id_baru = $urutan;
        }
    }else if((int)$kode[6] > 0){
        $urutan = $kode[6].''.$kode[7].''.$kode[8];
        $urutan = (int)$urutan + 1;
        if($urutan < 1000){
            $id_baru =  $urutan;
        }
    }

    return $init.''.$string.''.$id_baru;
}
?>
