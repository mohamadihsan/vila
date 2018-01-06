<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Pemesanan Bahan Makanan</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Pemesanan Bahan Makanan
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Pengolahan Data
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="well">

                        <label for=""><b>Filter:</b></label>
                        <div id="" class="byperamalan">
                            <form action="index.php?menu=kebutuhan-bahan&detail=true" method="get">

                                <input type="hidden" name="menu" value="kebutuhan-bahan">
                                <input type="hidden" name="detail" value="true">
                                <table class="table table-renponsive">
                                    <tr>
                                        <td>
                                            <select name="bulan" class="form-control select2" required>
                                                <option value="01" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='01') echo 'selected'; } ?>>Januari</option>
                                                <option value="02" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='02') echo 'selected'; } ?>>Februari</option>
                                                <option value="03" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='03') echo 'selected'; } ?>>Maret</option>
                                                <option value="04" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='04') echo 'selected'; } ?>>April</option>
                                                <option value="05" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='05') echo 'selected'; } ?>>Mei</option>
                                                <option value="06" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='06') echo 'selected'; } ?>>Juni</option>
                                                <option value="07" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='07') echo 'selected'; } ?>>Juli</option>
                                                <option value="08" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='08') echo 'selected'; } ?>>Agustus</option>
                                                <option value="09" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='09') echo 'selected'; } ?>>September</option>
                                                <option value="10" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='10') echo 'selected'; } ?>>Oktober</option>
                                                <option value="11" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='11') echo 'selected'; } ?>>November</option>
                                                <option value="12" <?php if(isset($_GET['bulan'])){ if($_GET['bulan']=='12') echo 'selected'; } ?>>Desember</option>
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
                                                        <option value="<?= $tahun[$i] ?>" <?php if(isset($_GET['tahun'])){ if($_GET['tahun']==$tahun[$i]) echo 'selected'; } ?>> <?= $tahun[$i] ?></option>
                                                        <?php
                                                        if ($i==count($json['data'])-1) {
                                                            ?><option value="<?= $tahun[$i]+1 ?>" <?php if(isset($_GET['tahun'])){ if($_GET['tahun']==$tahun[$i]+1) echo 'selected'; } ?>> <?= $tahun[$i]+1 ?></option><?php
                                                        }

                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-eye bigger-120"></i> Tampilkan</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                        <hr/>
                    </div>

                    <?php
                    if (isset($_GET['detail'])) {

                        $bulan      = $_GET['bulan'];
                        $tahun      = $_GET['tahun'];
                        $periode    = $bulan.'-'.$tahun;

                        // retrieve data jumlah barang yang dipesan berdasarkan peramalan dari API
                        $file = file_get_contents($url_api."pemesanan_bahan_makanan_berdasarkan_peramalan.php?peramalan=true&periode=".$periode);
                        $json = json_decode($file, true);

                        $i=0;
                        ?>

                        <form action="../action/pemesanan_bahan_makanan.php" method="post" class="myform">

                            <!-- hidden status hapus false -->
                            <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                            <?php
                            if ($json['jumlahRecord'] == 1 AND $json['data'][0]['id_bahan_makanan'] == '') {
                                ?>
                                <h5 class="text-danger"><i class="fa fa-warning"></i> Data Kebutuhan Bahan Makanan tidak dapat ditentukan, Silahan lakukan proses peramalan terlebih dahulu!</h5>
                                <?php
                            }else{
                                ?>
                                <table class="table table-renponsive">
                                    <caption><b>Kebutuhan Bahan Makanan:</b></caption>
                                    <tr>
                                        <th width="30%">Nama Bahan Makanan</th>
                                        <th width="70%">Jml Pemesanan</th>
                                    </tr>
                                    <?php
                                    while ($i < count($json['data'])) {
                                        $id_bahan_makanan[$i]      = $json['data'][$i]['id_bahan_makanan'];
                                        $nama_bahan_makanan[$i]    = $json['data'][$i]['nama_bahan_makanan'];
                                        $satuan[$i]             = $json['data'][$i]['satuan'];
                                        $hasil_peramalan[$i]    = $json['data'][$i]['hasil_peramalan'];
                                        ?>

                                        <!-- input hiddent -->
                                        <input type="hidden" name="id_bahan_makanan[]" class="form-control" value="<?= $id_bahan_makanan[$i] ?>" readonly required>

                                        <tr>
                                            <td><?= strtoupper($nama_bahan_makanan[$i]) ?></td>
                                            <td><?= $hasil_peramalan[$i].' '.$satuan[$i] ?></td>
                                        </tr>
                                        <?php

                                        $i++;
                                    }
                                    ?>

                                </table>
                                <?php
                            } ?>
                        </form>
                        <?php
                    } ?>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<!-- Modal Hapus -->
<div class="modal fade" id="hapus" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-trash"></i> Hapus Data</h4>
            </div>
            <form method="post" action="../action/pembelian_bahan_makanan.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="nomor_faktur" readonly>
                    <p>Apakah anda akan menghapus data pembelian ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function detail(nomor_faktur){

    }

    function hapus(nomor_faktur){
        $('.modal-body input[name=nomor_faktur]').val(nomor_faktur);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_pembelian_bahan_makanan.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'nomor_faktur' } ,
                            { mData: 'id_supplier' } ,
                            { mData: 'id_karyawan' },
                            { mData: 'status_pembelian' },
                            { mData: 'tanggal_pembelian' },
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
            type: 'POST',
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
