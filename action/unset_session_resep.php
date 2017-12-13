<?php
session_start();

// unset session
for ($i=0; $i <= count($_SESSION['id_bahan_makanan'])+1; $i++) { 
    unset($_SESSION['id_bahan_makanan'][$i]);
}
unset($_SESSION['id_menu']);
header('location:../admin/index.php?menu=resep');
?>