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
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div style="width:100%;">
                        <canvas id="canvas"></canvas>
                    </div>

                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                    <caption><h5><b>Monitoring persediaan</b></h5></caption>
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

<script>
$(document).ready(function(){
    $.ajax({
        url: "http://127.0.0.1/vila/action/tampilkan_data_monitoring_persediaan.php",
        method: "GET",
        success: function(data) {
            console.log(data);
            var periode = [];
            var hasil_peramalan = [];
            var pengeluaran = [];
            var obj = JSON.parse(data);
            $.each(obj, function(key, val) {
                periode.push(val.periode);
                hasil_peramalan.push(val.hasil_peramalan);
                pengeluaran.push(val.pengeluaran);
            })

            // for(var i in data) {
            //     periode.push("P. " + data[i].periode);
            //     hasil_peramalan.push(data[i].hasil_peramalan);
            //     pengeluaran.push(data[i].hasil_peramalan);
            // }

            var chartdata = {
                labels: periode,
                datasets : [
                    {
                        label: "Data Pengeluaran Barang",
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        fill: false,
                        data: pengeluaran
                    },
                    {
                        label: 'Peramalan',
                        backgroundColor: window.chartColors.blue,
                        borderColor: window.chartColors.blue,
                        fill: false,
                        data: hasil_peramalan
                    },
                ],
            };

            var ctx = $("#canvas");

            var barGraph = new Chart(ctx, {
                type: 'line',
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        text:'Grafik Pengeluaran dan Peramalan Bahan Makanan'
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
