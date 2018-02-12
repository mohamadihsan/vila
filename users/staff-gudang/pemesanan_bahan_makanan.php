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

                    <?php
                    if (isset($_GET['form'])) {
                        if (empty($_GET['peramalan'])) {
                            ?>
                            <a href="index.php?menu=pemesanan-bahan" class="btn btn-sm"><i class="ace-icon fa fa-arrow-left bigger-110"></i> Kembali</a>
                            <?php
                        }

                        if (empty($_GET['peramalan'])) {
                            ?>
                            <div class="well">

                                <a href="#" data-toggle="collapse" data-target=".byperamalan"><i class="ace-icon fa fa-plus bigger-110"></i> <b>Pesan bahan makanan berdasarkan peramalan</b></a>

                                <div id="" class="collapse byperamalan">
                                    <form action="index.php?menu=pemesanan-bahan&form=true&peramalan=true" method="post">

                                        <!-- hidden status hapus false -->
                                        <input type="hidden" name="peramalan" value="true" class="form-control" placeholder="" readonly>

                                        <table class="table table-renponsive">
                                            <tr>
                                                <td width="15%">Periode</td>
                                                <td>
                                                    <select name="bulan" class="form-control select2" required>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Agustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
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
                                                                <option value="<?= $tahun[$i] ?>"> <?= $tahun[$i] ?></option>
                                                                <?php
                                                                if ($i==count($json['data'])-1) {
                                                                    ?><option value="<?= $tahun[$i]+1 ?>"> <?= $tahun[$i]+1 ?></option><?php
                                                                }

                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="btn-group">
                                                        <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-arrow-right bigger-120"></i> Lanjutkan</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>

                                <hr/>
                                <!-- <a href="#" data-toggle="collapse" data-target=".manual"><i class="ace-icon fa fa-plus bigger-110"></i> <b>Pesan bahan baku secara manual</b></a>

                                <div id="" class="collapse manual">
                                    <form action="../action/bahan_baku.php" method="post" class="myform">

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
                                                <td><input type="text" name="satuan" value="" class="form-control" placeholder="Misal: kilogram" required></td>
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
                                </div> -->
                            </div>
                            <?php
                        }else{

                            $bulan      = $_POST['bulan'];
                            $tahun      = $_POST['tahun'];
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
                                    <h5 class="text-danger">Tidak dapat melakukan pemesanan, karena tidak ada data peramalan pada periode ini!</h5>
                                    <a href="index.php?menu=pemesanan-bahan" class="btn btn-sm"><i class="ace-icon fa fa-arrow-left bigger-110"></i> Kembali</a>
                                    <?php
                                }else{
                                    ?>
                                    <table class="table table-renponsive">
                                        <caption>Masukkan Data Bahan Makanan:</caption>
                                        <tr>
                                            <th width="20%">Nama Bahan Makanan</th>
                                            <th width="20%">Jml Pemesanan</th>
                                            <th width="10%">Satuan</th>
                                            <th width="20%">Supplier</th>
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
                                                <td><input type="text" name="nama_bahan_makanan[]" class="form-control" value="<?= $nama_bahan_makanan[$i] ?>" readonly required></td>
                                                <td><input type="text" name="jumlah_pemesanan[]" class="form-control" value="<?= $hasil_peramalan[$i] ?>" required></td>
                                                <td>
                                                    <select class="" name="satuan[]" class="form-control" readonly>
                                                        <option value="<?= $satuan[$i] ?>"><?= $satuan[$i] ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="" name="id_supplier[]" class="form-control" readonly>
                                                        <?php
                                                        // retrieve data dari barang termurah API
                                                        $file2 = file_get_contents($url_api."tampilkan_data_bahan_makanan_termurah.php?id_bahan_makanan=".$id_bahan_makanan[$i]);
                                                        $json2 = json_decode($file2, true);
                                                        $j=0;
                                                        while ($j < count($json2['data'])) {
                                                            $id_supplier[$j]      = $json2['data'][$j]['id_supplier'];
                                                            $nama_supplier[$j]    = $json2['data'][$j]['nama_supplier'];
                                                            ?>
                                                            <option value="<?= $id_supplier[$j] ?>"><?= $nama_supplier[$j] ?></option>
                                                            <?php
                                                            $j++;
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php

                                            $i++;
                                        }
                                        ?>

                                        <tr>
                                            <td colspan="3">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-shopping-cart bigger-120"></i> Pesan</button>
                                                    <a href="index.php?menu=pemesanan&form=true" class="btn btn-sm btn-default"><i class="ace-icon fa fa-arrow-left bigger-120"></i> Batal</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                } ?>
                            </form>
                            <?php
                        }

                    }else{
                        if(empty($_GET['faktur'])){
                            ?>
                            <a href="index.php?menu=pemesanan-bahan&form=true" class="btn btn-sm"><i class="ace-icon fa fa-plus bigger-110"></i> Pemesanan</a>
                            <?php
                        }

                        if (isset($_GET['faktur'])) { ?>

                          <div class="well">

                              <?php
                              // retrieve data dari API
                              $file = file_get_contents($url_api."tampilkan_data_detail_pembelian_bahan_makanan.php?nomor_faktur=".$_GET['faktur']);
                              $json = json_decode($file, true);


                              $nomor_faktur       = $json['data'][0]['nomor_faktur'];
                              $id_supplier        = $json['data'][0]['id_supplier'];
                              $id_karyawan         = $json['data'][0]['id_karyawan'];
                              $status_pembelian   = $json['data'][0]['status_pembelian'];
                              $tanggal_pembelian  = $json['data'][0]['tanggal_pembelian'];
                              $nama_supplier      = $json['data'][0]['nama_supplier'];
                              $alamat             = $json['data'][0]['alamat'];
                              $no_telp            = $json['data'][0]['no_telp'];
                              $email              = $json['data'][0]['email'];
                              $waktu_pengiriman   = $json['data'][0]['waktu_pengiriman'];
                              $jumlahRecord       = $json['jumlahRecord'];

                              ?>

                              <div class="space-6"></div>

                              <div class="row">
                                  <div class="col-sm-10 col-sm-offset-1">
                                      <div class="widget-box transparent">
                                          <div class="widget-header widget-header-large">
                                              <h3 class="widget-title grey lighter">
                                                  <i class="ace-icon fa fa-file-text-o green"></i>
                                                  Detail Pemesanan
                                              </h3>

                                              <div class="widget-toolbar no-border invoice-info">
                                                  <span class="invoice-info-label">No Faktur:</span>
                                                  <span class="red"><?= $nomor_faktur ?></span>

                                                  <br />
                                                  <span class="invoice-info-label">Tanggal:</span>
                                                  <span class="blue"><?= $tanggal_pembelian ?></span>
                                              </div>
                                          </div>

                                          <div class="widget-body">
                                              <div class="widget-main padding-24">
                                                  <div class="row">

                                                      <div class="col-sm-6">
                                                          <div class="row">
                                                              <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                                  <b>Informasi Supplier</b>
                                                              </div>
                                                          </div>

                                                          <div>
                                                              <ul class="list-unstyled  spaced">
                                                                  <li>
                                                                      <i class="ace-icon fa fa-caret-right green"></i>Supplier : <?= $id_supplier.' - '.$nama_supplier ?>
                                                                  </li>

                                                                  <li>
                                                                      <i class="ace-icon fa fa-caret-right green"></i>Alamat : <?= $alamat ?>
                                                                  </li>

                                                                  <li>
                                                                      <i class="ace-icon fa fa-caret-right green"></i>No Telp : <?= $no_telp ?>
                                                                  </li>

                                                                  <li class="divider"></li>

                                                                  <li>
                                                                      <i class="ace-icon fa fa-file-text-o green"></i>Detail Pemesanan
                                                                  </li>
                                                              </ul>
                                                          </div>
                                                      </div><!-- /.col -->
                                                  </div><!-- /.row -->

                                                  <div>

                                                      <table class="table table-striped table-bordered">
                                                          <thead>
                                                              <tr>
                                                                  <th class="center">#</th>
                                                                  <th width="40%">Barang</th>
                                                                  <th class="hidden-xs">Jumlah</th>
                                                                  <th class="hidden-480">Harga</th>
                                                                  <th>Sub Total</th>
                                                              </tr>
                                                          </thead>

                                                          <tbody>
                                                              <?php
                                                              $no = 1;
                                                              $total = 0;
                                                              $sub_total = 0;
                                                              for ($i=0; $i < $jumlahRecord; $i++) {

                                                                $no                 = $json['data'][$i]['no'];
                                                                $jumlah_pembelian   = $json['data'][$i]['jumlah_pembelian'];
                                                                $id_bahan_makanan      = $json['data'][$i]['id_bahan_makanan'];
                                                                $nama_bahan_makanan    = $json['data'][$i]['nama_bahan_makanan'];
                                                                $harga_bahan_makanan   = $json['data'][$i]['harga_bahan_makanan'];
                                                                $satuan             = $json['data'][$i]['satuan'];

                                                                  $sub_total = $harga_bahan_makanan * $jumlah_pembelian;
                                                                  $total = $total + $sub_total;
                                                                  ?>
                                                                  <tr>
                                                                      <td class="center">
                                                                          <?= $no++ ?>
                                                                      </td>

                                                                      <td>
                                                                          <?= $nama_bahan_makanan ?>
                                                                      </td>
                                                                      <td class="hidden-xs">
                                                                          <?= $jumlah_pembelian.' '.$satuan ?>
                                                                      </td>
                                                                      <td class="hidden-480">
                                                                          <?= 'Rp.'.Rupiah($harga_bahan_makanan) ?></td>
                                                                      <td>
                                                                          <?= 'Rp.'.Rupiah($sub_total) ?>
                                                                      </td>
                                                                  </tr>
                                                                  <?php
                                                              }
                                                              ?>
                                                          </tbody>
                                                      </table>
                                                  </div>

                                                  <div class="hr hr8 hr-double hr-dotted"></div>

                                                  <div class="row">
                                                      <div class="col-sm-5 pull-right">
                                                          <h4 class="pull-right">
                                                              Total Pemesanan :
                                                              <span class="red"><?= 'Rp.'.Rupiah($total) ?></span>
                                                          </h4>
                                                      </div>
                                                  </div>

                                                  <div class="space-6"></div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <?php
                        }else{
                        ?>

                            <div id="" class="collapse tampil_detail">
                                <div class="well">
                                Detail Pemesanan
                                <button data-toggle="collapse" data-target=".tampil_detail" class="btn btn-sm"><i class="ace-icon fa fa-close bigger-110"></i> Tutup</button>

                                </div>
                            </div>

                            <div class="clearfix">
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header">
                                Daftar data "Pembelian Bahan Makanan"
                            </div>
                            <!-- div.table-responsive -->

                            <!-- div.dataTables_borderWrap -->
                            <div class="table table-responsive">
                                <table id="mytable" class="display" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="">
                                            <th width="5%" class="text-center">No</th>
                                            <th width="15%" class="text-left">Nomor Faktur</th>
                                            <th width="10%" class="text-left">Supplier</th>
                                            <th width="10%" class="text-left">Karyawan</th>
                                            <th width="12%" class="text-center">Status Pembelian</th>
                                            <th width="15%" class="text-center">Tanggal</th>
                                            <th width="12%" class="text-center"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <?php
                        } ?>

                        <!-- loading -->
                        <center><div id="loading"></div></center>
                        <div id="result"></div>

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
