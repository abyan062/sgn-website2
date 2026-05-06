<?php
// File: admin/pesan.php - Halaman Kelola Pesan Masuk
include '../includes/koneksi.php';

// Proteksi halaman - wajib login
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header('Location: ../login.php');
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

$current_page = 'pesan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk - Admin SGN Publisher</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="background: var(--sgn-light);">

<!-- SIDEBAR -->
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-icon" style="width:38px;height:38px;font-size:1rem;">
                <i class="fas fa-book-open"></i>
            </div>
            <div>
                <div class="logo-main" style="font-size:1.1rem;">SGN</div>
                <div class="logo-sub" style="color:rgba(255,255,255,0.4);">Admin Panel</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-section">Main</div>
        <a href="../dashboard.php">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="menu-section">Kelola</div>
        <a href="buku.php">
            <i class="fas fa-book"></i> Kelola Buku
        </a>
        <a href="kategori.php">
            <i class="fas fa-tags"></i> Kelola Kategori
        </a>
        <a href="pesan.php" class="active">
            <i class="fas fa-envelope"></i> Pesan Masuk
            <?php if ($total > 0): ?>
                <span class="badge bg-danger ms-auto"><?= $total ?></span>
            <?php endif; ?>
        </a>

        <div class="menu-section">Akun</div>
        <a href="../index.php" target="_blank">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
        <a href="../logout.php" style="color: #fc8181 !important;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>

