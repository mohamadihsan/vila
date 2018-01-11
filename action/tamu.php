<?php
error_reporting(0);
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_tamu     = mysqli_escape_string($conn, trim($_POST['id_tamu']));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_tamu_lama     = mysqli_escape_string($conn, trim($_POST['id_tamu_lama']));
    $nama_tamu     = mysqli_escape_string($conn, trim($_POST['nama_tamu']));
    $no_telp       = mysqli_escape_string($conn, trim($_POST['no_telp']));
    $email         = mysqli_escape_string($conn, trim($_POST['email']));
}

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM tamu
            WHERE id_tamu='$id_tamu'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil dihapus";
    }else{
        $pesan_gagal = "Data gagal dihapus";
    }
}else if ($id_tamu_lama=='') {

    $init = 'DT-';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_tamu
            FROM tamu
            ORDER BY id_tamu DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_tamu'];
    }else{
        $id_terakhir_tersimpan = $init.'000';
    }

    // panggil fungsi generate kode
    $id_tamu = buat_kode_tamu($id_terakhir_tersimpan, $init);

        // simpan data
    $sql = "INSERT INTO tamu (id_tamu, nama_tamu, no_telp, email)
            VALUES ('$id_tamu', '$nama_tamu', '$no_telp', '$email')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_tamu_lama!=''){
    // perbaharui data
    $sql = "UPDATE tamu
            SET id_tamu='$id_tamu', nama_tamu='$nama_tamu', no_telp='$no_telp', email='$email'
            WHERE id_tamu='$id_tamu_lama'";
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
