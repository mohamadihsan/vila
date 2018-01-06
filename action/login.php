<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

// retrieve data post
$nama_pengguna  = mysqli_real_escape_string($conn, trim($_POST['nama_pengguna']));
$kata_sandi     = md5(mysqli_real_escape_string($conn, trim($_POST['kata_sandi'])));
$log_user       = mysqli_real_escape_string($conn, trim($_POST['log_user']));

if ($log_user == 'pgw') {
    // select data
    $sql = "SELECT id_karyawan, nama_karyawan, divisi, nama_pengguna, foto
            FROM pengguna
            WHERE nama_pengguna='$nama_pengguna' AND kata_sandi='$kata_sandi'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // buat session karyawan
        $_SESSION['id_karyawan'] = $data['id_karyawan'];
        $_SESSION['nama_karyawan'] = $data['nama_karyawan'];
        $_SESSION['nama_lengkap'] = $data['nama_karyawan'];
        $_SESSION['divisi'] = $data['divisi'];
        $_SESSION['foto_profil'] = $data['foto'];
        $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
        $_SESSION['login'] = TRUE;

    }else{
        // jika data tidak ditemukan
        $_SESSION['login'] = FALSE;
    }

    // arahkan ke route
    header('location:../admin/');
}else if($log_user == 'supp'){
    // select data
    $sql = "SELECT id_supplier, nama_supplier, nama_pengguna
            FROM supplier
            WHERE nama_pengguna='$nama_pengguna' AND kata_sandi='$kata_sandi'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // buat session karyawan
        $_SESSION['id_supplier'] = $data['id_supplier'];
        $_SESSION['nama_supplier'] = $data['nama_supplier'];
        $_SESSION['nama_lengkap'] = $data['nama_supplier'];
        $_SESSION['divisi'] = 'supplier';
        $_SESSION['foto_profil'] = 'user2.png';
        $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
        $_SESSION['login'] = TRUE;

    }else{
        // jika data tidak ditemukan
        $_SESSION['login'] = FALSE;
    }

    // arahkan ke route
    header('location:../supplier/');
}else{
    // select data
    $sql = "SELECT id_pelanggan, nama_pelanggan, nama_pengguna
            FROM pelanggan
            WHERE nama_pengguna='$nama_pengguna' AND kata_sandi='$kata_sandi'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // buat session karyawan
        $_SESSION['id_pelanggan'] = $data['id_pelanggan'];
        $_SESSION['nama_pelanggan'] = $data['nama_pelanggan'];
        $_SESSION['nama_lengkap'] = $data['nama_pelanggan'];
        $_SESSION['divisi'] = 'pelanggan';
        $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
        $_SESSION['login'] = TRUE;

    }else{
        // jika data tidak ditemukan
        $_SESSION['login'] = FALSE;
    }

    // arahkan ke route
    header('location:../');
}


?>
