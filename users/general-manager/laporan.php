<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Laporan</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Laporan
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Vila Air Nautural Resort
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="well">
                        <label for=""><b>Filter :</b></label>
                        <form action="" method="get" class="">

                            <input type="hidden" name="menu" value="laporan">

                            <select name="nama" class="form-control select2" required>
                                <option value="pemakaian-bahan" <?php if(isset($_GET['nama'])){ if($_GET['nama']=='pemakaian-bahan') echo "selected"; } ?>>Laporan Pemakaian Bahan</option>
                                <option value="pembelian-bahan" <?php if(isset($_GET['nama'])){ if($_GET['nama']=='pembelian-bahan') echo "selected"; } ?>>Laporan Pembelian Bahan</option>
                                <option value="persediaan-bahan" <?php if(isset($_GET['nama'])){ if($_GET['nama']=='persediaan-bahan') echo "selected"; } ?>>Laporan Persediaan Bahan</option>
                            </select>

                            <select name="bulan" class="form-control select2" required>
                                <option value="semua" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='semua') echo "selected"; } ?>>Januari - Desember</option>
                                <option value="01" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='01') echo "selected"; } ?>>Januari</option>
                                <option value="02" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='02') echo "selected"; } ?>>Februari</option>
                                <option value="03" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='03') echo "selected"; } ?>>Maret</option>
                                <option value="04" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='04') echo "selected"; } ?>>April</option>
                                <option value="05" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='05') echo "selected"; } ?>>Mei</option>
                                <option value="06" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='06') echo "selected"; } ?>>Juni</option>
                                <option value="07" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='07') echo "selected"; } ?>>Juli</option>
                                <option value="08" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='08') echo "selected"; } ?>>Agustus</option>
                                <option value="09" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='09') echo "selected"; } ?>>September</option>
                                <option value="10" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='10') echo "selected"; } ?>>Oktober</option>
                                <option value="11" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='11') echo "selected"; } ?>>November</option>
                                <option value="12" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='12') echo "selected"; } ?>>Desember</option>
                            </select>

                            <select name="tahun" class="form-control select2" required>
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
                                        <option value="<?= $tahun[$i] ?>" <?php if(isset($_GET['tahun'])){ if($_GET['tahun']==$tahun[$i]) echo "selected"; } ?>> <?= $tahun[$i] ?></option>
                                        <?php
                                        if ($i==count($json['data'])-1) {
                                            ?><option value="<?= $tahun[$i]+1 ?>" <?php if(isset($_GET['tahun'])){ if($_GET['tahun']==$tahun[$i]+1) echo "selected"; } ?>> <?= $tahun[$i]+1 ?></option><?php
                                        }

                                        $i++;
                                    }
                                }
                                ?>

                            </select>
                            <hr/>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Tampilkan</button>

                        </form>
                    </div>

                    <!-- loading -->
                    <center><div id="loading"></div></center>
                    <div id="result"></div>

                    <?php
                    if (isset($_GET['nama'])) {

                        $param = "?nama=".$_GET['nama']."&bulan=".$_GET['bulan']."&tahun=".$_GET['tahun'];

                        ?>
                        <div class="clearfix">
                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                            Hasil Filter:
                        </div>
                        <!-- div.table-responsive -->

                        <!-- div.dataTables_borderWrap -->
                        <div class="table table-bordered table-responsive">
                            <table id="" class="display" width="100%" cellspacing="0">

                                <?php
                                if ($_GET['nama']=='pemakaian-bahan') {
                                    ?>
                                    <tbody>
                                        <?php
                                        // retrieve data dari API
                                        $file = file_get_contents($url_api."tampilkan_laporan.php".$param);
                                        $json = json_decode($file, true);
                                        $i=0;
                                        if (count($json['data']) == 0) {
                                            ?>
                                            <tr>
                                                <th colspan="6" class="text-center text-danger">Data tidak ditemukan</th>
                                            </tr>
                                            <?php
                                        }else{
                                            ?>

                                            <thead>
                                                <tr class="">
                                                    <th width="3%" class="text-center">No</th>
                                                    <th width="10%" class="text-left">ID Bahan</th>
                                                    <th width="15%" class="text-left">Nama Bahan</th>
                                                    <th width="10%" class="text-center">Jumlah Pemakaian</th>
                                                    <th width="10%" class="text-center">Satuan</th>
                                                    <th width="10%" class="text-left">Periode</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            while ($i < count($json['data'])) {
                                                $no[$i] = $json['data'][$i]['no'];
                                                $ibm[$i] = $json['data'][$i]['id_bahan_makanan'];
                                                $nama[$i] = $json['data'][$i]['nama_bahan_makanan'];
                                                $jml[$i] = $json['data'][$i]['jml_pemakaian'];
                                                $satuan[$i] = $json['data'][$i]['satuan'];
                                                $periode[$i] = $json['data'][$i]['periode'];
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $no[$i] ?></td>
                                                    <td><?= $ibm[$i] ?></td>
                                                    <td><?= $nama[$i] ?></td>
                                                    <td class="text-center"><?= $jml[$i] ?></td>
                                                    <td class="text-center"><?= $satuan[$i] ?></td>
                                                    <td><?= $periode[$i] ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }else if ($_GET['nama']=='pembelian-bahan') {
                                    ?>
                                    <tbody>
                                        <?php
                                        // retrieve data dari API
                                        $file = file_get_contents($url_api."tampilkan_laporan.php".$param);
                                        $json = json_decode($file, true);
                                        $i=0;
                                        if (count($json['data']) == 0) {
                                            ?>
                                            <tr>
                                                <th colspan="6" class="text-center text-danger">Data tidak ditemukan</th>
                                            </tr>
                                            <?php
                                        }else{
                                            ?>

                                            <thead>
                                                <tr class="">
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
                                            </thead>

                                            <?php
                                            while ($i < count($json['data'])) {
                                                $no[$i] = $json['data'][$i]['no'];
                                                $nomor_faktur[$i] = $json['data'][$i]['nomor_faktur'];
                                                $ibm[$i] = $json['data'][$i]['id_bahan_makanan'];
                                                $nama[$i] = $json['data'][$i]['nama_bahan_makanan'];
                                                $jumlah_pembelian[$i] = $json['data'][$i]['jumlah_pembelian'];
                                                $harga_bahan_makanan[$i] = $json['data'][$i]['harga_bahan_makanan'];
                                                $satuan[$i] = $json['data'][$i]['satuan'];
                                                $id_supplier[$i] = $json['data'][$i]['id_supplier'];
                                                $status[$i] = $json['data'][$i]['status_pembelian'];
                                                $periode[$i] = $json['data'][$i]['periode'];
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $no[$i] ?></td>
                                                    <td><?= $nomor_faktur[$i] ?></td>
                                                    <td><?= $ibm[$i] ?></td>
                                                    <td><?= $nama[$i] ?></td>
                                                    <td class="text-right"><?= $harga_bahan_makanan[$i] ?></td>
                                                    <td class="text-center"><?= $jumlah_pembelian[$i] ?></td>
                                                    <td class="text-center"><?= $satuan[$i] ?></td>
                                                    <td class="text-center"><?= $id_supplier[$i] ?></td>
                                                    <td class="text-center"><?= $status[$i] ?></td>
                                                    <td><?= $periode[$i] ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }else if ($_GET['nama']=='persediaan-bahan') {
                                    ?>
                                    <tbody>
                                        <?php
                                        // retrieve data dari API
                                        $file = file_get_contents($url_api."tampilkan_laporan.php".$param);
                                        $json = json_decode($file, true);
                                        $i=0;
                                        if (count($json['data']) == 0) {
                                            ?>
                                            <tr>
                                                <th colspan="6" class="text-center text-danger">Data tidak ditemukan</th>
                                            </tr>
                                            <?php
                                        }else{
                                            ?>

                                            <thead>
                                                <tr class="">
                                                    <th width="3%" class="text-center">No</th>
                                                    <th width="10%" class="text-left">ID Bahan</th>
                                                    <th width="15%" class="text-left">Nama Bahan</th>
                                                    <th width="10%" class="text-center">Barang Masuk</th>
                                                    <th width="10%" class="text-center">Barang Keluar</th>
                                                    <th width="10%" class="text-center">Satuan</th>
                                                    <th width="10%" class="text-left">Periode</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            while ($i < count($json['data'])) {
                                                $no[$i] = $json['data'][$i]['no'];
                                                $ibm[$i] = $json['data'][$i]['id_bahan_makanan'];
                                                $nama[$i] = $json['data'][$i]['nama_bahan_makanan'];
                                                $barang_masuk[$i] = $json['data'][$i]['barang_masuk'];
                                                $barang_keluar[$i] = $json['data'][$i]['barang_keluar'];
                                                $satuan[$i] = $json['data'][$i]['satuan'];
                                                $periode[$i] = $json['data'][$i]['periode'];
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $no[$i] ?></td>
                                                    <td><?= $ibm[$i] ?></td>
                                                    <td><?= $nama[$i] ?></td>
                                                    <td class="text-center"><?= $barang_masuk[$i] ?></td>
                                                    <td class="text-center"><?= $barang_keluar[$i] ?></td>
                                                    <td class="text-center"><?= $satuan[$i] ?></td>
                                                    <td><?= $periode[$i] ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                }
                                ?>

                            </table>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
if(isset($_GET['nama_laporan'])){
    $param = "?nama=".$_GET['nama_laporan']."&bulan=".$_GET['bulan']."&tahun=".$_GET['tahun'];
}else{
    $param = '';
}
?>

<script>

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_laporan.php'.$param ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_karyawan' } ,
                            { mData: 'nama_karyawan' } ,
                            { mData: 'email' },
                            { mData: 'divisi' },
                            { mData: 'nama_pengguna' },
                            { mData: 'action' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

        $(".myform").submit(function(e)
        {

        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);
        $.ajax({
            url: formURL,
            type: 'GET',
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function (){
                       $("#loading").show(1000).html("<img src='../assets/images/loading.gif' height='100'>");
                       },
            success: function(data, textStatus, jqXHR){
                    $("#result").html(data);
                    $("#loading").hide();
                    $('#mytable').DataTable().ajax.reload();
            },
                error: function(jqXHR, textStatus, errorThrown){
         }
        });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });

    });
</script>
