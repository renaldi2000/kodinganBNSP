<?php
session_start();

if(empty($_SESSION['username'])){
    header("Location: index.php");
}
//Koneksi Database
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_pelatihan";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));