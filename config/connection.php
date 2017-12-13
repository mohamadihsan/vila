<?php
$server         = '127.0.0.1';
$username       = 'root';
$password       = '0000';
$nama_database  = 'vila';

$conn = mysqli_connect($server, $username, $password, $nama_database);
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}
?>
