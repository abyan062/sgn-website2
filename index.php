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
        <h1 class="mb-3">Wujudkan Karya Anda Bersama Kami</h1>
        <p class="lead mb-4">CV. Smart Global Nusantara mendampingi penulis dari naskah hingga terbit<br>dengan layanan penerbitan ber-ISBN, teknologi modern, dan distribusi global.</p>
        <a href="kontak.php" class="btn btn-light btn-lg px-4">
            <i class="fas fa-envelope me-2"></i>Hubungi Kami
        </a>
    </div>
</section>

<!-- Section Tentang SGN -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="display-5 fw-bold mb-3">CV.SMART GLOBAL NUSANTARA</h2>
            <div class="divider mx-auto mb-4" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
            <p class="text-muted mx-auto" style="max-width: 750px;">
                Smart Global Nusantara (SGN) adalah perusahaan penerbitan, publikasi, distribusi, dan penjualan buku yang berbasis di Surabaya. Berdiri sejak tahun 2023 dan merupakan anggota IKAPI. Kami hadir untuk menjawab kebutuhan era digital dalam dunia literasi, pendidikan, dan kepenulisan dengan dukungan teknologi dan tenaga ahli di bidangnya.
            </p>
        </div>

        <div class="row g-4 mt-2">
            <!-- Visi -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="fw-bold">Visi Kami</h4>
                    <p class="text-muted">Menjadi pionir dalam transformasi digital literasi dan publikasi di Indonesia yang inklusif dan berdaya saing global.</p>
                </div>
            </div>
            <!-- Misi -->
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="fw-bold">Misi Kami</h4>
                    <ul class="text-muted ps-3">
                        <li class="mb-2">Menyediakan pelatihan dan layanan literasi berbasis teknologi terkini.</li>
                        <li class="mb-2">Mendorong masyarakat untuk menulis, menerbitkan, dan berbagi ilmu melalui platform digital.</li>
                        <li class="mb-2">Menjadi mitra strategis institusi pendidikan, komunitas, dan individu dalam proyek penulisan dan publikasi.</li>
                        <li>Mengembangkan ekosistem edukatif yang adaptif terhadap kebutuhan zaman.</li>
                    </ul>
                </div>
            </div>
        </div>
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
            <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
        </div>
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-certificate"></i>
                </div>
                <h5 class="fw-bold">Ber-ISBN Resmi</h5>
                <p class="text-muted">Setiap buku diterbitkan dengan ISBN resmi dan terdaftar di Perpusnas</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-globe"></i>
                </div>
                <h5 class="fw-bold">Distribusi Global</h5>
                <p class="text-muted">Buku Anda dapat diakses oleh pembaca di seluruh dunia</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h5 class="fw-bold">Teknologi Modern</h5>
                <p class="text-muted">Proses penerbitan didukung teknologi digital terkini</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="fw-bold">Anggota IKAPI</h5>
                <p class="text-muted">Terdaftar resmi sebagai anggota Ikatan Penerbit Indonesia</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>