<?php
error_reporting(0);
// buka koneksi
require_once '../config/connection.php';
session_start();

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    $nomor_faktur       = mysqli_escape_string($conn, trim($_POST['nomor_faktur']));
    $status_pembelian   = 'DK';

    // perbaharui data
    $sql = "UPDATE pembelian_bahan_makanan
            SET status_pembelian='$status_pembelian'
            WHERE nomor_faktur='$nomor_faktur'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Pemesanan telah diterima";
    }else{
        $pesan_gagal = "Gagal terhubung dengan server";
    }
}else{
    $nomor_faktur = '030118FAK00002P';
    $id_supplier  = $_POST['id_supplier'];
    $id_bahan_makanan  = $_POST['id_bahan_makanan'];
    $jumlah_pemesanan  = $_POST['jumlah_pemesanan'];
    $id_karyawan  = $_SESSION['id_karyawan'];
    $status_pembelian = 'SP';

    for ($i=0; $i < count($id_supplier); $i++) {
        if ($id_supplier[$i] != '') {
            // insert data master pemesanan
            if ($id_supplier[$i] != $id_supplier[$i-1]) {
                $sql = "INSERT INTO pembelian_bahan_makanan(nomor_faktur, id_supplier, id_karyawan, status_pembelian)
                        VALUES('$nomor_faktur','$id_supplier[$i]','$id_karyawan','$status_pembelian')";
                mysqli_query($conn, $sql);

                $sql = "SELECT nomor_faktur FROM pembelian_bahan_makanan ORDER BY nomor_faktur DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $nomor_faktur = $row['nomor_faktur'];
            }

            // retirieve harga barang
            $sql = "SELECT harga FROM detail_supplier WHERE id_bahan_makanan='$id_bahan_makanan[$i]' AND id_supplier='$id_supplier[$i]'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result)>0) {
                $row = mysqli_fetch_assoc($result);
                $harga_bahan_baku[$i] = $row['harga'];
            }else{
                $harga_bahan_baku[$i] = 0;
            }

            // insert data detail pemesanan
            $sql = "INSERT INTO detail_pembelian_bahan_makanan(nomor_faktur, id_bahan_makanan, jumlah_pemesanan, harga_bahan_baku)
                    VALUES('$nomor_faktur','$id_bahan_makanan[$i]','$jumlah_pemesanan[$i]','$harga_bahan_baku[$i]')";
            if(mysqli_query($conn, $sql)){
                $pesan_berhasil = "Data berhasil disimpan";
            }else{
                $pesan_gagal = "Data gagal disimpan";
            }
        }else{
            $pesan_gagal = "Data gagal disimpan";
        }
    }
}

if (isset($pesan_berhasil)) {
    echo "string";
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
