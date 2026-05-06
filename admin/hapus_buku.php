<?php
// File: admin/hapus_buku.php - Proses Hapus Buku
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Ambil nama cover untuk dihapus
    $query = "SELECT cover FROM tbl_buku WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $buku = mysqli_fetch_assoc($result);
    
    if ($buku && $buku['cover']) {
        $cover_path = "../images/covers/" . $buku['cover'];
        if (file_exists($cover_path)) {
            unlink($cover_path);
        }
    }
    
    $query = "DELETE FROM tbl_buku WHERE id = $id";
    mysqli_query($koneksi, $query);
}

header("Location: dashboard.php");
exit;
?>