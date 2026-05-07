<?php
// File: blog_detail.php - Halaman Detail Artikel Blog
include 'includes/koneksi.php';
include 'includes/header.php';

// Ambil slug dari URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($koneksi, $_GET['slug']) : '';

// Jika tidak ada slug, redirect ke blog
if ($slug == '') {
    header('Location: blog.php');
    exit;
}

// Ambil artikel berdasarkan slug
$query = "SELECT * FROM tbl_blog WHERE slug = '$slug' LIMIT 1";
$result = mysqli_query($koneksi, $query);
$artikel = mysqli_fetch_assoc($result);

// Jika artikel tidak ditemukan
if (!$artikel) {
    header('Location: blog.php');
    exit;
}

// Ambil artikel lainnya (related)
$related_query = "SELECT * FROM tbl_blog WHERE id != '{$artikel['id']}' AND kategori = '{$artikel['kategori']}' ORDER BY created_at DESC LIMIT 3";
$related_result = mysqli_query($koneksi, $related_query);

// Jika tidak ada related, ambil artikel terbaru saja
if (mysqli_num_rows($related_result) == 0) {
    $related_query = "SELECT * FROM tbl_blog WHERE id != '{$artikel['id']}' ORDER BY created_at DESC LIMIT 3";
    $related_result = mysqli_query($koneksi, $related_query);
}
?>

<style>
    .detail-hero {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 60%, #084298 100%);
        padding: 50px 0 70px;
        position: relative;
        overflow: hidden;
    }
    .detail-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .detail-body {
        background-color: #f0f4f8;
        min-height: 100vh;
    }
    .article-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .article-thumbnail {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
    }
    .article-thumbnail-placeholder {
        width: 100%;
        height: 420px;
        background: linear-gradient(135deg, #0d6efd 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .article-content {
        font-size: 1.05rem;
        line-height: 1.9;
        color: #333;
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }
    .sidebar-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        position: sticky;
        top: 80px;
    }
    .sidebar-card .card-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 14px 20px;
        border: none;
    }
    .related-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .related-card .card-img-top {
        height: 150px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .img-placeholder-sm {
        height: 150px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .share-btn {
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 0.9rem;
    }
    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: white;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
    }
</style>

<!-- Hero -->
<section class="detail-hero">
    <div class="container position-relative" style="z-index:1;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="blog.php">Blog</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($artikel['kategori'] ?? 'Artikel') ?></li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-8 text-white text-center">
                <span class="badge bg-white text-primary mb-3 px-3 py-2" style="border-radius:20px;">
                    <?= htmlspecialchars($artikel['kategori'] ?? 'Umum') ?>
                </span>
                <h1 class="fw-bold mb-3" style="font-size:2rem; line-height:1.4;">
                    <?= htmlspecialchars($artikel['judul']) ?>
                </h1>
                <div class="d-flex justify-content-center align-items-center gap-3 opacity-75 small">
                    <span><i class="fas fa-user me-1"></i><?= htmlspecialchars($artikel['penulis']) ?></span>
                    <span>•</span>
                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($artikel['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Body -->
<div class="detail-body py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Artikel Utama -->
            <div class="col-lg-8">
                <div class="article-card card">
                    <!-- Thumbnail -->
                    <?php if (!empty($artikel['thumbnail'])): ?>
                        <img src="images/blog/<?= htmlspecialchars($artikel['thumbnail']) ?>"
                             class="article-thumbnail" alt="<?= htmlspecialchars($artikel['judul']) ?>">
                    <?php else: ?>
                        <div class="article-thumbnail-placeholder">
                            <i class="fas fa-book-open fa-4x text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Isi Artikel -->
                    <div class="card-body p-5">
                        <div class="article-content">
                            <?= nl2br(htmlspecialchars($artikel['isi'])) ?>
                        </div>

                        <hr class="my-4">

                        <!-- Share & Navigasi -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <span class="text-muted small me-2">Bagikan:</span>
                                <a href="https://wa.me/?text=<?= urlencode($artikel['judul'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                   target="_blank" class="btn btn-success btn-sm share-btn me-1">
                                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>"
                                   target="_blank" class="btn btn-primary btn-sm share-btn">
                                    <i class="fab fa-facebook me-1"></i>Facebook
                                </a>
                            </div>
                            <a href="blog.php" class="btn btn-outline-primary btn-sm share-btn">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Blog
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Artikel Terkait -->
                <div class="sidebar-card card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 text-white fw-bold">
                            <i class="fas fa-layer-group me-2"></i>Artikel Terkait
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <?php if (mysqli_num_rows($related_result) > 0): ?>
                            <?php while ($related = mysqli_fetch_assoc($related_result)): ?>
                                <a href="blog_detail.php?slug=<?= htmlspecialchars($related['slug']) ?>"
                                   class="text-decoration-none">
                                    <div class="related-card card mb-3">
                                        <?php if (!empty($related['thumbnail'])): ?>
                                            <img src="images/blog/<?= htmlspecialchars($related['thumbnail']) ?>"
                                                 class="card-img-top" alt="<?= htmlspecialchars($related['judul']) ?>">
                                        <?php else: ?>
                                            <div class="img-placeholder-sm">
                                                <i class="fas fa-book-open fa-2x text-white opacity-50"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body p-3">
                                            <p class="mb-1 small fw-bold text-dark" style="line-height:1.4;">
                                                <?= htmlspecialchars($related['judul']) ?>
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($related['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-muted small text-center py-2">Tidak ada artikel terkait</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CTA Box -->
                <div class="card border-0 shadow-sm text-center p-4" style="border-radius:16px;">
                    <i class="fas fa-book-open fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold">Siap Menerbitkan Buku?</h6>
                    <p class="text-muted small mb-3">Konsultasikan naskah Anda dengan tim SGN secara gratis!</p>
                    <a href="kontak.php" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-envelope me-1"></i>Hubungi Kami
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>