<?php
// File: admin/dashboard.php - Dashboard Admin
session_start();
include '../includes/koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Hitung statistik
$query_buku = "SELECT COUNT(*) as total FROM tbl_buku";
$result_buku = mysqli_query($koneksi, $query_buku);
$total_buku = mysqli_fetch_assoc($result_buku)['total'];

$query_kategori = "SELECT COUNT(*) as total FROM tbl_kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);
$total_kategori = mysqli_fetch_assoc($result_kategori)['total'];

$query_admin = "SELECT COUNT(*) as total FROM tbl_admin";
$result_admin = mysqli_query($koneksi, $query_admin);
$total_admin = mysqli_fetch_assoc($result_admin)['total'];

// ✅ TAMBAHAN: Hitung total pesan
$query_pesan = "SELECT COUNT(*) as total FROM tbl_pesan";
$result_pesan = mysqli_query($koneksi, $query_pesan);
$total_pesan = mysqli_fetch_assoc($result_pesan)['total'];

// Ambil semua buku
$buku_query = "SELECT b.*, k.nama_kategori 
               FROM tbl_buku b 
               LEFT JOIN tbl_kategori k ON b.id_kategori = k.id 
               ORDER BY b.created_at DESC";
$buku_result = mysqli_query($koneksi, $buku_query);

// ✅ TAMBAHAN: Ambil 5 pesan terbaru
$pesan_terbaru = mysqli_query($koneksi, 
    "SELECT * FROM tbl_pesan ORDER BY created_at DESC LIMIT 5"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SGN Publisher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background-color: #212529;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #0d6efd;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
        }
        .stat-card {
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        .stok-badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 20px;
        }
        /* Kotak pesan */
        .pesan-item {
            border-left: 3px solid #0d6efd;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            margin-bottom: 10px;
            transition: background 0.2s;
        }
        .pesan-item:hover {
            background: #e9f0ff;
        }
        .avatar-circle {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-book-open fa-3x text-white mb-2"></i>
                        <h5 class="text-white">Admin SGN</h5>
                        <small class="text-white-50"><?= $_SESSION['admin_nama'] ?></small>
                    </div>
                    <hr class="text-white-50">
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="tambah_buku.php">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Buku
                        </a>
                        <!-- ✅ TAMBAHAN: Menu Pesan -->
                        <a class="nav-link" href="pesan.php">
                            <i class="fas fa-envelope me-2"></i> Pesan Masuk
                            <?php if ($total_pesan > 0): ?>
                                <span class="badge bg-danger ms-1"><?= $total_pesan ?></span>
                            <?php endif; ?>
                        </a>
                        <a class="nav-link" href="../index.php" target="_blank">
                            <i class="fas fa-globe me-2"></i> Lihat Website
                        </a>
                        <hr class="text-white-50">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </h2>
                    <div>
                        <a href="../index.php" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-globe"></i> Lihat Website
                        </a>
                        <span class="badge bg-secondary">
                            <i class="fas fa-user"></i> <?= $_SESSION['admin_nama'] ?>
                        </span>
                    </div>
                </div>
                
                <!-- Stat Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Buku</h6>
                                        <h2 class="mb-0"><?= $total_buku ?></h2>
                                    </div>
                                    <i class="fas fa-book fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Kategori</h6>
                                        <h2 class="mb-0"><?= $total_kategori ?></h2>
                                    </div>
                                    <i class="fas fa-tags fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Total Admin</h6>
                                        <h2 class="mb-0"><?= $total_admin ?></h2>
                                    </div>
                                    <i class="fas fa-users fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ✅ TAMBAHAN: Stat card pesan -->
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Pesan Masuk</h6>
                                        <h2 class="mb-0"><?= $total_pesan ?></h2>
                                    </div>
                                    <i class="fas fa-envelope fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ✅ TAMBAHAN: Pesan Terbaru -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope me-2"></i>Pesan Terbaru</span>
                        <a href="pesan.php" class="btn btn-sm btn-light">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if ($pesan_terbaru && mysqli_num_rows($pesan_terbaru) > 0): ?>
                            <?php while ($p = mysqli_fetch_assoc($pesan_terbaru)): ?>
                                <div class="pesan-item d-flex gap-3 align-items-start">
                                    <div class="avatar-circle">
                                        <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-semibold"><?= htmlspecialchars($p['nama']) ?></span>
                                            <small class="text-muted">
                                                <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                            </small>
                                        </div>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($p['email']) ?>
                                        </small>
                                        <?php if (!empty($p['subjek'])): ?>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-tag me-1"></i><?= htmlspecialchars($p['subjek']) ?>
                                            </small>
                                        <?php endif; ?>
                                        <p class="mb-0 mt-1 small text-secondary">
                                            <?= htmlspecialchars(substr($p['pesan'], 0, 100)) ?>
                                            <?= strlen($p['pesan']) > 100 ? '...' : '' ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada pesan masuk
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Tombol Tambah -->
                <div class="mb-3">
                    <a href="tambah_buku.php" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Buku Baru
                    </a>
                </div>
                
                <!-- Tabel Buku -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-list"></i> Daftar Buku
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Cover</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($buku_result) > 0): ?>
                                        <?php $no = 1; while ($buku = mysqli_fetch_assoc($buku_result)): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <img src="../images/covers/<?= htmlspecialchars($buku['cover'] ?? '') ?>" 
                                                         style="width: 50px; height: 60px; object-fit: cover;" 
                                                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'60\'%3E%3Crect width=\'50\' height=\'60\' fill=\'%23667eea\'/%3E%3C/svg%3E'">
                                                </td>
                                                <td><?= htmlspecialchars($buku['judul']) ?></td>
                                                <td><?= htmlspecialchars($buku['penulis']) ?></td>
                                                <td><?= htmlspecialchars($buku['nama_kategori'] ?? '-') ?></td>
                                                <td>Rp <?= number_format($buku['harga'], 0, ',', '.') ?></td>
                                                <td>
                                                    <?php 
                                                    $stok = $buku['stok'] ?? 0;
                                                    if ($stok > 0): ?>
                                                        <span class="badge bg-success"><?= $stok ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Habis</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="edit_buku.php?id=<?= $buku['id'] ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="hapus_buku.php?id=<?= $buku['id'] ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data buku</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>