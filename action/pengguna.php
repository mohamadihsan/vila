<?php
error_reporting(0);
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_karyawan      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_karyawan'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_karyawan_lama = strtoupper(mysqli_escape_string($conn, trim($_POST['id_karyawan_lama'])));
    $nama_karyawan       = ucwords(mysqli_escape_string($conn, trim($_POST['nama_karyawan'])));
    $email              = mysqli_escape_string($conn, trim($_POST['email']));
    $divisi            = strtolower(mysqli_escape_string($conn, trim($_POST['divisi'])));
    $nama_pengguna      = mysqli_escape_string($conn, trim($_POST['nama_pengguna']));
    $kata_sandi         = md5(strtolower(mysqli_escape_string($conn, trim($_POST['kata_sandi']))));
}

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM pengguna
            WHERE id_karyawan='$id_karyawan'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil dihapus";
    }else{
        $pesan_gagal = "Data gagal dihapus";
    }
}else if ($id_karyawan_lama=='') {
        // simpan data
    $sql = "INSERT INTO pengguna (id_karyawan, nama_karyawan, email, divisi, nama_pengguna, kata_sandi)
            VALUES ('$id_karyawan', '$nama_karyawan', '$email', '$divisi', '$nama_pengguna', '$kata_sandi')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_karyawan_lama!=''){
    // perbaharui data
    $sql = "UPDATE pengguna
            SET id_karyawan='$id_karyawan', nama_karyawan='$nama_karyawan', email='$email', divisi='$divisi', nama_pengguna='$nama_pengguna', kata_sandi='$kata_sandi'
            WHERE id_karyawan='$id_karyawan_lama'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}

if (isset($pesan_berhasil)) {
    ?>
    <script type="text/javascript">
        $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Sukses!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_berhasil ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/berhasil.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
            });
        });
    </script>
    <?php
}else if(isset($pesan_gagal)){
    ?>
    <script type="text/javascript">
	    $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Gagal!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_gagal ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/gagal.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
	        });
        });
	</script>
    <?php
}
?>
