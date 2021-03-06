<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Home</a>
                </li>

                <li class="active">User Profile</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="ace-settings-container" id="ace-settings-container">
                <!-- <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                    <i class="ace-icon fa fa-cog bigger-130"></i>
                </div> -->

                <div class="ace-settings-box clearfix" id="ace-settings-box">
                    <div class="pull-left width-50">
                        <div class="ace-settings-item">
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                    <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                    <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                    <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                            <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                            <label class="lbl" for="ace-settings-add-container">
                                Inside
                                <b>.container</b>
                            </label>
                        </div>
                    </div><!-- /.pull-left -->

                    <div class="pull-left width-50">
                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                            <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                            <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                        </div>

                        <div class="ace-settings-item">
                            <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                            <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                        </div>
                    </div><!-- /.pull-left -->
                </div><!-- /.ace-settings-box -->
            </div><!-- /.ace-settings-container -->

            <div class="page-header">
                <h1>
                    User Profile
                    <!--<small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        3 styles with inline editable feature
                    </small>-->
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="clearfix">

                    <div class="hr dotted"></div>

                    <div>
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-3 center">
                                <div>
                                    <span class="profile-picture">
                                        <img id="avatar" class="editable img-responsive" alt="Vila Resort" src="../assets/images/<?= $_SESSION['foto_profil'] ?>" />
                                        <!-- <a href=""class="btn btn-xs" title="Ubah Foto Profil" data-toggle="modal" data-target="#ubahGambar" onclick="return ubahGambar('<?= $_SESSION['id_karyawan'] ?>','<?= $_SESSION['foto_profil'] ?>')"><i class="fa fa-picture-o"></i> Ubah</a> -->
                                    </span>

                                    <div class="space-4"></div>

                                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                            &nbsp;
                                            <span class="white"><?= $_SESSION['nama_karyawan'] ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-9">

                                <div class="space-12"></div>

                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Nama </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="nama_lengkap"></span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Email </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="email"></span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Status </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="status"></span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Nama Pengguna </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="nama_pengguna"></span>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> Ubah Kata Sandi </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="about"></span></span>
                                            <form method="post" action="">
                                                <input type="password" name="kata_sandi_lama" value="" placeholder="Kata Sandi Lama" require>
                                                <input type="password" name="kata_sandi_baru" value="" placeholder="Kata Sandi Baru" require>
                                                <input type="submit" class="btn btn-sm btn-primary" name="" value="Update">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<!-- Modal Ubah Gambar -->
<div class="modal fade" id="ubahGambar" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-picture-o"></i> Ubah Foto Profil</h4>
            </div>
            <form method="post" action="../action/foto_profil.php" class="myform">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id_karyawan" readonly>
                        <input type="hidden" name="nama_file" value="" class="form-control">
                        <label for="">Pilih Foto</label>
                        <input type="file" name="foto_profil" value="" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function ubahGambar(id_karyawan, foto_profil){
        $('.modal-body input[name=id_karyawan]').val(id_karyawan);
        $('.modal-body input[name=nama_file]').val(foto_profil);
    }

    $(document).ready(function(){

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
                    $("#ubahGambar").modal('hide');
            },
                error: function(jqXHR, textStatus, errorThrown){
            }
        });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });

        $.ajax({ type: "GET",
            url: "../action/tampilkan_data_pengguna.php?id=<?= $_SESSION['id_karyawan'] ?>",
            async: false,
            datatype: "json",
            success : function(data)
            {
                var jsonData = JSON.parse(data);
                for(var i = 0; i < jsonData.data.length; i++)
                {
                    var result = jsonData.data[i];
                    var nama_lengkap = result.nama_karyawan;
                    var alamat = result.alamat;
                    var no_telp = result.no_telp;
                    var email = result.email;
                    var status = result.divisi;
                    var nama_pengguna = result.nama_pengguna;
                }

                $('#nama_lengkap').html(nama_lengkap);
                $('#alamat').html(alamat);
                $('#no_telp').html(no_telp);
                $('#email').html(email);
                $('#status').html(status);
                $('#nama_pengguna').html(nama_pengguna);
            }
        });
    });
</script>
