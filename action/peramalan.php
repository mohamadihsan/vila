<?php
// buka koneksi
require_once '../config/connection.php';



if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    // init
    $id_bahan_makanan  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_makanan'])));
    $bulan      = strtoupper(mysqli_escape_string($conn, trim($_POST['bulan'])));
    $tahun      = strtoupper(mysqli_escape_string($conn, trim($_POST['tahun'])));
    $periode    = $bulan.'-'.$tahun;
    $periode_bulan_sebelumnya = date('Y-m-d', strtotime('01-'.$periode));
    $periode_bulan_sebelumnya = date('m-Y', strtotime('-1 month', strtotime($periode_bulan_sebelumnya)));
    $alpha      = 0.9;
    ;
    // jumlah pemesanan sebulan sebelum periode yang dicari
    $sql = "SELECT barang_keluar as jumlah_pemakaian
            FROM persediaan_bahan_makanan
            WHERE id_bahan_makanan = '$id_bahan_makanan'
            AND DATE_FORMAT(tanggal,'%m-%Y') = '$periode_bulan_sebelumnya'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $jumlah_pemakaian = $data['jumlah_pemakaian'];
    if ($jumlah_pemakaian == NULL) {
        $jumlah_pemakaian = 0;
    }

    // jumlah peramalan 1 bulan yang lalu dari periode yang dicari
        $sql = "SELECT hasil_peramalan
                FROM peramalan
            WHERE id_bahan_makanan = '$id_bahan_makanan'
            AND DATE_FORMAT(periode,'%m-%Y') = '$periode_bulan_sebelumnya'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $hasil_peramalan_bulan_sebelumnya = $data['hasil_peramalan'];
    }else{
        $hasil_peramalan_bulan_sebelumnya = $jumlah_pemakaian;
    }

    // rumus single exponential smoothing
    $hasil_peramalan = ceil(($alpha * $jumlah_pemakaian) + (1 - $alpha) * $hasil_peramalan_bulan_sebelumnya);

    $periode = $tahun.'-'.$bulan.'-01';
    // echo $hasil_peramalan;die();
    // cek data apakah sudah tersedia atau belum
    $sql = "SELECT id_peramalan
            FROM peramalan
            WHERE id_bahan_makanan = '$id_bahan_makanan'
            AND periode='$periode'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $id_peramalan = $data['id_peramalan'];

        // update data
        $sql = "UPDATE peramalan
                SET hasil_peramalan = '$hasil_peramalan'
                WHERE id_peramalan = '$id_peramalan'";
        mysqli_query($conn, $sql);
    }else{
        // simpan data
        $sql = "INSERT INTO peramalan (periode, id_bahan_makanan, hasil_peramalan)
                VALUES ('$periode', '$id_bahan_makanan', '$hasil_peramalan')";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data peramalan telah disimpan";
        }else{
            $pesan_gagal = "Data peramalan gagal disimpan";
        }
    }
}else{
    $id_peramalan  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_peramalan'])));
    // hapus data
    $sql = "DELETE FROM peramalan
            WHERE id_peramalan='$id_peramalan'";
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
