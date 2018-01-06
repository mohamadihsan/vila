<?php
// buka koneksi
require_once '../config/connection.php';

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

function Rupiah($rupiah) {
    //format rupiah
    $jumlah_desimal = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan = ".";

    $hasil = number_format($rupiah, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
    return 'Rp.'.($hasil);
}

$nama_laporan = isset($_GET['nama']) ? $_GET['nama'] : '';
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

if ($bulan == 'semua') {
    $periode1 = "01-".$tahun;
    $periode2 = "12-".$tahun;
    $where = " WHERE DATE_FORMAT(pbm.tanggal, '%m-%Y') BETWEEN '$periode1' AND '$periode2' ";
}else{
    $periode = $bulan.'-'.$tahun;
    $where = " WHERE DATE_FORMAT(pbm.tanggal, '%m-%Y') = '$periode' ";
}

if ($nama_laporan == 'pemakaian-bahan') {

    header("Content-Disposition: attachment; filename=laporan pemakaian bahan makanan.xls");

    $sql = "SELECT
            	pbm.id_bahan_makanan,
            	bm.nama_bahan_makanan,
            	SUM(pbm.barang_keluar) AS 'jml_pemakaian',
            	bm.satuan,
            	DATE_FORMAT(pbm.tanggal, '%M %Y') AS 'periode'
            FROM
            	persediaan_bahan_makanan pbm
            LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan = pbm.id_bahan_makanan
            $where
            GROUP BY
            	1,
            	5";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;
    ?>
    <table >
        <tr>
            <th width="3%" class="text-center">No</th>
            <th width="10%" class="text-left">ID Bahan</th>
            <th width="15%" class="text-left">Nama Bahan</th>
            <th width="10%" class="text-center">Jumlah Pemakaian</th>
            <th width="10%" class="text-center">Satuan</th>
            <th width="10%" class="text-left">Periode</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $no                    = $no++;
            $id_bahan_makanan      = $row['id_bahan_makanan'];
            $nama_bahan_makanan    = ucwords($row['nama_bahan_makanan']);
            $satuan                = $row['satuan'];
            $jml_pemakaian         = $row['jml_pemakaian'];
            $periode               = $row['periode'];
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $id_bahan_makanan ?></td>
                <td><?= $nama_bahan_makanan ?></td>
                <td><?= $jml_pemakaian ?></td>
                <td><?= $satuan ?></td>
                <td><?= $periode ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}else if ($nama_laporan == 'pembelian-bahan') {

    header("Content-Disposition: attachment; filename=laporan pembelian bahan makanan.xls");

    if ($bulan == 'semua') {
        $periode1 = "01-".$tahun;
        $periode2 = "12-".$tahun;
        $where = " WHERE DATE_FORMAT(pbm.tanggal_pembelian, '%m-%Y') BETWEEN '$periode1' AND '$periode2' ";
    }else{
        $periode = $bulan.'-'.$tahun;
        $where = " WHERE DATE_FORMAT(pbm.tanggal_pembelian, '%m-%Y') = '$periode' ";
    }

    $sql = "SELECT
            	pbm.nomor_faktur,
            	dpbm.id_bahan_makanan,
            	bm.nama_bahan_makanan,
            	dpbm.jumlah_pembelian,
            	dpbm.harga_bahan_makanan,
            	bm.satuan,
            	pbm.id_supplier,
            	pbm.status_pembelian,
            	DATE_FORMAT(
            		pbm.tanggal_pembelian,
            		'%m-%Y'
            	) AS periode
            FROM
            	pembelian_bahan_makanan pbm
            LEFT JOIN detail_pembelian_bahan_makanan dpbm ON dpbm.nomor_faktur = pbm.nomor_faktur
            LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan = dpbm.id_bahan_makanan
            $where";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;
    ?>

    <table >
        <tr>
            <th width="3%" class="text-center">No</th>
            <th width="10%" class="text-left">Nomor Faktur</th>
            <th width="10%" class="text-left">ID Bahan</th>
            <th width="15%" class="text-left">Nama Bahan</th>
            <th width="10%" class="text-right">Harga</th>
            <th width="10%" class="text-center">Pembelian</th>
            <th width="10%" class="text-center">Satuan</th>
            <th width="10%" class="text-center">Supplier</th>
            <th width="10%" class="text-center">Status</th>
            <th width="10%" class="text-left">Periode</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $no                     = $no++;
            $nomor_faktur           = $row['nomor_faktur'];
            $id_bahan_makanan       = $row['id_bahan_makanan'];
            $nama_bahan_makanan     = ucwords($row['nama_bahan_makanan']);
            $satuan                 = $row['satuan'];
            $jumlah_pembelian       = $row['jumlah_pembelian'];
            $harga_bahan_makanan    = Rupiah($row['harga_bahan_makanan']);
            $id_supplier            = $row['id_supplier'];
            $status_pembelian       = $row['status_pembelian'];
            $periode                = $row['periode'];
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $nomor_faktur ?></td>
                <td><?= $id_bahan_makanan ?></td>
                <td><?= $nama_bahan_makanan ?></td>
                <td><?= $harga_bahan_makanan ?></td>
                <td><?= $jumlah_pembelian ?></td>
                <td><?= $satuan ?></td>
                <td><?= $id_supplier ?></td>
                <td><?= $status_pembelian ?></td>
                <td><?= $periode ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}else if ($nama_laporan == 'persediaan-bahan') {

    header("Content-Disposition: attachment; filename=laporan persediaan bahan makanan.xls");

    $sql = "SELECT
            	x.id_bahan_makanan,
            	x.barang_masuk,
            	x.barang_keluar,
            	(
            		x.barang_masuk - x.barang_keluar
            	) AS sisa,
            	x.harga_satuan,
            	x.tanggal,
            	x.nama_bahan_makanan,
            	x.satuan
            FROM
            	(
            		SELECT
            			pbm.id_bahan_makanan,
            			SUM(pbm.barang_masuk) AS barang_masuk,
            			SUM(pbm.barang_keluar) AS barang_keluar,
            			pbm.harga_satuan,
            			DATE_FORMAT(pbm.tanggal, '%m-%Y') AS tanggal,
            			bm.nama_bahan_makanan,
            			bm.satuan
            		FROM
            			persediaan_bahan_makanan pbm
            		LEFT JOIN bahan_makanan bm ON bm.id_bahan_makanan = pbm.id_bahan_makanan
            		$where
            		GROUP BY
            			1,
            			4,
            			5
            		ORDER BY
            			pbm.id_bahan_makanan ASC,
            			tanggal DESC
            	) AS x";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;
    ?>

    <table >
        <tr>
            <th width="3%" class="text-center">No</th>
            <th width="10%" class="text-left">ID Bahan</th>
            <th width="15%" class="text-left">Nama Bahan</th>
            <th width="10%" class="text-center">Barang Masuk</th>
            <th width="10%" class="text-center">Barang Keluar</th>
            <th width="10%" class="text-center">Satuan</th>
            <th width="10%" class="text-left">Periode</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $no                    = $no++;
            $id_bahan_makanan      = $row['id_bahan_makanan'];
            $nama_bahan_makanan    = ucwords($row['nama_bahan_makanan']);
            $satuan                = $row['satuan'];
            $barang_keluar         = $row['barang_keluar'];
            $barang_masuk          = $row['barang_masuk'];
            $periode               = $row['tanggal'];
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $id_bahan_makanan ?></td>
                <td><?= $nama_bahan_makanan ?></td>
                <td><?= $barang_masuk ?></td>
                <td><?= $barang_keluar ?></td>
                <td><?= $satuan ?></td>
                <td><?= $periode ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}


?>
