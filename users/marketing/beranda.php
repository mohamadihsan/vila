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
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 infobox-container">
                    <?php
                    // retrieve data dari API
                    $file = file_get_contents($url_api."tampilkan_data_marketing.php");
                    $json = json_decode($file, true);
                    $i=0;
                    while ($i < count($json['data'])) {
                        $tamu[$i] = $json['data'][$i]['tamu'];
                        $reservasi[$i] = $json['data'][$i]['reservasi'];
                        $i++;
                    }
                    ?>
                    <caption><h5><b>Data Marketing </b></h5></caption>
					<div class="infobox infobox-green">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-list"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $tamu[0] ?></span>
							<div class="infobox-content">Total Tamu</div>
						</div>
					</div>

					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-cubes"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $reservasi[0] ?></span>
							<div class="infobox-content">Total Reservasi</div>
						</div>

					</div>

				</div>

                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <h5><b>Filter :</b></h5>
                    <form action="" method="get">
                        <select name="periode" class="form-control select2" required>
                            <?php
                            // retrieve data dari API
                            $file = file_get_contents($url_api."tampilkan_data_tahun_reservasi.php");
                            $json = json_decode($file, true);
                            $i=0;
                            if (count($json['data']) == 0) {
                                ?><option value="<?= date('Y')?>"><?= date('Y') ?></option><?php
                            }else{
                                while ($i < count($json['data'])) {
                                    $tahun[$i] = $json['data'][$i]['tahun'];
                                    ?>
                                    <option value="<?= $tahun[$i] ?>" <?php if(isset($_GET['periode'])){ if($_GET['periode']==$tahun[$i]) echo 'selected'; } ?>> <?= $tahun[$i] ?></option>
                                    <?php
                                    if ($i==count($json['data'])-1) {
                                        ?><option value="<?= $tahun[$i]+1 ?>" <?php if(isset($_GET['periode'])){ if($_GET['periode']==$tahun[$i]+1) echo 'selected'; } ?>> <?= $tahun[$i]+1 ?></option><?php
                                    }

                                    $i++;
                                }
                            }
                            ?>

                        </select>
                        <button type="submit" class="btn btn-sm">Filter</button>
                    </form>

                    <div style="width:100%;">
                        <canvas id="canvas"></canvas>
                    </div>

                </div>

            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
if (isset($_GET['periode'])) {
    $periode = $_GET['periode'];
    $param = "?periode=".$periode;
}else{
    $param = '';
}
?>
<script>
$(document).ready(function(){
    $.ajax({
        url: "http://127.0.0.1/vila/action/tampilkan_data_monitoring_reservasi.php<?= $param ?>",
        method: "GET",
        success: function(data) {
            console.log(data);
            var periode = [];
            var jumlah_orang = [];
            var tahun;
            var obj = JSON.parse(data);
            $.each(obj, function(key, val) {
                periode.push(val.periode);
                jumlah_orang.push(val.jumlah_orang);

                tahun = val.tahun;
            })

            var chartdata = {
                labels: periode,
                datasets : [
                    {
                        label: "Data Reservasi",
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        fill: false,
                        data: jumlah_orang
                    }
                ],
            };

            var ctx = $("#canvas");

            var barGraph = new Chart(ctx, {
                type: 'line',
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        text:'Grafik Jumlah Reservasi ' + tahun
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Periode'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jumlah'
                            },
                            ticks: {
                                beginAtZero: true,
                                steps: 10
                            }
                        }]
                    }
                },
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
</script>
