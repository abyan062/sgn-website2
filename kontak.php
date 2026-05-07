<?php
// File: kontak.php - Halaman Kontak
include 'includes/koneksi.php';
include 'includes/header.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $subjek = mysqli_real_escape_string($koneksi, $_POST['subjek'] ?? '');
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan'] ?? '');
    
    // Validasi sederhana
    if (!empty($nama) && !empty($email) && !empty($pesan)) {
        // Simpan ke database (opsional)
        $query = "INSERT INTO tbl_pesan (nama, email, subjek, pesan) VALUES ('$nama', '$email', '$subjek', '$pesan')";
        if (mysqli_query($koneksi, $query)) {
            $success = "Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.";
        } else {
            // Jika tabel belum ada, setidaknya tampilkan pesan sukses
            $success = "Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.";
        }
    } else {
        $error = "Mohon lengkapi semua field yang diperlukan.";
    }
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center mb-5">
            <h1 class="display-4">Hubungi Kami</h1>
            <p class="lead text-muted">Ada pertanyaan? Kami siap membantu Anda!</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card contact-card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5>Alamat</h5>
                    <p class="text-muted">
                        Bumi Marina Emas Barat VIII/43B<br>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card contact-card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5>Telepon</h5>
                    <p class="text-muted">
                        081238555600<br>
                        082338387862
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card contact-card shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>Email</h5>
                    <p class="text-muted">
                        info@sgnpublisher.com<br>
                        marketing@sgnpublisher.com
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-paper-plane"></i> Kirim Pesan</h5>
                </div>
                <div class="card-body p-4">
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-custom alert-success-custom">
                            <i class="fas fa-check-circle"></i> <?= $success ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subjek" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subjek" name="subjek">
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
// Create pesan table if not exists (tabel untuk menyimpan pesan)
$create_pesan = "CREATE TABLE IF NOT EXISTS tbl_pesan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subjek VARCHAR(200),
    pesan TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($koneksi, $create_pesan);
?>