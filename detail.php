<?php
// File: detail.php - Halaman Detail Buku
include 'includes/koneksi.php';
include 'includes/header.php';

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($koneksi, $_GET['slug']) : '';

// Ambil data buku berdasarkan slug
$query = "SELECT b.*, k.nama_kategori, k.slug as kategori_slug 
          FROM tbl_buku b 
          LEFT JOIN tbl_kategori k ON b.id_kategori = k.id 
          WHERE b.slug = '$slug'";
$result = mysqli_query($koneksi, $query);
$buku = mysqli_fetch_assoc($result);

if (!$buku) {
    echo '<div class="container py-5"><div class="alert alert-danger">Buku tidak ditemukan!</div></div>';
    include 'includes/footer.php';
    exit;
}

// Ambil nilai stok (default 0 jika tidak ada)
$stok = isset($buku['stok']) ? $buku['stok'] : 0;
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="katalog.php">Katalog</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($buku['judul']) ?></li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 mb-4">
            <img src="images/covers/<?= htmlspecialchars($buku['cover'] ?? '') ?>" 
                 class="book-detail-cover img-fluid rounded shadow"
                 alt="Cover <?= htmlspecialchars($buku['judul']) ?>"
                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect width=\'300\' height=\'400\' fill=\'%23667eea\'/%3E%3Ctext x=\'150\' y=\'200\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'16\'%3ECover%20Tidak%20Tersedia%3C/text%3E%3C/svg%3E'">
        </div>
        
        <div class="col-lg-8">
            <div class="book-info">
                <h1 class="mb-3"><?= htmlspecialchars($buku['judul']) ?></h1>
                
                <div class="mb-3">
                    <?php if ($buku['nama_kategori']): ?>
                        <a href="katalog.php?kategori=<?= htmlspecialchars($buku['kategori_slug']) ?>" class="badge bg-primary text-decoration-none">
                            <i class="fas fa-tag"></i> <?= htmlspecialchars($buku['nama_kategori']) ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user"></i> Penulis:</strong> <?= htmlspecialchars($buku['penulis']) ?></p>
                        <p><strong><i class="fas fa-barcode"></i> ISBN:</strong> <?= htmlspecialchars($buku['isbn'] ?? '-') ?></p>
                        <p><strong><i class="fas fa-calendar"></i> Tahun Terbit:</strong> <?= htmlspecialchars($buku['tahun_terbit'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-file-alt"></i> Jumlah Halaman:</strong> <?= htmlspecialchars($buku['jumlah_halaman'] ?? '-') ?> halaman</p>
                        <p><strong><i class="fas fa-tag"></i> Harga:</strong> <span class="h4 text-primary">Rp <?= number_format($buku['harga'], 0, ',', '.') ?></span></p>
                        
                        <!-- TAMPILAN STOK (DITAMBAHKAN) -->
                        <p><strong><i class="fas fa-boxes"></i> Stok Buku:</strong> 
                            <?php if ($stok > 0): ?>
                                <span class="text-success fw-bold">
                                    <i class="fas fa-check-circle"></i> <?= $stok ?> tersedia
                                </span>
                            <?php else: ?>
                                <span class="text-danger fw-bold">
                                    <i class="fas fa-times-circle"></i> Stok Habis
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4>Sinopsis</h4>
                    <div class="sinopsis">
                        <?= nl2br(htmlspecialchars($buku['sinopsis'] ?? 'Sinopsis belum tersedia.')) ?>
                    </div>
                </div>
                
                <!-- TOMBOL WHATSAPP (BERUBAH BERDASARKAN STOK) -->
                <div class="d-flex gap-2">
                    <?php if ($stok > 0): ?>
                        <a href="https://wa.me/6281234567890?text=Halo%20saya%20tertarik%20dengan%20buku%20<?= urlencode($buku['judul']) ?>%20dari%20Penerbit%20SGN%0A%0A📚%20Detail%20Buku:%0AJudul:%20<?= urlencode($buku['judul']) ?>%0APenulis:%20<?= urlencode($buku['penulis']) ?>%0AHarga:%20Rp%20<?= urlencode(number_format($buku['harga'], 0, ',', '.')) ?>%0AStok:%20<?= $stok ?>%0A%0ASaya%20ingin%20memesan%20buku%20ini." 
                           target="_blank" 
                           class="btn btn-success btn-lg flex-grow-1">
                            <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg flex-grow-1" disabled>
                            <i class="fas fa-ban"></i> Stok Habis - Tidak Tersedia
                        </button>
                    <?php endif; ?>
                    <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </div>
                
                <!-- PERINGATAN JIKA STOK HABIS -->
                <?php if ($stok == 0): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Maaf, stok buku ini sedang habis.</strong> Silakan cek kembali nanti atau hubungi admin untuk informasi ketersediaan.
                    </div>
                <?php elseif ($stok <= 5): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Stok terbatas!</strong> Hanya tersisa <?= $stok ?> buku. Segera pesan sebelum habis!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Buku Terkait -->
    <?php
    $related_query = "SELECT judul, slug, stok FROM tbl_buku 
                      WHERE id_kategori = '{$buku['id_kategori']}' 
                      AND id != '{$buku['id']}' 
                      LIMIT 4";
    $related_result = mysqli_query($koneksi, $related_query);
    
    if (mysqli_num_rows($related_result) > 0):
    ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Buku Terkait</h3>
        </div>
        <?php while ($related = mysqli_fetch_assoc($related_result)): ?>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h6><?= htmlspecialchars($related['judul']) ?></h6>
                        <!-- Tampilkan stok di buku terkait -->
                        <?php if (($related['stok'] ?? 0) > 0): ?>
                            <span class="badge bg-success mb-2">Tersedia</span>
                        <?php else: ?>
                            <span class="badge bg-danger mb-2">Stok Habis</span>
                        <?php endif; ?>
                        <a href="detail.php?slug=<?= htmlspecialchars($related['slug']) ?>" class="btn btn-sm btn-primary mt-2">
                            Lihat Buku
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>