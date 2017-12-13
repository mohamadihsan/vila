<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_menu          = strtoupper(mysqli_escape_string($conn, trim($_POST['id_menu'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_menu      = ucwords(mysqli_escape_string($conn, trim($_POST['nama_menu'])));
    $harga          = strtolower(mysqli_escape_string($conn, trim($_POST['harga'])));
}

if ($id_menu=='') {
    // init kode terkahir
    $init = 'MN';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_menu 
            FROM menu
            ORDER BY id_menu DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_menu'];
    }else{
        $id_terakhir_tersimpan = $init.'000';
    }        

    // panggil fungsi generate kode
    $id_menu = buat_kode_menu($id_terakhir_tersimpan, $init);

    // simpan data
    $sql = "INSERT INTO menu (id_menu, nama_menu, harga)
            VALUES ('$id_menu', '$nama_menu', '$harga')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_menu!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE menu 
            SET nama_menu='$nama_menu', harga='$harga'
            WHERE id_menu='$id_menu'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM menu
            WHERE id_menu='$id_menu'";
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