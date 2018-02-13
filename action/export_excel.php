<?php
// buka koneksi
require_once '../config/connection.php';

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


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
    $periode = $periode1.' - '.$periode2;

    $where = " WHERE DATE_FORMAT(pbm.tanggal, '%m-%Y') BETWEEN '$periode1' AND '$periode2' ";
}else{
    $periode = $bulan.'-'.$tahun;
    $where = " WHERE DATE_FORMAT(pbm.tanggal, '%m-%Y') = '$periode' ";
}


/** Include PHPExcel */
require_once dirname(__FILE__) . '/../assets/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Fatwa Syarifah")
							 ->setLastModifiedBy("Fatwa Syarifah")
							 ->setTitle("Laporan")
							 ->setSubject("Laporan")
							 ->setDescription("Laporan Vila Air Natural Resort.")
							 ->setKeywords("Laporan excel")
							 ->setCategory("Laporan");

// Formatting
$style_center = array(
   'alignment' => array(
       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
   )
);

$style_data = array(
   'borders' => array(
       'allborders' => array(
           'style' => PHPExcel_Style_Border::BORDER_THIN
       )
   )
);

$style_header = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
  );

  if ($nama_laporan == 'pembelian-bahan') {

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

      $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A:AC')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle("A1:AC2")->applyFromArray($style_center);
      $objPHPExcel->getActiveSheet()->getStyle("A4:AC5")->applyFromArray($style_header);

      // Header
      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A1', 'LAPORAN PEMBELIAN DAN PENGELUARAN GUDANG KATEGORI CEPAT BUSUK (PENYIMPANAN FREEZER)')
                  ->setCellValue('A2', 'PERIODE : '.$periode)
                  ->setCellValue('A4', 'Nama Barang')
                  ->setCellValue('B4', 'Qty')
                  ->setCellValue('C4', 'Sisa')
                  ->setCellValue('D4', 'Harga Satuan')
                  ->setCellValue('E4', 'Senin')
                  ->setCellValue('E5', 'M')
                  ->setCellValue('F5', 'K')
                  ->setCellValue('G5', 'S')
                  ->setCellValue('H4', 'Selasa')
                  ->setCellValue('H5', 'M')
                  ->setCellValue('I5', 'K')
                  ->setCellValue('J5', 'S')
                  ->setCellValue('K4', 'Rabu')
                  ->setCellValue('K5', 'M')
                  ->setCellValue('L5', 'K')
                  ->setCellValue('M5', 'S')
                  ->setCellValue('N4', 'Kamis')
                  ->setCellValue('N5', 'M')
                  ->setCellValue('O5', 'K')
                  ->setCellValue('P5', 'S')
                  ->setCellValue('Q4', 'Jumat')
                  ->setCellValue('Q5', 'M')
                  ->setCellValue('R5', 'K')
                  ->setCellValue('S5', 'S')
                  ->setCellValue('T4', 'Sabtu')
                  ->setCellValue('T5', 'M')
                  ->setCellValue('U5', 'K')
                  ->setCellValue('V5', 'S')
                  ->setCellValue('W4', 'Minggu')
                  ->setCellValue('W5', 'M')
                  ->setCellValue('X5', 'K')
                  ->setCellValue('Y5', 'S')
                  ->setCellValue('Z4', 'Total Pemakaian')
                  ->setCellValue('AA4', 'Total Pembelian')
                  ->setCellValue('AB4', 'Total Harga Pemakaian')
                  ->setCellValue('AC4', 'Total Harga Pembelian')
                  ->mergeCells('A1:AC1')
                  ->mergeCells('A2:AC2')
                  ->mergeCells('A4:A5')
                  ->mergeCells('B4:B5')
                  ->mergeCells('C4:C5')
                  ->mergeCells('D4:D5')
                  ->mergeCells('E4:G4')
                  ->mergeCells('H4:J4')
                  ->mergeCells('K4:M4')
                  ->mergeCells('N4:P4')
                  ->mergeCells('Q4:S4')
                  ->mergeCells('T4:V4')
                  ->mergeCells('W4:Y4')
                  ->mergeCells('Z4:Z5')
                  ->mergeCells('AA4:AA5')
                  ->mergeCells('AB4:AB5')
                  ->mergeCells('AC4:AC5')
                  ->mergeCells('AD4:AD5');

            $cell = 6;
            $i=0;
            $hari = 0;
            $total_pemakaian = 0;
            $total_pembelian = 0;
          while ($row = mysqli_fetch_assoc($result)) {

              if ($hari == 7) {
                  $hari = 0;
                  $total_pemakaian = 0;
                  $total_pembelian = 0;

              }

              $nomor                    = $no++;
              $id_bahan_makanan[$i]      = $row['id_bahan_makanan'];
              $nama_bahan_makanan    = ucwords($row['nama_bahan_makanan']);
              $satuan                = $row['satuan'];
              $harga_satuan         = $row['harga_satuan'];
              $m               = $row['m'];
              $k               = $row['k'];
              $s               = $row['s'];
              $sisa_akhir = $m - $k;
              $total_pemakaian = $total_pemakaian + $k;
              $total_pembelian = $total_pembelian + $m;



              $objPHPExcel->getActiveSheet()->getStyle('A'.$cell.':AC'.$cell)->applyFromArray($style_header);

            if ($hari == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$cell, $nama_bahan_makanan);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('B'.$cell, $satuan);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$cell)->getAlignment()->setWrapText(true);


                $objPHPExcel->getActiveSheet()->setCellValue('D'.$cell, $harga_satuan);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 1) {

                $objPHPExcel->getActiveSheet()->setCellValue('H'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('I'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('J'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 2) {

                $objPHPExcel->getActiveSheet()->setCellValue('K'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 3) {

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('O'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('P'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 4) {

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('R'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('S'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 5) {

                $objPHPExcel->getActiveSheet()->setCellValue('T'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('T'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('U'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('U'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('V'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('V'.$cell)->getAlignment()->setWrapText(true);

            }

            if ($hari == 6) {

                $total_harga_pemakaian = $total_pemakaian * $harga_satuan;
                $total_harga_pembelian = $total_pembelian * $harga_satuan;

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$cell, $sisa_akhir);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('W'.$cell, $m);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('W'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('X'.$cell, $k);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('X'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$cell, $s);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('Y'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$cell, $total_pemakaian);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('Z'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$cell, $total_pembelian);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('AA'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$cell, $total_harga_pemakaian);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('AB'.$cell)->getAlignment()->setWrapText(true);

                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$cell, $total_harga_pembelian);
                $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle('AC'.$cell)->getAlignment()->setWrapText(true);
            }

            $hari++;

            if ($hari == 7) {
                $cell++;
            }
          }
  }




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
