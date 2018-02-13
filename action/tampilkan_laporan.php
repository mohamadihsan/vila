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
              pbm.id_bahan_makanan,
              bm.nama_bahan_makanan,
              bm.satuan,
              pbm.harga_satuan,
              SUM(pbm.barang_masuk) AS m,
              SUM(pbm.barang_keluar) AS k,
              SUM(pbm.sisa) AS s
          FROM
              persediaan_bahan_makanan pbm
          LEFT JOIN bahan_makanan bm ON pbm.id_bahan_makanan = bm.id_bahan_makanan
          $where
          GROUP BY
              1,
              2,
              3,
              4,
              WEEKDAY(pbm.tanggal)
          ORDER BY
              1";

    $result = mysqli_query($conn, $sql);
    $data = array();
    $no = 1;

    $i=0;
    $hari = 0;
    $total_pemakaian = 0;
    $total_pembelian = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_array['no']                    = $no++;
        $sub_array['id_bahan_makanan']      = $row['id_bahan_makanan'];
        $sub_array['nama_bahan_makanan']    = ucwords($row['nama_bahan_makanan']);
        $sub_array['satuan']                = $row['satuan'];
        $sub_array['harga_satuan']         = $row['harga_satuan'];
        $sub_array['m']          = $row['m'];
        $sub_array['k']      = $row['k'];
        $sub_array['s']      = $row['s'];
        $sub_array['periode']               = $row['periode'];

        $sisa_akhir = $m - $k;
        $total_pemakaian = $total_pemakaian + $k;
        $total_pembelian = $total_pembelian + $m;

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
