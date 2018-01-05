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
                    <h5><b>Filter :</b></h5>
                    <form action="" method="get">
                        <select name="id" class="form-control select2" required>
                            <?php
                            // retrieve data dari API
                            $file = file_get_contents($url_api."tampilkan_data_bahan_makanan.php");
                            $json = json_decode($file, true);
                            $i=0;
                            while ($i < count($json['data'])) {
                                $id_bahan_makanan[$i] = $json['data'][$i]['id_bahan_makanan'];
                                $nama_bahan_makanan[$i] = $json['data'][$i]['id_bahan_makanan'].' - '.$json['data'][$i]['nama_bahan_makanan'];
                                ?>
                                <option value="<?= $id_bahan_makanan[$i] ?>" <?php if(isset($_GET['id'])){ if($_GET['id']==$id_bahan_makanan[$i]) echo 'selected'; } ?>> <?= $nama_bahan_makanan[$i] ?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <select name="periode" class="form-control select2" required>
                            <?php
                            // retrieve data dari API
                            $file = file_get_contents($url_api."tampilkan_data_tahun_peramalan.php");
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

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

                    <caption><h5><b>Monitoring persediaan <?= date('M-Y') ?></b></h5></caption>
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

<?php
if (isset($_GET['periode'])) {
    $periode = $_GET['periode'];
    $id = $_GET['id'];
    $param = "?periode=".$periode."&id=".$id;
}else{
    $param = '';
}
?>
<script>
$(document).ready(function(){
    $.ajax({
        url: "http://127.0.0.1/vila/action/tampilkan_data_monitoring_persediaan.php<?= $param ?>",
        method: "GET",
        success: function(data) {
            console.log(data);
            var periode = [];
            var hasil_peramalan = [];
            var pengeluaran = [];
            var tahun;
            var id_bahan_makanan;
            var obj = JSON.parse(data);
            $.each(obj, function(key, val) {
                periode.push(val.periode);
                hasil_peramalan.push(val.hasil_peramalan);
                pengeluaran.push(val.pengeluaran);

                tahun = val.tahun;
                id_bahan_makanan = val.id_bahan_makanan;
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
                        text:'Grafik Pengeluaran dan Peramalan Bahan Makanan ' + id_bahan_makanan + ' ' + tahun
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
