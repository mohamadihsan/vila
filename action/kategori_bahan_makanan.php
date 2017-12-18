<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_kategori      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_kategori'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_kategori    = mysqli_escape_string($conn, trim($_POST['nama_kategori']));
}

if ($id_kategori=='') {
    // init kode terkahir
    $init = 'K';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_kategori
            FROM kategori_bahan_makanan
            ORDER BY id_kategori DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_kategori'];
    }else{
        $id_terakhir_tersimpan = '000'.$init;
    }

    // panggil fungsi generate kode
    $id_kategori = buat_kode_kategori($id_terakhir_tersimpan, $init);

    // simpan data
    $sql = "INSERT INTO kategori_bahan_makanan (id_kategori, nama_kategori)
            VALUES ('$id_kategori', '$nama_kategori')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_kategori!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE kategori_bahan_makanan
            SET nama_kategori='$nama_kategori'
            WHERE id_kategori='$id_kategori'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM kategori_bahan_makanan
            WHERE id_kategori='$id_kategori'";
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
