<?php
// buka koneksi
require_once '../config/connection.php';

// retrieve data post
$email       = mysqli_real_escape_string($conn, trim($_POST['email']));

if ($log_user == 'pgw') {
    // select data
    $sql = "SELECT email, nama_pengguna
            FROM pengguna
            WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // kirim Email
        $username   = $data['nama_pengguna'];
        $email      = $data['email'];
        $kata_sandi_baru = "vila".$username;
        $subject = "Lupa Kata Sandi";
        $message = "Silahkan login dengan menggunakan username : ".$username." dan kata sandi : ".$kata_sandi_baru;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: syarifah.fatwa@yahoo.co.id <noreply@syarifah.fatwa@yahoo.co.id>'."\r\n" . 'Reply-To: '.$username.' <'.$email.'>'."\r\n";
        $headers .= 'Cc: admin@vilaairnaturalresort.com' . "\r\n";

        $kirim = @mail($email,$subject,$message,$headers);

        if ($kirim) {

            $kata_sandi = md5($kata_sandi_baru);

            //reset kata sandi
            $sql = "UPDATE pengguna SET kata_sandi='$kata_sandi' WHERE email='$email'";
            if (mysqli_query($conn, $sql)) {
                $pesan_berhasil = "Kata sandi telah dikirim melalui email";
            }else{
                $pesan_gagal = "Gagal untuk mereset kata sandi";
            }

        }else{
            $pesan_gagal = "Gagal mengirim data ke email";
        }

    }else{
        // jika data tidak ditemukan
        $pesan_gagal = "User tidak terdaftar!";
    }

}else if ($log_user == 'supp') {
    // select data
    $sql = "SELECT email, nama_pengguna
            FROM supplier
            WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // kirim Email
        $username   = $data['nama_pengguna'];
        $email      = $data['email'];
        $kata_sandi_baru = "vila".$username;
        $subject = "Lupa Kata Sandi";
        $message = "Silahkan login dengan menggunakan nama pengguna : ".$username." dan kata sandi : ".$kata_sandi_baru;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: syarifah.fatwa@yahoo.co.id <noreply@syarifah.fatwa@yahoo.co.id>'."\r\n" . 'Reply-To: '.$username.' <'.$email.'>'."\r\n";
        $headers .= 'Cc: admin@vilaairnaturalresort.com' . "\r\n";

        $kirim = @mail($email,$subject,$message,$headers);

        if ($kirim) {

            $kata_sandi = md5($kata_sandi_baru);

            //reset kata sandi
            $sql = "UPDATE supplier SET kata_sandi='$kata_sandi' WHERE email='$email'";
            if (mysqli_query($conn, $sql)) {
                $pesan_berhasil = "Kata sandi telah dikirim melalui email";
            }else{
                $pesan_gagal = "Gagal untuk mereset kata sandi";
            }

        }else{
            $pesan_gagal = "Gagal mengirim data ke email";
        }

    }else{
        // jika data tidak ditemukan
        $pesan_gagal = "User tidak terdaftar!";
    }
}else{
    // select data
    $sql = "SELECT email, nama_pengguna
            FROM pelanggan
            WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // kirim Email
        $username   = $data['nama_pengguna'];
        $email      = $data['email'];
        $kata_sandi_baru = "vila".$username;
        $subject = "Lupa Kata Sandi";
        $message = "Silahkan login dengan menggunakan nama pengguna : ".$username." dan kata sandi : ".$kata_sandi_baru;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        // More headers
        $headers .= 'From: syarifah.fatwa@yahoo.co.id <noreply@syarifah.fatwa@yahoo.co.id>'."\r\n" . 'Reply-To: '.$username.' <'.$email.'>'."\r\n";
        $headers .= 'Cc: admin@vilaairnaturalresort.com' . "\r\n";

        $kirim = @mail($email,$subject,$message,$headers);

        if ($kirim) {

            $kata_sandi = md5($kata_sandi_baru);

            //reset kata sandi
            $sql = "UPDATE pelanggan SET kata_sandi='$kata_sandi' WHERE email='$email'";
            if (mysqli_query($conn, $sql)) {
                $pesan_berhasil = "Kata sandi telah dikirim melalui email";
            }else{
                $pesan_gagal = "Gagal untuk mereset kata sandi";
            }

        }else{
            $pesan_gagal = "Gagal mengirim data ke email";
        }

    }else{
        // jika data tidak ditemukan
        $pesan_gagal = "User tidak terdaftar!";
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
