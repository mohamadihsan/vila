<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Permintaan Menu</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Permintaan Menu
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Daftar Permintaan
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <?php
                    if (empty($_GET['id'])) {
                        ?>

                        <div class="clearfix">
                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                            Daftar data "Permintaan Menu"
                        </div>
                        <!-- div.table-responsive -->

                        <!-- div.dataTables_borderWrap -->
                        <div class="table table-responsive">
                            <table id="mytable" class="display" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="">
                                        <th width="5%" class="text-center">No</th>
                                        <th width="30%" class="text-left">ID Reservasi</th>
                                        <th width="10%" class="text-left">Jumlah Orang</th>
                                        <th width="15%" class="text-left">Tanggal Reservasi</th>
                                        <th width="10%" class="text-center">Status Permintaan</th>
                                        <th width="5%" class="text-center"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <?php
                    }else{
                        ?>

                        <div class="clearfix">
                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header">
                            Detail Permintaan ID Reservasi "<?= $_GET['id'] ?>"
                        </div>
                        <!-- div.table-responsive -->

                        <!-- div.dataTables_borderWrap -->
                        <div class="table table-responsive">
                            <table id="mytable2" class="display" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="">
                                        <th width="5%" class="text-center">No</th>
                                        <th width="10%" class="text-left">ID Menu</th>
                                        <th width="30%" class="text-left">ID Menu</th>
                                        <th width="10%" class="text-left">Jumlah Permintaan</th>
                                    </tr>
                                </thead>
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

<script>
    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_permintaan_menu_makanan.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_reservasi' } ,
                            { mData: 'jumlah_orang' } ,
                            { mData: 'tanggal_reservasi' },
                            { mData: 'status_permintaan' },
                            { mData: 'action' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,1,2] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

        <?php
        $get_id = isset($_GET['id']) ? $_GET['id'] : '';
        ?>

        $('#mytable2').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_permintaan_menu_makanan.php?id='.$get_id ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_menu' } ,
                            { mData: 'nama_menu' } ,
                            { mData: 'jumlah_pemesanan' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,1,2] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });
    });
</script>
