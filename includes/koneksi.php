<?php
// File: includes/koneksi.php
// Fungsi: Menghubungkan PHP dengan database MySQL

$host = "sql202.infinityfree.com";
$username = "if0_41862876";
$password = "bg4gpdBcwv0Jk";
$database = "if0_41862876_db_sgn2";

// Bikin koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// Set encoding biar huruf-huruf Indonesia gak rusak
mysqli_set_charset($koneksi, "utf8");

// Fungsi helper untuk keamanan (escape string)
function escape($data) {
    global $koneksi;
    return mysqli_real_escape_string($koneksi, $data);
}
?>