<!-- MAIN CONTENT -->
<div class="dashboard-main">

    <!-- TOP BAR -->
    <div class="dashboard-topbar">
        <div>
            <h5 class="mb-0" style="font-family: var(--font-display); color: var(--sgn-dark);">
                <i class="fas fa-envelope me-2 text-warning"></i>Pesan Masuk
            </h5>
            <small class="text-muted">Total <?= $total ?> pesan diterima</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if ($total > 0): ?>
                <form method="POST" onsubmit="return confirm('Yakin hapus SEMUA pesan? Tidak bisa dikembalikan!')">
                    <button type="submit" name="hapus_semua" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash-alt me-1"></i>Hapus Semua
                    </button>
                </form>
            <?php endif; ?>
            <a href="../logout.php" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>

    <div class="dashboard-content">

        <!-- NOTIFIKASI -->
        <?php if (isset($_GET['notif'])): ?>
            <?php if ($_GET['notif'] == 'hapus'): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-check-circle"></i>
                    <span>Pesan berhasil dihapus.</span>
                </div>
            <?php elseif ($_GET['notif'] == 'hapus_semua'): ?>
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-check-circle"></i>
                    <span>Semua pesan berhasil dihapus.</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- ISI PESAN -->
        <?php if ($total > 0): ?>

            <!-- TAMPILAN CARD (mobile friendly) -->
            <div class="row g-4 d-md-none">
                <?php
                mysqli_data_seek($pesan_result, 0);
                while ($p = mysqli_fetch_assoc($pesan_result)):
                ?>
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                         style="width:44px;height:44px;background:var(--sgn-accent);color:var(--sgn-primary);font-size:1.1rem;flex-shrink:0;">
                                        <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color:var(--sgn-dark);">
                                            <?= htmlspecialchars($p['nama']) ?>
                                        </div>
                                        <div class="text-muted small"><?= htmlspecialchars($p['email']) ?></div>
                                    </div>
                                </div>
                                <small class="text-muted"><?= date('d M Y', strtotime($p['created_at'])) ?></small>
                            </div>

                            <?php if (!empty($p['subjek'])): ?>
                                <div class="fw-semibold mb-1" style="font-size:0.9rem; color:var(--sgn-dark);">
                                    <i class="fas fa-tag me-1 text-muted"></i><?= htmlspecialchars($p['subjek']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="text-muted mb-3" style="font-size:0.88rem; line-height:1.6;
                                 background:var(--sgn-light); padding:12px; border-radius:8px;
                                 border-left:3px solid var(--sgn-primary);">
                                <?= nl2br(htmlspecialchars($p['pesan'])) ?>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="mailto:<?= htmlspecialchars($p['email']) ?>?subject=Re: <?= urlencode($p['subjek'] ?? 'Pesan Anda') ?>"
                                   class="btn btn-sm btn-sgn-primary">
                                    <i class="fas fa-reply me-1"></i>Balas
                                </a>
                                <a href="?hapus=<?= $p['id'] ?>"
                                   onclick="return confirm('Hapus pesan dari <?= htmlspecialchars($p['nama']) ?>?')"
                                   class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- TAMPILAN TABEL (desktop) -->
            <div class="dashboard-card d-none d-md-block">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-inbox me-2"></i>Daftar Pesan</span>
                    <span class="badge" style="background:var(--sgn-primary);"><?= $total ?> pesan</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sgn mb-0">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Pengirim</th>
                                <th>Email</th>
                                <th>Subjek</th>
                                <th>Pesan</th>
                                <th>Waktu</th>
                                <th style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            mysqli_data_seek($pesan_result, 0);
                            $no = 1;
                            while ($p = mysqli_fetch_assoc($pesan_result)):
                            ?>
                            <tr>
                                <td class="text-muted"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                             style="width:34px;height:34px;background:var(--sgn-accent);
                                                    color:var(--sgn-primary);font-size:0.85rem;flex-shrink:0;">
                                            <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                        </div>
                                        <span class="fw-semibold small"><?= htmlspecialchars($p['nama']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($p['email']) ?>" 
                                       class="text-decoration-none text-muted small">
                                        <?= htmlspecialchars($p['email']) ?>
                                    </a>
                                </td>
                                <td class="small">
                                    <?= !empty($p['subjek']) ? htmlspecialchars($p['subjek']) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <!-- Pesan bisa diklik untuk lihat full -->
                                    <span class="small text-muted" 
                                          style="cursor:pointer;"
                                          data-bs-toggle="modal" 
                                          data-bs-target="#modalPesan<?= $p['id'] ?>">
                                        <?= htmlspecialchars(substr($p['pesan'], 0, 60)) ?>
                                        <?= strlen($p['pesan']) > 60 ? '...' : '' ?>
                                        <?php if (strlen($p['pesan']) > 60): ?>
                                            <span class="text-primary">[lihat]</span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?= date('d M Y', strtotime($p['created_at'])) ?><br>
                                    <span style="font-size:0.75rem;"><?= date('H:i', strtotime($p['created_at'])) ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="mailto:<?= htmlspecialchars($p['email']) ?>?subject=Re: <?= urlencode($p['subjek'] ?? 'Pesan Anda') ?>"
                                           class="btn btn-xs btn-sgn-primary"
                                           style="padding: 4px 10px; font-size: 0.78rem;"
                                           title="Balas via Email">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <a href="?hapus=<?= $p['id'] ?>"
                                           onclick="return confirm('Hapus pesan dari <?= htmlspecialchars(addslashes($p['nama'])) ?>?')"
                                           class="btn btn-xs btn-outline-danger"
                                           style="padding: 4px 10px; font-size: 0.78rem;"
                                           title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal lihat pesan full -->
                            <div class="modal fade" id="modalPesan<?= $p['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: var(--radius); border: none;">
                                        <div class="modal-header" style="background: var(--sgn-dark); color: white; border-radius: var(--radius) var(--radius) 0 0;">
                                            <h6 class="modal-title">
                                                <i class="fas fa-envelope me-2"></i>
                                                Pesan dari <?= htmlspecialchars($p['nama']) ?>
                                            </h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <small class="text-muted fw-semibold">PENGIRIM</small>
                                                <div class="mt-1"><?= htmlspecialchars($p['nama']) ?></div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted fw-semibold">EMAIL</small>
                                                <div class="mt-1">
                                                    <a href="mailto:<?= htmlspecialchars($p['email']) ?>" class="text-decoration-none">
                                                        <?= htmlspecialchars($p['email']) ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php if (!empty($p['subjek'])): ?>
                                            <div class="mb-3">
                                                <small class="text-muted fw-semibold">SUBJEK</small>
                                                <div class="mt-1"><?= htmlspecialchars($p['subjek']) ?></div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="mb-3">
                                                <small class="text-muted fw-semibold">PESAN</small>
                                                <div class="mt-2 p-3 rounded" 
                                                     style="background:var(--sgn-light); border-left:3px solid var(--sgn-primary); line-height:1.7;">
                                                    <?= nl2br(htmlspecialchars($p['pesan'])) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Diterima: <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="mailto:<?= htmlspecialchars($p['email']) ?>?subject=Re: <?= urlencode($p['subjek'] ?? 'Pesan Anda') ?>"
                                               class="btn btn-sgn-primary btn-sm">
                                                <i class="fas fa-reply me-1"></i>Balas via Email
                                            </a>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- Kosong -->
            <div class="dashboard-card">
                <div class="p-5 text-center">
                    <i class="fas fa-inbox fa-4x mb-4" style="color: var(--sgn-border);"></i>
                    <h5 style="color: var(--sgn-muted);">Belum Ada Pesan Masuk</h5>
                    <p class="text-muted small">Pesan dari halaman kontak akan muncul di sini.</p>
                    <a href="../kontak.php" target="_blank" class="btn btn-sgn-primary btn-sm mt-2">
                        <i class="fas fa-eye me-1"></i>Lihat Halaman Kontak
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto hide alert setelah 3 detik
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 500);
        });
    }, 3000);
</script>
</body>
</html>