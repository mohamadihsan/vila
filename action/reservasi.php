<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_reservasi      = mysqli_escape_string($conn, trim($_POST['id_reservasi']));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_tamu            = mysqli_escape_string($conn, trim($_POST['id_tamu']));
    $jumlah_orang       = mysqli_escape_string($conn, trim($_POST['jumlah_orang']));
    $tanggal_reservasi  = mysqli_escape_string($conn, trim($_POST['tanggal_reservasi']));
    $status_reservasi   = mysqli_escape_string($conn, trim($_POST['status_reservasi']));
}

if ($id_reservasi=='') {

    // create
    $id_reservasi = 'RV'.date('ymdHis');

    // simpan data
    $sql = "INSERT INTO reservasi (id_reservasi, id_tamu, jumlah_orang, tanggal_reservasi, status_reservasi)
            VALUES ('$id_reservasi', '$id_tamu', '$jumlah_orang', '$tanggal_reservasi', '$status_reservasi')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_reservasi!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE reservasi
            SET id_tamu='$id_tamu', jumlah_orang='$jumlah_orang', tanggal_reservasi='$tanggal_reservasi', status_reservasi='$status_reservasi'
            WHERE id_reservasi='$id_reservasi'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM reservasi
            WHERE id_reservasi='$id_reservasi'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil dihapus";
    }else{
        $pesan_gagal = "Data gagal dihapus";
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
