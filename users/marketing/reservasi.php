<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Reservasi</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Reservasi
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Pengolahan Data
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <button data-toggle="collapse" data-target=".tampil" class="btn btn-sm"><i class="ace-icon fa fa-plus bigger-110"></i> Form</button>

                    <div id="" class="collapse tampil">
                        <div class="well">
                            <form action="../action/reservasi.php" method="post" class="myform">

                                <!-- hidden status hapus false -->
                                <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                                <table class="table table-renponsive">
                                    <caption>Masukkan Data Reservasi:</caption>
                                    <tr>
                                        <td width="15%">ID Reservasi</td>
                                        <td><input type="text" name="id_reservasi" value="" class="form-control" placeholder="ID akan dibuat secara otomatis" readonly></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">ID Tamu</td>
                                        <td>
                                        <select name="id_tamu" class="form-control select2" required>
                                                <?php
                                                // retrieve data dari API
                                                $file = file_get_contents($url_api."tampilkan_data_tamu.php");
                                                $json = json_decode($file, true);
                                                $i=0;
                                                while ($i < count($json['data'])) {
                                                    $id_tamu[$i] = $json['data'][$i]['id_tamu'];
                                                    $nama_tamu[$i] = $json['data'][$i]['id_tamu'].' - '.$json['data'][$i]['nama_tamu'];
                                                    ?>
                                                    <option value="<?= $id_tamu[$i] ?>"> <?= $nama_tamu[$i] ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                            <a href="./index.php?menu=tamu" class="btn btn-sm btn-default" title="tambah data tamu"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jumlah (orang)</td>
                                        <td><input type="number" name="jumlah_orang" value="" class="form-control" min="1" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Tanggal reservasi</td>
                                        <td><input type="date" name="tanggal_reservasi" value="<?= date('Y-m-d') ?>" class="form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Status Reservasi</td>
                                        <td>
                                            <select name="status_reservasi" class="form-control">
                                                <option value="null">Kosongkan</option>
                                                <option value="1">Valid</option>
                                                <option value="0">Tidak Valid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-save bigger-120"></i> Simpan</button>
                                                <button type="reset" class="btn btn-sm btn-default"><i class="ace-icon fa fa-refresh bigger-120"></i> Reset</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>

                    <!-- loading -->
                    <center><div id="loading"></div></center>
                    <div id="result"></div>

                    <div id="" class="collapse tampil_detail">
                        <div class="well">
                        Detail
                        <button data-toggle="collapse" data-target=".tampil_detail" class="btn btn-sm"><i class="ace-icon fa fa-close bigger-110"></i> Tutup</button>

                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Daftar data "Reservasi"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="5%" class="text-center">No</th>
                                    <th width="15%" class="text-left">ID Reservasi</th>
                                    <th width="10%" class="text-left">ID Tamu</th>
                                    <th width="10%" class="text-left">Jumlah (orang)</th>
                                    <th width="15%" class="text-left">Tanggal Reservasi</th>
                                    <th width="15%" class="text-left">Status</th>
                                    <th width="15%" class="text-left"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
            <form method="post" action="../action/reservasi.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="id_reservasi" readonly>
                    <p>Apakah anda akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function ubah(id_reservasi, id_tamu, jumlah_orang, status_reservasi){
        $('.well input[name=id_reservasi]').val(id_reservasi);
        $('.well select[name=id_tamu]').val(id_tamu);
        $('.well input[name=jumlah_orang]').val(jumlah_orang);
        $('.well select[name=status_reservasi]').val(status_reservasi);
    }

    function hapus(id_reservasi){
        $('.modal-body input[name=id_reservasi]').val(id_reservasi);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_reservasi.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_reservasi' } ,
                            { mData: 'id_tamu' } ,
                            { mData: 'jumlah_orang' },
                            { mData: 'tanggal_reservasi' },
                            { mData: 'status_reservasi' },
                            { mData: 'action' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

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
                $("#hapus").modal('hide');
                $('#mytable').DataTable().ajax.reload();
        },
            error: function(jqXHR, textStatus, errorThrown){
        }
    });
        e.preventDefault(); //Prevent Default action.
        e.unbind();
    });
</script>
