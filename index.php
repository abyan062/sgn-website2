<?php
// File: index.php - Halaman Beranda
include 'includes/koneksi.php';
include 'includes/header.php';

// Ambil 6 buku terbaru dari database
$query = "SELECT b.*, k.nama_kategori 
          FROM tbl_buku b 
          LEFT JOIN tbl_kategori k ON b.id_kategori = k.id 
          ORDER BY b.created_at DESC LIMIT 6";
$result = mysqli_query($koneksi, $query);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center text-white">
        <h1 class="mb-3">Smart Global Nusantara Publisher</h1>
        <p class="lead mb-4">Pelopor penerbitan buku berkualitas di Indonesia<br>Mencerdaskan bangsa melalui literasi berkualitas</p>
        <a href="katalog.php" class="btn btn-light btn-lg px-4">
            <i class="fas fa-book-open me-2"></i>Lihat Katalog Buku
        </a>
        <a href="kontak.php" class="btn btn-outline-light btn-lg px-4 ms-2">
            <i class="fas fa-envelope me-2"></i>Hubungi Kami
        </a>
    </div>
</section>

<!-- Section Buku Terbaru -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 mb-3">Buku Terbaru</h2>
            <p class="text-muted">Koleksi buku terbaru dari penerbit SGN</p>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
        </div>
        
        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($buku = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card book-card h-100">
                            <img src="images/covers/<?= htmlspecialchars($buku['cover'] ?? '') ?>" 
                                 class="card-img-top" 
                                 alt="Cover <?= htmlspecialchars($buku['judul']) ?>">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?= htmlspecialchars($buku['nama_kategori'] ?? 'Umum') ?></span>
                                <h5 class="card-title"><?= htmlspecialchars($buku['judul']) ?></h5>
                                <p class="card-text text-muted">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($buku['penulis']) ?>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted"><?= substr(htmlspecialchars($buku['sinopsis'] ?? ''), 0, 100) ?>...</small>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary">Rp <?= number_format($buku['harga'], 0, ',', '.') ?></span>
                                    <a href="detail.php?slug=<?= htmlspecialchars($buku['slug']) ?>" class="btn btn-primary">
                                        Detail <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> Belum ada buku tersedia.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="katalog.php" class="btn btn-outline-primary btn-lg">
                Lihat Semua Buku <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Section Keunggulan -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 mb-3">Mengapa Memilih SGN?</h2>
            <p class="text-muted">Kelebihan dan keunggulan penerbit kami</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-medal"></i>
                </div>
                <h4>Berkualitas</h4>
                <p class="text-muted">Setiap buku melalui kurasi ketat untuk menjamin kualitas terbaik</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-truck"></i>
                </div>
                <h4>Pengiriman Cepat</h4>
                <p class="text-muted">Pengiriman ke seluruh Indonesia dengan kemasan aman</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-headset"></i>
                </div>
                <h4>Dukungan 24/7</h4>
                <p class="text-muted">Tim customer service siap membantu Anda</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>