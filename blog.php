<?php
// File: blog.php - Halaman Blog
include 'includes/koneksi.php';
include 'includes/header.php';

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Query artikel
$query = "SELECT * FROM tbl_blog WHERE 1=1";
if ($search != '') {
    $query .= " AND (judul LIKE '%$search%' OR isi LIKE '%$search%')";
}
if ($kategori != '') {
    $query .= " AND kategori = '$kategori'";
}
$query .= " ORDER BY created_at DESC";
$result = mysqli_query($koneksi, $query);

// Ambil artikel terbaru untuk featured (artikel pertama)
$featured_query = "SELECT * FROM tbl_blog ORDER BY created_at DESC LIMIT 1";
$featured_result = mysqli_query($koneksi, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// Ambil semua kategori unik
$kat_query = "SELECT DISTINCT kategori FROM tbl_blog WHERE kategori IS NOT NULL AND kategori != '' ORDER BY kategori";
$kat_result = mysqli_query($koneksi, $kat_query);
?>

<style>
    .blog-hero {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 60%, #084298 100%);
        padding: 60px 0 80px;
        position: relative;
        overflow: hidden;
    }
    .blog-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .blog-body {
        background-color: #f0f4f8;
        min-height: 100vh;
    }
    .featured-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .featured-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .featured-img {
        height: 380px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .featured-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #0d6efd;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .blog-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
    }
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.13);
    }
    .blog-card .card-img-top {
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .blog-card .card-body {
        padding: 20px;
    }
    .blog-card .card-title {
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
    .kategori-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border-bottom: 1px solid #f0f0f0;
        text-decoration: none;
        color: #444;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .kategori-item:hover {
        background-color: #e8f0fe;
        color: #0d6efd;
        padding-left: 22px;
    }
    .kategori-item.active {
        background-color: #e8f0fe;
        color: #0d6efd;
        font-weight: 600;
    }
    .search-input {
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        padding: 10px 16px;
    }
    .search-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }
    .img-placeholder {
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .img-placeholder-featured {
        height: 380px;
        background: linear-gradient(135deg, #0d6efd 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<!-- Hero Blog -->
<section class="blog-hero">
    <div class="container text-center text-white position-relative" style="z-index:1;">
        <h1 class="fw-bold mb-2">✍️ Blog SGN</h1>
        <p class="lead mb-0 opacity-75">Tips menulis, info penerbitan, dan inspirasi untuk para penulis</p>
    </div>
</section>

<div class="blog-body py-5">
    <div class="container">

        <!-- Featured Article -->
        <?php if ($featured && $search == '' && $kategori == ''): ?>
        <div class="mb-5">
            <h5 class="fw-bold mb-3 text-muted"><i class="fas fa-fire text-danger me-2"></i>Artikel Terbaru</h5>
            <div class="card featured-card">
                <div class="row g-0">
                    <div class="col-lg-6 position-relative">
                        <?php if (!empty($featured['thumbnail'])): ?>
                            <img src="images/blog/<?= htmlspecialchars($featured['thumbnail']) ?>"
                                 class="featured-img w-100" alt="<?= htmlspecialchars($featured['judul']) ?>">
                        <?php else: ?>
                            <div class="img-placeholder-featured w-100">
                                <i class="fas fa-book-open fa-4x text-white opacity-50"></i>
                            </div>
                        <?php endif; ?>
                        <span class="featured-badge">⭐ Featured</span>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="card-body p-5">
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-3" style="border-radius:6px;">
                                <?= htmlspecialchars($featured['kategori'] ?? 'Umum') ?>
                            </span>
                            <h3 class="fw-bold mb-3"><?= htmlspecialchars($featured['judul']) ?></h3>
                            <p class="text-muted mb-3">
                                <?= substr(htmlspecialchars($featured['isi']), 0, 150) ?>...
                            </p>
                            <div class="d-flex align-items-center text-muted small mb-4">
                                <i class="fas fa-user me-1"></i>
                                <span class="me-3"><?= htmlspecialchars($featured['penulis']) ?></span>
                                <i class="fas fa-calendar me-1"></i>
                                <span><?= date('d M Y', strtotime($featured['created_at'])) ?></span>
                            </div>
                            <a href="blog_detail.php?slug=<?= htmlspecialchars($featured['slug']) ?>" class="btn btn-primary">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- Artikel Grid -->
            <div class="col-lg-8">
                <h5 class="fw-bold mb-4 text-muted">
                    <i class="fas fa-newspaper text-primary me-2"></i>
                    <?= $search != '' ? "Hasil pencarian: \"$search\"" : ($kategori != '' ? "Kategori: $kategori" : 'Semua Artikel') ?>
                </h5>

                <div class="row g-4">
                    <?php
                    $count = 0;
                    if (mysqli_num_rows($result) > 0):
                        while ($artikel = mysqli_fetch_assoc($result)):
                            // Skip featured article di halaman utama
                            if ($search == '' && $kategori == '' && $featured && $artikel['id'] == $featured['id']) continue;
                            $count++;
                    ?>
                        <div class="col-md-6">
                            <div class="blog-card card h-100">
                                <?php if (!empty($artikel['thumbnail'])): ?>
                                    <img src="images/blog/<?= htmlspecialchars($artikel['thumbnail']) ?>"
                                         class="card-img-top" alt="<?= htmlspecialchars($artikel['judul']) ?>">
                                <?php else: ?>
                                    <div class="img-placeholder">
                                        <i class="fas fa-book-open fa-2x text-white opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2" style="width:fit-content; border-radius:6px;">
                                        <?= htmlspecialchars($artikel['kategori'] ?? 'Umum') ?>
                                    </span>
                                    <h5 class="card-title mb-2"><?= htmlspecialchars($artikel['judul']) ?></h5>
                                    <p class="text-muted small mb-3">
                                        <?= substr(htmlspecialchars($artikel['isi']), 0, 100) ?>...
                                    </p>
                                    <div class="d-flex align-items-center text-muted small mb-3">
                                        <i class="fas fa-user me-1"></i>
                                        <span class="me-2"><?= htmlspecialchars($artikel['penulis']) ?></span>
                                        <i class="fas fa-calendar me-1"></i>
                                        <span><?= date('d M Y', strtotime($artikel['created_at'])) ?></span>
                                    </div>
                                    <div class="mt-auto">
                                        <a href="blog_detail.php?slug=<?= htmlspecialchars($artikel['slug']) ?>" class="btn btn-outline-primary btn-sm w-100">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    endif;
                    ?>

                    <?php if ($count == 0 && mysqli_num_rows($result) == 0): ?>
                        <div class="col-12">
                            <div class="text-center bg-white rounded-3 p-5 shadow-sm">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Artikel tidak ditemukan</h5>
                                <a href="blog.php" class="btn btn-outline-primary mt-2">Lihat Semua Artikel</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Search -->
                <div class="sidebar-card card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 text-white fw-bold"><i class="fas fa-search me-2"></i>Cari Artikel</h6>
                    </div>
                    <div class="card-body p-3">
                        <form method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input"
                                       placeholder="Cari artikel..." value="<?= htmlspecialchars($search) ?>">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="sidebar-card card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 text-white fw-bold"><i class="fas fa-tags me-2"></i>Kategori</h6>
                    </div>
                    <div class="card-body p-0">
                        <a href="blog.php" class="kategori-item <?= $kategori == '' ? 'active' : '' ?>">
                            <span><i class="fas fa-th-large me-2"></i>Semua Artikel</span>
                        </a>
                        <?php while ($kat = mysqli_fetch_assoc($kat_result)): ?>
                            <a href="?kategori=<?= urlencode($kat['kategori']) ?>"
                               class="kategori-item <?= $kategori == $kat['kategori'] ? 'active' : '' ?>">
                                <span><i class="fas fa-tag me-2"></i><?= htmlspecialchars($kat['kategori']) ?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Artikel Populer -->
                <div class="sidebar-card card">
                    <div class="card-header">
                        <h6 class="mb-0 text-white fw-bold"><i class="fas fa-fire me-2"></i>Artikel Terpopuler</h6>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        $popular_query = "SELECT * FROM tbl_blog ORDER BY created_at DESC LIMIT 4";
                        $popular_result = mysqli_query($koneksi, $popular_query);
                        $no = 1;
                        while ($pop = mysqli_fetch_assoc($popular_result)):
                        ?>
                        <a href="blog_detail.php?slug=<?= htmlspecialchars($pop['slug']) ?>"
                           class="d-flex align-items-start p-3 text-decoration-none border-bottom"
                           style="color: inherit; transition: background 0.2s;"
                           onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background=''">
                            <span class="badge bg-primary me-3 mt-1" style="min-width:24px;"><?= $no++ ?></span>
                            <div>
                                <p class="mb-1 small fw-bold" style="line-height:1.4;"><?= htmlspecialchars($pop['judul']) ?></p>
                                <small class="text-muted"><?= date('d M Y', strtotime($pop['created_at'])) ?></small>
                            </div>
                        </a>
                        <?php endwhile; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
