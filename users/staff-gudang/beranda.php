<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active"></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 infobox-container">
                    <?php
                    // retrieve data dari API
                    $file = file_get_contents($url_api."tampilkan_data_gudang.php");
                    $json = json_decode($file, true);
                    $i=0;
                    while ($i < count($json['data'])) {
                        $kategori_bahan_makanan[$i] = $json['data'][$i]['kategori_bahan_makanan'];
                        $bahan_makanan[$i] = $json['data'][$i]['bahan_makanan'];
                        $permintaan_bahan[$i] = $json['data'][$i]['permintaan_bahan'];
                        $barang_masuk[$i] = $json['data'][$i]['barang_masuk'];
                        $barang_keluar[$i] = $json['data'][$i]['barang_keluar'];
                        $i++;
                    }
                    ?>
                    <caption><h5><b>Data Gudang </b></h5></caption>
					<div class="infobox infobox-green">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-list"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $kategori_bahan_makanan[0] ?></span>
							<div class="infobox-content">Kategori Bahan</div>
						</div>
					</div>

					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-cubes"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $bahan_makanan[0] ?></span>
							<div class="infobox-content">Bahan Makanan</div>
						</div>

					</div>

					<div class="infobox infobox-pink">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-file-text"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $permintaan_bahan[0] ?></span>
							<div class="infobox-content">Permintaan Bahan</div>
						</div>

					</div>

					<div class="space-6"></div>

					<div class="infobox infobox-green infobox-small infobox-dark">
						<div class="infobox-progress">
							<div class="easy-pie-chart percentage" data-percent="61" data-size="39" style="height: 39px; width: 39px; line-height: 38px;">
								<span class="percent"><?= $barang_masuk[0] ?></span>
							<canvas height="39" width="39"></canvas></div>
						</div>

						<div class="infobox-data">
							<div class="infobox-content">Barang</div>
							<div class="infobox-content">Masuk</div>
						</div>
					</div>

                    <div class="infobox infobox-red infobox-small infobox-dark">
						<div class="infobox-progress">
							<div class="easy-pie-chart percentage" data-percent="61" data-size="39" style="height: 39px; width: 39px; line-height: 38px;">
								<span class="percent"><?= $barang_keluar[0] ?></span>
							<canvas height="39" width="39"></canvas></div>
						</div>

						<div class="infobox-data">
							<div class="infobox-content">Barang</div>
							<div class="infobox-content">Keluar</div>
						</div>
					</div>
				</div>

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">

                    <caption><h5><b>Monitoring Stok Persediaan </b></h5></caption>
                    <div style="width:100%;">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-leftr">Barang</th>
                                    <th width="30%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // retrieve data dari API
                                $file = file_get_contents($url_api."tampilkan_data_monitoring_stok.php");
                                $json = json_decode($file, true);
                                $i=0;
                                while ($i < count($json['data'])) {
                                    $sisa[$i] = $json['data'][$i]['sisa'];
                                    $nama_bahan_makanan[$i] = $json['data'][$i]['id_bahan_makanan'].' - '.$json['data'][$i]['nama_bahan_makanan'];

                                    if ($sisa[$i] <= 0) {
                                        $status[$i] = '<span class="label label-danger label-white middle">
                                            <i class="ace-icon fa fa-close bigger-120"></i>
                                            habis
                                        </span>';
                                    }else{
                                        $status[$i] = '';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $nama_bahan_makanan[$i] ?></td>
                                        <td class="text-center">
                                            <?= $status[$i] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
