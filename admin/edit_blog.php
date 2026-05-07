<?php
// File: admin/edit_blog.php - Edit Artikel Blog
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$total_pesan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_pesan"))['total'];
$total_blog = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tbl_blog"))['total'];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$artikel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbl_blog WHERE id = $id"));

if (!$artikel) {
    header("Location: kelola_blog.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $slug     = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9 ]/', '', $judul)));
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi      = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $penulis  = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $thumbnail = $artikel['thumbnail'];

    // Upload thumbnail baru jika ada
    if (!empty($_FILES['thumbnail']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $thumbnail = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['thumbnail']['name']);
            $target = '../images/blog/' . $thumbnail;
            if (!is_dir('../images/blog')) mkdir('../images/blog', 0777, true);
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target);
        } else {
            $error = "Format file tidak diizinkan.";
        }
    }

    if (empty($error)) {
        $query = "UPDATE tbl_blog SET judul='$judul', slug='$slug', thumbnail='$thumbnail', 
                  kategori='$kategori', isi='$isi', penulis='$penulis' WHERE id=$id";
        if (mysqli_query($koneksi, $query)) {
            header("Location: kelola_blog.php?success=edit");
            exit;
        } else {
            $error = "Gagal update: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel - Admin SGN</title>
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
                <h2><i class="fas fa-edit"></i> Edit Artikel Blog</h2>
                <a href="kelola_blog.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?= $error ?></div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Judul Artikel <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control" required value="<?= htmlspecialchars($artikel['judul']) ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <input type="text" name="kategori" class="form-control"
                                               value="<?= htmlspecialchars($artikel['kategori']) ?>" list="kategori-list">
                                        <datalist id="kategori-list">
                                            <option value="Tips Menulis">
                                            <option value="Penerbitan">
                                            <option value="Akademik">
                                            <option value="Teknologi">
                                            <option value="Inspirasi">
                                        </datalist>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Penulis</label>
                                        <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($artikel['penulis']) ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Isi Artikel <span class="text-danger">*</span></label>
                                    <textarea name="isi" class="form-control" rows="12" required><?= htmlspecialchars($artikel['isi']) ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Thumbnail</label>
                                    <input type="file" name="thumbnail" class="form-control" accept="image/*" onchange="previewImg(this)">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                    <div class="mt-3 text-center">
                                        <?php if (!empty($artikel['thumbnail'])): ?>
                                            <img id="preview" src="../images/blog/<?= htmlspecialchars($artikel['thumbnail']) ?>"
                                                 class="img-fluid rounded shadow" style="max-width:100%; border-radius:8px;">
                                        <?php else: ?>
                                            <img id="preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='250' height='160'%3E%3Crect width='250' height='160' fill='%23ddd'/%3E%3Ctext x='125' y='80' text-anchor='middle' fill='%23999' font-size='14'%3EBelum ada thumbnail%3C/text%3E%3C/svg%3E"
                                                 class="img-fluid rounded shadow" style="max-width:100%;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-end">
                            <a href="kelola_blog.php" class="btn btn-secondary btn-lg me-2">Batal</a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Update Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>