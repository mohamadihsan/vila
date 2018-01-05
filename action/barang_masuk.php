<?php
// buka koneksi
require_once '../config/connection.php';

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_bahan_makanan   = mysqli_escape_string($conn, trim($_POST['id_bahan_makanan']));
    $barang_masuk      = mysqli_escape_string($conn, trim($_POST['barang_masuk']));
    $harga_satuan       = mysqli_escape_string($conn, trim($_POST['harga_satuan']));
    $tanggal            = mysqli_escape_string($conn, trim($_POST['tanggal']));

    // simpan data
    $sql = "INSERT INTO persediaan_bahan_makanan (id_bahan_makanan, barang_masuk, harga_satuan, tanggal)
            VALUES ('$id_bahan_makanan', '$barang_masuk', '$harga_satuan', '$tanggal')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    $tanggal    = mysqli_escape_string($conn, trim($_POST['tanggal']));

    // hapus data
    $sql = "DELETE FROM persediaan_bahan_makanan
            WHERE id_bahan_makanan='$id_bahan_makanan' AND tanggal='$tanggal'";
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
