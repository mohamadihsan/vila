<?php
// buka koneksi
require_once '../config/connection.php';

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
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                    = $no++;
        $sub_array['id_bahan_makanan']      = $row['id_bahan_makanan'];
        $sub_array['nama_bahan_makanan']    = ucwords($row['nama_bahan_makanan']);
        $sub_array['satuan']                = $row['satuan'];
        $sub_array['jml_pemakaian']         = $row['jml_pemakaian'];
        $sub_array['periode']               = $row['periode'];

        $data[] = $sub_array;
    }
}else if ($nama_laporan == 'pembelian-bahan') {

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
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                    = $no++;
        $sub_array['nomor_faktur']      = $row['nomor_faktur'];
        $sub_array['id_bahan_makanan']      = $row['id_bahan_makanan'];
        $sub_array['nama_bahan_makanan']    = ucwords($row['nama_bahan_makanan']);
        $sub_array['satuan']                = $row['satuan'];
        $sub_array['jumlah_pembelian']         = $row['jumlah_pembelian'];
        $sub_array['harga_bahan_makanan']          = Rupiah($row['harga_bahan_makanan']);
        $sub_array['id_supplier']      = $row['id_supplier'];
        $sub_array['status_pembelian']      = $row['status_pembelian'];
        $sub_array['periode']               = $row['periode'];

        $data[] = $sub_array;
    }
}else if ($nama_laporan == 'persediaan-bahan') {
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
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                    = $no++;
        $sub_array['id_bahan_makanan']      = $row['id_bahan_makanan'];
        $sub_array['nama_bahan_makanan']    = ucwords($row['nama_bahan_makanan']);
        $sub_array['satuan']                = $row['satuan'];
        $sub_array['barang_keluar']         = $row['barang_keluar'];
        $sub_array['barang_masuk']          = $row['barang_masuk'];
        $sub_array['periode']               = $row['tanggal'];

        $data[] = $sub_array;
    }
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
