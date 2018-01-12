<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Barang Keluar dari Gudang</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Barang Keluar dari Gudang
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
                            <form action="../action/barang_keluar.php" method="post" class="myform">

                                <!-- hidden status hapus false -->
                                <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>
                                <input type="hidden" name="id_bahan_makanan_lama" value="" class="form-control" placeholder="" readonly>
                                <input type="hidden" name="tanggal_lama" value="" class="form-control" placeholder="" readonly>

                                <table class="table table-renponsive">
                                    <caption>Masukkan Data Barang (Bahan Baku):</caption>
                                    <tr>
                                        <td width="15%">Barang</td>
                                        <td>
                                            <input type="hidden" name="ubah" value="">
                                            <select name="id_bahan_makanan" id="id_bahan_makanan" class="form-control" required>
                                                <?php
                                                // retrieve data dari API
                                                $file = file_get_contents($url_api."tampilkan_data_bahan_makanan.php");
                                                $json = json_decode($file, true);
                                                $i=0;
                                                while ($i < count($json['data'])) {
                                                    $id_bahan_makanan[$i] = $json['data'][$i]['id_bahan_makanan'];
                                                    $nama_bahan_makanan[$i] = $json['data'][$i]['id_bahan_makanan'].' - '.$json['data'][$i]['nama_bahan_makanan'];
                                                    ?>
                                                    <option value="<?= $id_bahan_makanan[$i] ?>"> <?= $nama_bahan_makanan[$i] ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Qty Barang Keluar</td>
                                        <td><input type="number" name="barang_keluar" value="1" min="1" class="form-control" placeholder="" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Harga satuan</td>
                                        <td><input type="number" name="harga_satuan" value="" min="0" class="form-control" placeholder="" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Tanggal</td>
                                        <td><input type="date" name="tanggal" id="tanggal" value="0" class="form-control" placeholder="" required></td>
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

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Daftar data "Barang Keluar dari Gudang"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="5%" class="text-center">No</th>
                                    <th width="10%" class="text-left">ID Barang</th>
                                    <th width="18%" class="text-left">Nama Barang</th>
                                    <th width="10%" class="text-left">Qty Barang</th>
                                    <th width="10%" class="text-left">Satuan</th>
                                    <th width="10%" class="text-left">Harga Satuan</th>
                                    <th width="10%" class="text-left">Tanggal</th>
                                    <th width="13%" class="text-center"></th>
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
            <form method="post" action="../action/persediaan.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="barang" value="keluar" readonly>
                    <input type="hidden" name="id_bahan_makanan" readonly>
                    <input type="hidden" name="tanggal" readonly>
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
    function ubah(id_bahan_makanan, barang_masuk, barang_keluar, harga_satuan, tanggal){
        $('.well input[name=ubah]').val(id_bahan_makanan);
        $('.well select[name=id_bahan_makanan]').val(id_bahan_makanan);
        $('.well input[name=id_bahan_makanan_lama]').val(id_bahan_makanan);
        $('.well input[name=barang_masuk]').val(barang_masuk);
        $('.well input[name=barang_keluar]').val(barang_keluar);
        $('.well input[name=harga_satuan]').val(harga_satuan);
        $('.well input[name=tanggal]').val(tanggal);
        $('.well input[name=tanggal_lama]').val(tanggal);
        $('#tanggal').prop('readonly', true);
        $('#id_bahan_makanan').prop('disabled', true);
    }

    function hapus(id_bahan_makanan, tanggal){
        $('.modal-body input[name=id_bahan_makanan]').val(id_bahan_makanan);
        $('.modal-body input[name=tanggal]').val(tanggal);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_persediaan.php?status=keluar' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_bahan_makanan' } ,
                            { mData: 'nama_bahan_makanan' } ,
                            { mData: 'barang_keluar' } ,
                            { mData: 'satuan' } ,
                            { mData: 'harga_satuan' } ,
                            { mData: 'tanggal' },
                            { mData: 'action'}
                    ]
        });

        //Callback handler for form submit event
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

    });
</script>
