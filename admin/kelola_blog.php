<?php
// File: admin/kelola_blog.php - Kelola Artikel Blog
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Hitung total pesan & blog untuk sidebar
$total_pesan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_pesan"))['total'];
$total_blog = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_blog"))['total'];

// Hapus artikel
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tbl_blog WHERE id = $id");
    header("Location: kelola_blog.php?success=hapus");
    exit;
}

$success = isset($_GET['success']) ? $_GET['success'] : '';

// Ambil semua artikel
$result = mysqli_query($koneksi, "SELECT * FROM tbl_blog ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Blog - Admin SGN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { background-color: #212529; min-height: 100vh; }
        .sidebar .nav-link { color: #fff; padding: 12px 20px; border-radius: 8px; margin: 4px 0; transition: all 0.3s; }
        .sidebar .nav-link:hover { background-color: #0d6efd; transform: translateX(5px); }
        .sidebar .nav-link.active { background-color: #0d6efd; }
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
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                    <a class="nav-link" href="tambah_buku.php"><i class="fas fa-plus-circle me-2"></i> Tambah Buku</a>
                    <a class="nav-link" href="pesan.php">
                        <i class="fas fa-envelope me-2"></i> Pesan Masuk
                        <?php if ($total_pesan > 0): ?><span class="badge bg-danger ms-1"><?= $total_pesan ?></span><?php endif; ?>
                    </a>
                    <a class="nav-link active" href="kelola_blog.php">
                        <i class="fas fa-newspaper me-2"></i> Kelola Blog
                        <?php if ($total_blog > 0): ?><span class="badge bg-info ms-1"><?= $total_blog ?></span><?php endif; ?>
                    </a>
                    <a class="nav-link" href="../index.php" target="_blank"><i class="fas fa-globe me-2"></i> Lihat Website</a>
                    <hr class="text-white-50">
                    <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-4 py-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-newspaper"></i> Kelola Blog</h2>
                <a href="tambah_blog.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Artikel
                </a>
            </div>

            <?php if ($success == 'hapus'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Artikel berhasil dihapus!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($success == 'tambah'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Artikel berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($success == 'edit'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Artikel berhasil diupdate!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-list"></i> Daftar Artikel Blog
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Thumbnail</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0):
                                    $no = 1;
                                    while ($artikel = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if (!empty($artikel['thumbnail'])): ?>
                                                <img src="../images/blog/<?= htmlspecialchars($artikel['thumbnail']) ?>"
                                                     style="width:60px; height:45px; object-fit:cover; border-radius:6px;"
                                                     onerror="this.style.display='none'">
                                            <?php else: ?>
                                                <div style="width:60px; height:45px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:6px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="fas fa-image text-white small"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($artikel['judul']) ?></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($artikel['kategori'] ?? '-') ?></span></td>
                                        <td><?= htmlspecialchars($artikel['penulis']) ?></td>
                                        <td><?= date('d M Y', strtotime($artikel['created_at'])) ?></td>
                                        <td>
                                            <a href="edit_blog.php?id=<?= $artikel['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="kelola_blog.php?hapus=<?= $artikel['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus artikel ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile;
                                else: ?>
                                    <tr><td colspan="7" class="text-center py-4">Belum ada artikel blog</td></tr>
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