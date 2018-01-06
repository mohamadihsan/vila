<?php
// buka koneksi
require_once '../config/connection.php';
session_start();

$id_karyawan      = mysqli_escape_string($conn, trim($_POST['id_karyawan']));
$nama_file        = mysqli_escape_string($conn, trim($_POST['nama_file']));
$imgFile = $_FILES['foto_profil']['name'];
$tmp_dir = $_FILES['foto_profil']['tmp_name'];
$imgSize = $_FILES['foto_profil']['size'];

if($_FILES['foto_profil']['name']==''){
    $valid = false;
}else{
    $valid = true;
}

if($valid==true){

    $upload_dir = '../assets/images/'; // upload directory

    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'rar', 'zip'); // valid extensions

    // rename uploading image
    $file_transfer = $id_karyawan.".".$imgExt;

    // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){
        // Check file size '25MB'
        if($imgSize < 25000000)    {
            if(!move_uploaded_file($tmp_dir,$upload_dir.$file_transfer)){
                echo "gagal upload";
            }

            // hapus gambar sebelumnya
            if (file_exists($upload_dir ."". $file_transfer) AND $file_transfer!='user2.png')
    		{
    		    unlink($upload_dir ."". $file_transfer);
    		}
        }else{
            $pesan_gagal = "Maaf, ukuran file terlalu besar.";
        }
    }else{
        $pesan_gagal = "Maaf, hanya JPG, JPEG, PNG yang diperbolehkan.";
    }

    // if no error occured, continue ....
    if(!isset($pesan_gagal)){

        $sql = "UPDATE pengguna
                SET foto= '$file_transfer'
                WHERE id_karyawan = '$id_karyawan'
        ";
        if (mysqli_query($conn, $sql)) {
            $pesan_berhasil = "Foto profil telah diperbaharui";
            $_SESSION['foto_profil'] = $file_transfer;
        } else {
            $pesan_gagal = "Foto profil gagal diperbaharui";
        }
    }
}

if (isset($pesan_berhasil)) {
    ?>
    <script type="text/javascript">
        $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Sukses!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_berhasil ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/berhasil.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
            });
        });
    </script>
    <?php
}else if(isset($pesan_gagal)){
    ?>
    <script type="text/javascript">
	    $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Gagal!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_gagal ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/gagal.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
	        });
        });
	</script>
    <?php
}

//header('location:../admin/index.php?menu=profil');
?>
