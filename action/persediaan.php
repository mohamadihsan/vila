<?php
// buka koneksi
require_once '../config/connection.php';

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_bahan_makanan       = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_makanan'])));
    $id_bahan_makanan_lama  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_makanan_lama'])));
    $barang_masuk           = strtolower(mysqli_escape_string($conn, trim($_POST['barang_masuk'])));
    $barang_keluar          = strtolower(mysqli_escape_string($conn, trim($_POST['barang_keluar'])));
    $harga_satuan           = strtolower(mysqli_escape_string($conn, trim($_POST['harga_satuan'])));
    $tanggal                = mysqli_escape_string($conn, trim($_POST['tanggal']));
    $tanggal_lama           = mysqli_escape_string($conn, trim($_POST['tanggal_lama']));
    $sisa                   = $barang_masuk - $barang_keluar;

    if ($id_bahan_makanan_lama=='') {
        // cek data tersedia atau tidak
        $sql = "SELECT * FROM persediaan_bahan_makanan WHERE id_bahan_makanan='$id_bahan_makanan' AND tanggal='$tanggal'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            // simpan data
            $sql = "INSERT INTO persediaan_bahan_makanan (id_bahan_makanan, barang_masuk, barang_keluar, sisa, harga_satuan, tanggal)
                    VALUES ('$id_bahan_makanan', '$barang_masuk', '$barang_keluar', '$sisa', '$harga_satuan', '$tanggal')";
            if(mysqli_query($conn, $sql)){
                $pesan_berhasil = "Data berhasil disimpan";
            }else{
                $pesan_gagal = "Data gagal disimpan";
            }
        }else{
            $pesan_gagal = "Data yang anda masukkan sudah tersedia. Silahkan perbaharui data!";
        }

    }else{
        // perbaharui data
        $sql = "UPDATE persediaan_bahan_makanan SET id_bahan_makanan='$id_bahan_makanan', barang_masuk='$barang_masuk', barang_keluar='$barang_keluar', sisa='$sisa', harga_satuan='$harga_satuan', tanggal='$tanggal'
                WHERE id_bahan_makanan='$id_bahan_makanan_lama' AND tanggal='$tanggal_lama'";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil diperbaharui";
        }else{
            $pesan_gagal = "Data gagal diperbaharui";
        }
    }

}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    $id_bahan_makanan       = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_makanan'])));
    $tanggal                = strtolower(mysqli_escape_string($conn, trim($_POST['tanggal'])));
    $barang                = strtolower(mysqli_escape_string($conn, trim($_POST['barang'])));

    if ($barang=="masuk") {
        // hapus data
        $sql = "DELETE FROM persediaan_bahan_makanan
                WHERE id_bahan_makanan='$id_bahan_makanan' AND tanggal='$tanggal' AND barang_keluar=0";
    }else{
        // hapus data
        $sql = "DELETE FROM persediaan_bahan_makanan
                WHERE id_bahan_makanan='$id_bahan_makanan' AND tanggal='$tanggal' AND barang_masuk=0";
    }
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
