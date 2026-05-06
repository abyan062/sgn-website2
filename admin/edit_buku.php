<?php
// File: admin/edit_buku.php - Form Edit Buku
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data buku
$query = "SELECT * FROM tbl_buku WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$buku = mysqli_fetch_assoc($result);

if (!$buku) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $slug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9 ]/', '', $judul)));
    $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $isbn = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $sinopsis = mysqli_real_escape_string($koneksi, $_POST['sinopsis']);
    $tahun = mysqli_real_escape_string($koneksi, $_POST['tahun_terbit']);
    $halaman = mysqli_real_escape_string($koneksi, $_POST['jumlah_halaman']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']); // <-- TAMBAH INI
    
    $cover = $buku['cover'];
    if ($_FILES['cover']['name']) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            // Hapus cover lama
            if ($cover && file_exists("../images/covers/$cover")) {
                unlink("../images/covers/$cover");
            }
            $cover = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['cover']['name']);
            move_uploaded_file($_FILES['cover']['tmp_name'], "../images/covers/$cover");
        } else {
            $error = "Format file tidak diizinkan.";
        }
    }
    
    if (empty($error)) {
        // Update query (tambah stok)
        $query = "UPDATE tbl_buku SET 
                  judul='$judul', slug='$slug', penulis='$penulis', isbn='$isbn', 
                  id_kategori='$id_kategori', sinopsis='$sinopsis', cover='$cover', 
                  tahun_terbit='$tahun', jumlah_halaman='$halaman', harga='$harga', stok='$stok' 
                  WHERE id=$id";
        
        if (mysqli_query($koneksi, $query)) {
            $success = "Buku berhasil diupdate!";
            // Refresh data
            $result = mysqli_query($koneksi, "SELECT * FROM tbl_buku WHERE id=$id");
            $buku = mysqli_fetch_assoc($result);
        } else {
            $error = "Gagal update: " . mysqli_error($koneksi);
        }
    }
}

// Ambil kategori
$kategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori ORDER BY nama_kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin SGN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-edit"></i> Edit Buku</h2>
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="card shadow">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Judul Buku</label>
                                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($buku['judul']) ?>" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($buku['penulis']) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($buku['isbn']) ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select name="id_kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                                            <option value="<?= $k['id'] ?>" <?= $buku['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($k['nama_kategori']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" class="form-control" value="<?= htmlspecialchars($buku['tahun_terbit']) ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok Buku</label>
                                    <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($buku['stok']) ?>" min="0" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Halaman</label>
                                    <input type="number" name="jumlah_halaman" class="form-control" value="<?= htmlspecialchars($buku['jumlah_halaman']) ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($buku['harga']) ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Sinopsis</label>
                                <textarea name="sinopsis" class="form-control" rows="6"><?= htmlspecialchars($buku['sinopsis']) ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Cover Buku</label>
                                <input type="file" name="cover" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <div class="mt-3 text-center">
                                    <img id="preview" src="../images/covers/<?= htmlspecialchars($buku['cover']) ?>" 
                                         class="img-fluid rounded shadow" style="max-width: 100%;"
                                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'250\'%3E%3Crect width=\'200\' height=\'250\' fill=\'%23ddd\'/%3E%3Ctext x=\'100\' y=\'125\' text-anchor=\'middle\' fill=\'%23999\'%3ECover%20Lama%3C/text%3E%3C/svg%3E'">
                                </div>
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah cover</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Update Buku
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary btn-lg">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>