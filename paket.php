<?php
// File: paket.php - Halaman Paket Penerbitan
include 'includes/koneksi.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center text-white">
        <h1 class="mb-3">Paket Penerbitan</h1>
        <p class="lead mb-0">Pilih paket yang sesuai dengan kebutuhan Anda dan wujudkan karya terbaik Anda bersama SGN</p>
    </div>
</section>

<div class="container py-5">

    <!-- Intro -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Pilih Paket Terbaik Anda</h2>
        <p class="text-muted mx-auto" style="max-width: 700px;">
            CV. Smart Global Nusantara menyediakan berbagai paket penerbitan yang dapat disesuaikan 
            dengan kebutuhan dan anggaran Anda. Semua paket sudah termasuk ISBN resmi dari Perpusnas.
        </p>
        <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
    </div>

    <!-- Pricing Cards -->
    <div class="row g-4 mb-5 justify-content-center">

        <!-- Paket Dasar -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-header bg-light border-0 py-4">
                    <div class="contact-icon mx-auto mb-3">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h4 class="fw-bold">Paket Dasar</h4>
                    <p class="text-muted small mb-0">Untuk penulis pemula</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="display-6 fw-bold text-primary">Rp 500K</span>
                        <p class="text-muted small">/ penerbitan</p>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ISBN Resmi Perpusnas</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Desain Cover Standar</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Layout Naskah</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>File Digital (PDF)</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sertifikat Penerbitan</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times text-danger me-2"></i>Cetak Buku</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times text-danger me-2"></i>Distribusi Online</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times text-danger me-2"></i>Editing Profesional</li>
                    </ul>
                    <a href="kontak.php" class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i>Pilih Paket
                    </a>
                </div>
            </div>
        </div>

        <!-- Paket Reguler (POPULAR) -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow text-center" style="border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-primary text-white border-0 py-4">
                    <span class="badge bg-warning text-dark mb-2">⭐ TERPOPULER</span>
                    <div class="mb-2">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">Paket Reguler</h4>
                    <p class="small mb-0 opacity-75">Untuk penulis profesional</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="display-6 fw-bold text-primary">Rp 1.0Jt</span>
                        <p class="text-muted small">/ penerbitan</p>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ISBN Resmi Perpusnas</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Desain Cover Premium</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Layout Naskah Profesional</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>File Digital (PDF & ePub)</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sertifikat Penerbitan</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Cetak 5 Eksemplar</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Distribusi Online</li>
                        <li class="mb-2 text-muted"><i class="fas fa-times text-danger me-2"></i>Editing Profesional</li>
                    </ul>
                    <a href="kontak.php" class="btn btn-primary w-100">
                        <i class="fas fa-envelope me-2"></i>Pilih Paket
                    </a>
                </div>
            </div>
        </div>

        <!-- Paket Premium -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-header border-0 py-4" style="background-color: #fff3cd;">
                    <div class="contact-icon mx-auto mb-3" style="background-color: #ffc107;">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h4 class="fw-bold">Paket Premium</h4>
                    <p class="text-muted small mb-0">Untuk institusi & akademisi</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="display-6 fw-bold text-primary">Rp 1.5Jt</span>
                        <p class="text-muted small">/ penerbitan</p>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>ISBN Resmi Perpusnas</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Desain Cover Eksklusif</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Layout Naskah Profesional</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>File Digital (PDF & ePub)</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sertifikat Penerbitan</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Cetak 10 Eksemplar</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Distribusi Global</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Editing Profesional</li>
                    </ul>
                    <a href="kontak.php" class="btn btn-warning w-100 text-dark fw-bold">
                        <i class="fas fa-envelope me-2"></i>Pilih Paket
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Perbandingan Fitur -->
    <div class="mb-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Perbandingan Paket</h2>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th class="text-start">Fitur</th>
                        <th>Dasar</th>
                        <th>Reguler ⭐</th>
                        <th>Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start fw-bold">ISBN Resmi</td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr class="table-light">
                        <td class="text-start fw-bold">Desain Cover</td>
                        <td>Standar</td>
                        <td>Premium</td>
                        <td>Eksklusif</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Layout Naskah</td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr class="table-light">
                        <td class="text-start fw-bold">File Digital</td>
                        <td>PDF</td>
                        <td>PDF & ePub</td>
                        <td>PDF & ePub</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Cetak Buku</td>
                        <td><i class="fas fa-times text-danger"></i></td>
                        <td>5 Eks</td>
                        <td>10 Eks</td>
                    </tr>
                    <tr class="table-light">
                        <td class="text-start fw-bold">Distribusi</td>
                        <td><i class="fas fa-times text-danger"></i></td>
                        <td>Online</td>
                        <td>Global</td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Editing Profesional</td>
                        <td><i class="fas fa-times text-danger"></i></td>
                        <td><i class="fas fa-times text-danger"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr class="table-light">
                        <td class="text-start fw-bold">Sertifikat Penerbitan</td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                        <td><i class="fas fa-check text-success"></i></td>
                    </tr>
                    <tr>
                        <td class="text-start fw-bold">Harga</td>
                        <td class="fw-bold text-primary">Rp 500.000</td>
                        <td class="fw-bold text-primary">Rp 1.000.000</td>
                        <td class="fw-bold text-primary">Rp 1.500.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FAQ -->
    <div class="mb-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Pertanyaan Umum</h2>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
        </div>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                <h2 class="accordion-header">
                    <button class="accordion-button rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Berapa lama proses penerbitan buku?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Proses penerbitan membutuhkan waktu sekitar 2-4 minggu tergantung paket yang dipilih dan kelengkapan naskah. Tim kami akan memberikan update secara berkala selama proses berlangsung.
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Apakah naskah saya harus dalam format tertentu?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Naskah dapat dikirim dalam format Microsoft Word (.doc/.docx) atau PDF. Minimal tebal naskah adalah 40 halaman A4. Tim kami akan membantu proses layouting sesuai standar penerbitan.
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Bagaimana cara pembayaran?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Pembayaran dapat dilakukan melalui transfer bank atau dompet digital. Pembayaran dilakukan di awal setelah kesepakatan paket dan naskah diterima oleh tim kami.
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 shadow-sm mb-3 rounded">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        Apakah hak cipta buku tetap milik saya?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted">
                        Ya, hak cipta sepenuhnya tetap milik penulis. CV. Smart Global Nusantara hanya bertindak sebagai penerbit dan tidak mengklaim kepemilikan atas naskah Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center py-4 bg-light rounded-3 p-5">
        <h3 class="fw-bold mb-3">Masih Bingung Pilih Paket?</h3>
        <p class="text-muted mb-4">Konsultasikan kebutuhan Anda dengan tim kami secara gratis!</p>
        <a href="kontak.php" class="btn btn-primary btn-lg px-5">
            <i class="fas fa-comments me-2"></i>Konsultasi Gratis
        </a>
    </div>

</div>

<?php include 'includes/footer.php'; ?>