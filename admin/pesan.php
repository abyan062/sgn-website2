<?php
// File: admin/pesan.php - Halaman Kelola Pesan Masuk
session_start();
include '../includes/koneksi.php';

// Proteksi halaman - wajib login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Hapus pesan
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tbl_pesan WHERE id = $id");
    header('Location: pesan.php?notif=hapus');
    exit;
}

// Hapus semua pesan
if (isset($_POST['hapus_semua'])) {
    mysqli_query($koneksi, "TRUNCATE TABLE tbl_pesan");
    header('Location: pesan.php?notif=hapus_semua');
    exit;
}

// Ambil semua pesan, terbaru dulu
$pesan_result = mysqli_query($koneksi, "SELECT * FROM tbl_pesan ORDER BY created_at DESC");
$total = mysqli_num_rows($pesan_result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk - Admin SGN Publisher</title>
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
        .avatar-circle {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="tambah_buku.php">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Buku
                        </a>
                        <a class="nav-link active" href="pesan.php">
                            <i class="fas fa-envelope me-2"></i> Pesan Masuk
                            <?php if ($total > 0): ?>
                                <span class="badge bg-danger ms-1"><?= $total ?></span>
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

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-envelope"></i> Pesan Masuk</h2>
                    <div class="d-flex gap-2 align-items-center">
                        <?php if ($total > 0): ?>
                            <form method="POST" onsubmit="return confirm('Yakin hapus SEMUA pesan?')">
                                <button type="submit" name="hapus_semua" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                                </button>
                            </form>
                        <?php endif; ?>
                        <span class="badge bg-secondary">Total: <?= $total ?> pesan</span>
                    </div>
                </div>

                <!-- Notifikasi -->
                <?php if (isset($_GET['notif'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $_GET['notif'] == 'hapus' ? 'Pesan berhasil dihapus.' : 'Semua pesan berhasil dihapus.' ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Tabel Pesan -->
                <?php if ($total > 0): ?>
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <i class="fas fa-inbox me-2"></i>Daftar Pesan
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Pengirim</th>
                                            <th>Email</th>
                                            <th>Subjek</th>
                                            <th>Pesan</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; while ($p = mysqli_fetch_assoc($pesan_result)): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-circle">
                                                        <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                                    </div>
                                                    <span class="fw-semibold small"><?= htmlspecialchars($p['nama']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= htmlspecialchars($p['email']) ?>" class="text-decoration-none small">
                                                    <?= htmlspecialchars($p['email']) ?>
                                                </a>
                                            </td>
                                            <td class="small">
                                                <?= !empty($p['subjek']) ? htmlspecialchars($p['subjek']) : '<span class="text-muted">-</span>' ?>
                                            </td>
                                            <td>
                                                <span class="small text-muted" style="cursor:pointer;"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#modalPesan<?= $p['id'] ?>">
                                                    <?= htmlspecialchars(substr($p['pesan'], 0, 60)) ?>
                                                    <?php if (strlen($p['pesan']) > 60): ?>
                                                        ... <span class="text-primary">[lihat]</span>
                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                            <td class="small text-muted">
                                                <?= date('d M Y', strtotime($p['created_at'])) ?><br>
                                                <?= date('H:i', strtotime($p['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="mailto:<?= htmlspecialchars($p['email']) ?>?subject=Re: <?= urlencode($p['subjek'] ?? '') ?>"
                                                       class="btn btn-sm btn-primary" title="Balas">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <a href="?hapus=<?= $p['id'] ?>"
                                                       onclick="return confirm('Hapus pesan dari <?= htmlspecialchars(addslashes($p['nama'])) ?>?')"
                                                       class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal lihat pesan -->
                                        <div class="modal fade" id="modalPesan<?= $p['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark text-white">
                                                        <h6 class="modal-title">
                                                            <i class="fas fa-envelope me-2"></i>
                                                            Pesan dari <?= htmlspecialchars($p['nama']) ?>
                                                        </h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Nama:</strong> <?= htmlspecialchars($p['nama']) ?></p>
                                                        <p><strong>Email:</strong> <?= htmlspecialchars($p['email']) ?></p>
                                                        <?php if (!empty($p['subjek'])): ?>
                                                            <p><strong>Subjek:</strong> <?= htmlspecialchars($p['subjek']) ?></p>
                                                        <?php endif; ?>
                                                        <p><strong>Pesan:</strong></p>
                                                        <div class="p-3 bg-light rounded border-start border-primary border-3">
                                                            <?= nl2br(htmlspecialchars($p['pesan'])) ?>
                                                        </div>
                                                        <small class="text-muted mt-2 d-block">
                                                            <i class="fas fa-clock me-1"></i>
                                                            <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="mailto:<?= htmlspecialchars($p['email']) ?>?subject=Re: <?= urlencode($p['subjek'] ?? '') ?>"
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-reply me-1"></i>Balas via Email
                                                        </a>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Pesan Masuk</h5>
                            <p class="text-muted small">Pesan dari halaman kontak akan muncul di sini.</p>
                            <a href="../kontak.php" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Halaman Kontak
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>