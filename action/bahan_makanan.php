<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_bahan_makanan      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_makanan'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_bahan_makanan     = strtolower(mysqli_escape_string($conn, trim($_POST['nama_bahan_makanan'])));
    $satuan                 = strtolower(mysqli_escape_string($conn, trim($_POST['satuan'])));
    $kategori               = strtolower(mysqli_escape_string($conn, trim($_POST['kategori'])));
}

if ($id_bahan_makanan=='') {
    // init kode terkahir
    $init = 'BRG';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_bahan_makanan 
            FROM bahan_makanan
            ORDER BY id_bahan_makanan DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_bahan_makanan'];
    }else{
        $id_terakhir_tersimpan = $init.'-000';
    }        

    // panggil fungsi generate kode
    $id_bahan_makanan = buat_kode($id_terakhir_tersimpan, $init);
    
    // simpan data
    $sql = "INSERT INTO bahan_makanan (id_bahan_makanan, nama_bahan_makanan, satuan, kategori)
            VALUES ('$id_bahan_makanan', '$nama_bahan_makanan', '$satuan', '$kategori')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_bahan_makanan!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE bahan_makanan 
            SET nama_bahan_makanan='$nama_bahan_makanan', satuan='$satuan', kategori='$kategori'
            WHERE id_bahan_makanan='$id_bahan_makanan'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM bahan_makanan
            WHERE id_bahan_makanan='$id_bahan_makanan'";
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