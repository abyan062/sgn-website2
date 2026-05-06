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

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4">Katalog Buku SGN</h1>
            <p class="lead text-muted">Temukan buku-buku terbaik dari penerbit kami</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="katalog.php" class="list-group-item list-group-item-action <?= $filter == '' ? 'active' : '' ?>">
                            Semua Buku
                        </a>
                        <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                            <a href="?kategori=<?= htmlspecialchars($kat['slug']) ?>" 
                               class="list-group-item list-group-item-action <?= $filter == $kat['slug'] ? 'active' : '' ?>">
                                <?= htmlspecialchars($kat['nama_kategori']) ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Daftar Buku -->
        <div class="col-lg-9">
            <!-- Search Bar -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-2">
                        <?php if ($filter != ''): ?>
                            <input type="hidden" name="kategori" value="<?= htmlspecialchars($filter) ?>">
                        <?php endif; ?>
                        <div class="col-9">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($search) ?>">
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Result Count -->
            <div class="mb-3">
                <span class="badge bg-secondary">
                    <i class="fas fa-book"></i> Ditemukan <?= mysqli_num_rows($result) ?> buku
                </span>
            </div>
            
            <!-- Book Grid -->
            <div class="row g-4">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($buku = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card book-card h-100">
                                <img src="images/covers/<?= htmlspecialchars($buku['cover'] ?? '') ?>" 
                                     class="card-img-top" 
                                     alt="Cover <?= htmlspecialchars($buku['judul']) ?>">
                                <div class="card-body">
                                    <?php if ($buku['nama_kategori']): ?>
                                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($buku['nama_kategori']) ?></span>
                                    <?php endif; ?>
                                    <h5 class="card-title"><?= htmlspecialchars($buku['judul']) ?></h5>
                                    <p class="card-text text-muted small">
                                        <i class="fas fa-user"></i> <?= htmlspecialchars($buku['penulis']) ?>
                                    </p>
                                    
                                    <!-- TAMPILAN STOK (DITAMBAHKAN) -->
                                    <p class="card-text">
                                        <?php 
                                        $stok = isset($buku['stok']) ? $buku['stok'] : 0;
                                        if ($stok > 0): 
                                        ?>
                                            <span class="text-success">
                                                <i class="fas fa-box"></i> Stok: <?= $stok ?>
                                                <span class="badge bg-success">Tersedia</span>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-danger">
                                                <i class="fas fa-ban"></i> Stok: Habis
                                                <span class="badge bg-danger">Stok Habis</span>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                    
                                    <p class="card-text price-tag">
                                        <strong class="text-primary">Rp <?= number_format($buku['harga'], 0, ',', '.') ?></strong>
                                    </p>
                                    
                                    <!-- TOMBOL DETAIL (BERUBAH BERDASARKAN STOK) -->
                                    <?php if ($stok > 0): ?>
                                        <a href="detail.php?slug=<?= htmlspecialchars($buku['slug']) ?>" class="btn btn-primary w-100">
                                            Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-ban"></i> Stok Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> Tidak ada buku ditemukan.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>