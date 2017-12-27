<?php
// buka koneksi
require_once '../config/connection.php';

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_bahan_baku  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_baku'])));
    $jumlah         = strtolower(mysqli_escape_string($conn, trim($_POST['jumlah'])));

    // simpan data
    $sql = "INSERT INTO barang_masuk (id_bahan_baku, jumlah)
            VALUES ('$id_bahan_baku', '$jumlah')";
    if(mysqli_query($conn, $sql)){

        // get stok barang sebelumnya
        $sql = "SELECT stok FROM bahan_baku WHERE id_bahan_baku='$id_bahan_baku'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $stok = $row['stok'];

        // stok baru
        $stok_baru = $jumlah + $stok;

        // simpan data stok
        $sql_update_stok = "UPDATE bahan_baku SET stok='$stok_baru' WHERE id_bahan_baku='$id_bahan_baku'";
        mysqli_query($conn, $sql_update_stok);

        $pesan_berhasil = "Data berhasil disimpan";

    }else{
        $pesan_gagal = "Data gagal disimpan";
    }

}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    $id_barang_masuk    = strtolower(mysqli_escape_string($conn, trim($_POST['id_barang_masuk'])));

    //get jumlah barang yg dimasukkan sebelumnya
    $sql = "SELECT id_bahan_baku, jumlah FROM barang_masuk WHERE id_barang_masuk='$id_barang_masuk'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id_bahan_baku = $row['id_bahan_baku'];
    $jumlah = $row['jumlah'];

    // hapus data
    $sql = "DELETE FROM barang_masuk
            WHERE id_barang_masuk='$id_barang_masuk'";
    if(mysqli_query($conn, $sql)){

        // get stok barang
        $sql = "SELECT stok FROM bahan_baku WHERE id_bahan_baku='$id_bahan_baku'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $stok = $row['stok'];

        // kembalikan stok ke semula
        $stok_baru = $stok - $jumlah;

        // simpan data stok
        $sql_update_stok = "UPDATE bahan_baku SET stok='$stok_baru' WHERE id_bahan_baku='$id_bahan_baku'";
        mysqli_query($conn, $sql_update_stok);

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
