<?php
// File: katalog.php - Halaman Katalog Buku
include 'includes/koneksi.php';
include 'includes/header.php';

// Ambil semua kategori untuk filter
$kategori_query = "SELECT * FROM tbl_kategori ORDER BY nama_kategori";
$kategori_result = mysqli_query($koneksi, $kategori_query);

// Cek apakah ada filter kategori
$filter = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query buku dengan filter
if ($filter != '') {
    $query = "SELECT b.*, k.nama_kategori 
              FROM tbl_buku b 
              LEFT JOIN tbl_kategori k ON b.id_kategori = k.id 
              WHERE k.slug = '$filter'";
} else {
    $query = "SELECT b.*, k.nama_kategori 
              FROM tbl_buku b 
              LEFT JOIN tbl_kategori k ON b.id_kategori = k.id";
}

// Tambah search condition
if ($search != '') {
    if ($filter != '') {
        $query .= " AND (b.judul LIKE '%$search%' OR b.penulis LIKE '%$search%')";
    } else {
        $query .= " WHERE (b.judul LIKE '%$search%' OR b.penulis LIKE '%$search%')";
    }
}

$query .= " ORDER BY b.created_at DESC";
$result = mysqli_query($koneksi, $query);
?>

<!-- Custom Style khusus halaman bookstore -->
<style>
    .bookstore-hero {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 60%, #084298 100%);
        padding: 60px 0 80px;
        position: relative;
        overflow: hidden;
    }
    .bookstore-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .bookstore-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .bookstore-body {
        background-color: #f0f4f8;
        min-height: 100vh;
    }
    .filter-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        position: sticky;
        top: 80px;
    }
    .filter-card .card-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 16px 20px;
        border: none;
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f0f0f0;
        padding: 10px 16px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .list-group-item:hover {
        background-color: #e8f0fe;
        color: #0d6efd;
        padding-left: 22px;
    }
    .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .search-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }
    .search-card .form-control {
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        padding: 10px 16px;
        font-size: 0.95rem;
    }
    .search-card .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }
    .search-card .btn {
        border-radius: 10px;
    }
    .book-card-new {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
    }
    .book-card-new:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.13);
    }
    .book-card-new .card-img-top {
        height: 220px;
        object-fit: cover;
        background-color: #f5f5f5;
    }
    .book-card-new .card-body {
        padding: 16px;
    }
    .book-card-new .card-title {
        font-size: 0.95rem;
        font-weight: 600;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .result-badge {
        background: #fff;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 0.85rem;
        color: #555;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        display: inline-block;
    }
    .empty-state {
        background: #fff;
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }
</style>

<!-- Hero Bookstore -->
<section class="bookstore-hero">
    <div class="container text-center text-white position-relative" style="z-index:1;">
        <h1 class="fw-bold mb-2">📚 Bookstore SGN</h1>
        <p class="lead mb-0 opacity-75">Temukan buku-buku terbaik dari penerbit kami</p>
    </div>
</section>

<!-- Body Bookstore -->
<div class="bookstore-body py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Sidebar Filter -->
            <div class="col-lg-3">
                <div class="filter-card card">
                    <div class="card-header">
                        <h6 class="mb-0 text-white fw-bold">
                            <i class="fas fa-filter me-2"></i>Filter Kategori
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="katalog.php" class="list-group-item list-group-item-action <?= $filter == '' ? 'active' : '' ?>">
                                <i class="fas fa-th-large me-2"></i>Semua Buku
                            </a>
                            <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                                <a href="?kategori=<?= htmlspecialchars($kat['slug']) ?>"
                                   class="list-group-item list-group-item-action <?= $filter == $kat['slug'] ? 'active' : '' ?>">
                                    <i class="fas fa-bookmark me-2"></i><?= htmlspecialchars($kat['nama_kategori']) ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Buku -->
            <div class="col-lg-9">

                <!-- Search Bar -->
                <div class="search-card card mb-4">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-2 align-items-center">
                            <?php if ($filter != ''): ?>
                                <input type="hidden" name="kategori" value="<?= htmlspecialchars($filter) ?>">
                            <?php endif; ?>
                            <div class="col-9">
                                <input type="text" name="search" class="form-control"
                                       placeholder="🔍  Cari judul atau penulis..."
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Result Count -->
                <div class="mb-3">
                    <span class="result-badge">
                        <i class="fas fa-book text-primary me-1"></i>
                        Ditemukan <strong><?= mysqli_num_rows($result) ?></strong> buku
                        <?= $search != '' ? "untuk \"<em>$search</em>\"" : '' ?>
                    </span>
                </div>

                <!-- Book Grid -->
                <div class="row g-4">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($buku = mysqli_fetch_assoc($result)): ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="book-card-new card h-100">
                                    <img src="images/covers/<?= htmlspecialchars($buku['cover'] ?? '') ?>"
                                         class="card-img-top"
                                         alt="Cover <?= htmlspecialchars($buku['judul']) ?>">
                                    <div class="card-body d-flex flex-column">
                                        <?php if ($buku['nama_kategori']): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2" style="width:fit-content; border-radius:6px;">
                                                <?= htmlspecialchars($buku['nama_kategori']) ?>
                                            </span>
                                        <?php endif; ?>

                                        <h5 class="card-title mb-1"><?= htmlspecialchars($buku['judul']) ?></h5>

                                        <p class="card-text text-muted small mb-2">
                                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($buku['penulis']) ?>
                                        </p>

                                        <!-- Stok -->
                                        <?php
                                        $stok = isset($buku['stok']) ? $buku['stok'] : 0;
                                        ?>
                                        <p class="card-text mb-2">
                                            <?php if ($stok > 0): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success" style="border-radius:6px;">
                                                    <i class="fas fa-check-circle me-1"></i>Tersedia (<?= $stok ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger bg-opacity-10 text-danger" style="border-radius:6px;">
                                                    <i class="fas fa-times-circle me-1"></i>Stok Habis
                                                </span>
                                            <?php endif; ?>
                                        </p>

                                        <p class="fw-bold text-primary fs-5 mb-3">
                                            Rp <?= number_format($buku['harga'], 0, ',', '.') ?>
                                        </p>

                                        <div class="mt-auto">
                                            <?php if ($stok > 0): ?>
                                                <a href="detail.php?slug=<?= htmlspecialchars($buku['slug']) ?>" class="btn btn-primary w-100">
                                                    Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-secondary w-100" disabled>
                                                    <i class="fas fa-ban me-1"></i>Stok Habis
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Buku tidak ditemukan</h5>
                                <p class="text-muted small">Coba kata kunci lain atau lihat semua kategori</p>
                                <a href="katalog.php" class="btn btn-outline-primary mt-2">
                                    <i class="fas fa-th-large me-1"></i>Lihat Semua Buku
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>