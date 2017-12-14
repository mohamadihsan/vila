<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Bahan Makanan</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Bahan Makanan
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
                            <form action="../action/bahan_makanan.php" method="post" class="myform">

                                <!-- hidden status hapus false -->
                                <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                                <table class="table table-renponsive">
                                    <caption>Masukkan Data Bahan Makanan:</caption>
                                    <tr>
                                        <td width="15%">ID Bahan Makanan</td>
                                        <td><input type="text" name="id_bahan_makanan" value="" class="form-control" placeholder="ID akan dibuat secara otomatis" readonly></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama Bahan Makanan</td>
                                        <td><input type="text" name="nama_bahan_makanan" value="" class="form-control" placeholder="Misal: Tepung" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Satuan</td>
                                        <td>
                                            <select name="satuan" class="form-control">
                                                <option value="bks">bks</option>
                                                <option value="botol">botol</option>
                                                <option value="btl">btl</option>
                                                <option value="bt">bt</option>
                                                <option value="can">can</option>
                                                <option value="dus">dus</option>
                                                <option value="ekor">ekor</option>
                                                <option value="gln">gln</option>
                                                <option value="kg">kg</option>
                                                <option value="lbr">lbr</option>
                                                <option value="lkt">lkt</option>
                                                <option value="pax">pax</option>
                                                <option value="pcs">pcs</option>
                                                <option value="psg">psg</option>
                                                <option value="ptg">ptg</option>
                                                <option value="roll">roll</option>
                                                <option value="tbg">tbg</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Kategori</td>
                                        <td>
                                            <select name="kategori" class="form-control">
                                                <option value="cepat busuk">cepat busuk</option>
                                                <option value="basah awet">basah awet</option>
                                                <option value="kering">kering</option>
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

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Daftar data "Bahan Makanan"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="7%" class="text-center">No</th>
                                    <th width="15%" class="text-left">ID</th>
                                    <th width="30%" class="text-left">Nama</th>
                                    <th width="15%" class="text-left">Satuan</th>
                                    <th width="15%" class="text-center">Kategori</th>
                                    <th width="20%" class="text-center"></th>
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
            <form method="post" action="../action/bahan_makanan.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="id_bahan_makanan" readonly>
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
    function ubah(id_bahan_makanan, nama_bahan_makanan, satuan, kategori){
        $('.well input[name=id_bahan_makanan]').val(id_bahan_makanan);
        $('.well input[name=nama_bahan_makanan]').val(nama_bahan_makanan);
        $('.well select[name=satuan]').val(satuan);
        $('.well select[name=kategori]').val(kategori);
    }

    function hapus(id_bahan_makanan){
        $('.modal-body input[name=id_bahan_makanan]').val(id_bahan_makanan);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_bahan_makanan.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_bahan_makanan' } ,
                            { mData: 'nama_bahan_makanan' } ,
                            { mData: 'satuan' },
                            { mData: 'kategori' },
                            { mData: 'action'}
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4,5] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
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
