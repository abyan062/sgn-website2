<?php
// File: includes/header.php
// Bagian atas semua halaman
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV.Smart Global Nusantara – Wujudkan Karya, Sebarkan Inspirasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <!-- Logo + Nama Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="https://smartglobalnusantara.co.id/wp-content/uploads/2025/12/LOGO-WEB-PNG-392x54.png"
                     alt="CV.Smart Global Nusantara"
                     style="height: 40px; width: auto; object-fit: contain;">
            </a>

            <!-- Toggler untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Menu -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Profile</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="layanan.php">Layanan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="paket.php">Paket Penerbitan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="katalog.php">Bookstore</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Contact</a>
                    </li>

                    <!-- ========== NAVBAR LOGIN (TAMBAHAN) ========== -->
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['admin_nama']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="admin/dashboard.php">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="admin/tambah_buku.php">
                                    <i class="fas fa-plus-circle"></i> Tambah Buku
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="admin/logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link btn btn-outline-light px-3" href="admin/login.php">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- ========== END NAVBAR LOGIN ========== -->

                </ul>
            </div>
        </div>
    </nav>