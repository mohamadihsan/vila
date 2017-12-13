<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

if(mysqli_escape_string($conn, trim($_POST['status']))=='0'){
    // buat session
    for ($i=0; $i < count($_POST['id_bahan_makanan']); $i++) { 
        $_SESSION['id_bahan_makanan'][$i] = $_POST['id_bahan_makanan'][$i];
    }
    
    $_SESSION['id_menu'] = $_POST['id_menu'];
    
}else if(mysqli_escape_string($conn, trim($_POST['status']))=='1'){
    

    // simpan data
    for ($i=0; $i < count($_POST['id_bahan_makanan']); $i++) { 
        $id_menu      = $_POST['id_menu'];
        $id_bahan_makanan[$i]  = $_POST['id_bahan_makanan'][$i];
        $takaran[$i]        = $_POST['takaran'][$i];
        
        $sql = "INSERT INTO resep (id_menu, id_bahan_makanan, takaran)
                VALUES ('$id_menu', '$id_bahan_makanan[$i]', '$takaran[$i]')";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil disimpan";
        }else{
            $pesan_gagal = "Data gagal disimpan";
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
?>