<?php
// File: layanan.php - Halaman Layanan
include 'includes/koneksi.php';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center text-white">
        <h1 class="mb-3">Layanan Kami</h1>
        <p class="lead mb-0">Solusi lengkap penerbitan buku dari naskah hingga distribusi global</p>
    </div>
</section>

<div class="container py-5">

    <!-- Intro -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Apa yang Kami Tawarkan?</h2>
        <p class="text-muted mx-auto" style="max-width: 700px;">
            CV. Smart Global Nusantara menyediakan layanan penerbitan lengkap dan profesional, 
            mulai dari editing naskah hingga distribusi buku ke seluruh dunia. 
            Kami hadir untuk mewujudkan karya terbaik Anda.
        </p>
        <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
    </div>

    <!-- Layanan Utama -->
    <div class="row g-4 mb-5">

        <!-- Layanan 1: Penerbitan ISBN -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Penerbitan ISBN">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h5 class="fw-bold">Penerbitan Ber-ISBN</h5>
                    <p class="text-muted">
                        Kami menerbitkan buku dengan ISBN resmi yang terdaftar di Perpustakaan Nasional Republik Indonesia (Perpusnas). Setiap buku dijamin legalitasnya dan dapat beredar secara resmi di seluruh Indonesia.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>ISBN resmi terdaftar Perpusnas</li>
                        <li>Proses cepat dan mudah</li>
                        <li>Berlaku seumur hidup</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Layanan 2: Editing & Layout -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Editing Layout">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-pencil-alt"></i>
                    </div>
                    <h5 class="fw-bold">Editing & Layout</h5>
                    <p class="text-muted">
                        Tim editor profesional kami siap membantu menyunting naskah Anda agar lebih rapi, enak dibaca, dan berkualitas tinggi. Layout buku dirancang secara profesional sesuai standar penerbitan nasional.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>Editor berpengalaman</li>
                        <li>Layout profesional</li>
                        <li>Desain cover menarik</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Layanan 3: Desain Cover -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1626428091979-b1c3b1e72b72?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Desain Cover">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h5 class="fw-bold">Desain Cover Profesional</h5>
                    <p class="text-muted">
                        Cover buku adalah kesan pertama yang dilihat pembaca. Tim desainer grafis kami akan membuat cover buku yang menarik, kreatif, dan sesuai dengan isi buku Anda.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>Desain original & kreatif</li>
                        <li>Revisi hingga puas</li>
                        <li>Format print & digital</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Layanan 4: Cetak Buku -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1568667256549-094345857637?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Cetak Buku">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-print"></i>
                    </div>
                    <h5 class="fw-bold">Cetak Buku</h5>
                    <p class="text-muted">
                        Layanan cetak buku dengan kualitas terbaik menggunakan mesin cetak modern. Tersedia pilihan cetak satuan (print on demand) maupun cetak massal dengan harga yang kompetitif.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>Print on demand</li>
                        <li>Cetak massal</li>
                        <li>Kualitas kertas premium</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Layanan 5: Distribusi -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Distribusi">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h5 class="fw-bold">Distribusi Global</h5>
                    <p class="text-muted">
                        Buku Anda akan kami distribusikan ke berbagai platform penjualan buku online maupun offline, baik di dalam negeri maupun internasional, sehingga menjangkau lebih banyak pembaca.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>Distribusi nasional & internasional</li>
                        <li>Platform online & offline</li>
                        <li>Laporan penjualan berkala</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Layanan 6: Publikasi Digital -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm book-card">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80&fit=crop"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Publikasi Digital">
                <div class="card-body p-4">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h5 class="fw-bold">Publikasi Digital</h5>
                    <p class="text-muted">
                        Di era digital ini, kami juga menyediakan layanan publikasi dalam format e-book yang dapat diakses di berbagai perangkat. Jangkau lebih banyak pembaca dengan versi digital buku Anda.
                    </p>
                    <ul class="text-muted ps-3">
                        <li>Format PDF & ePub</li>
                        <li>Akses multi-perangkat</li>
                        <li>Distribusi platform digital</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Alur Penerbitan -->
    <div class="bg-light rounded-3 p-5 mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Alur Penerbitan</h2>
            <p class="text-muted">Proses penerbitan buku di SGN sangat mudah dan transparan</p>
            <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h6 class="fw-bold">1. Kirim Naskah</h6>
                <p class="text-muted small">Upload naskah Anda ke tim kami</p>
            </div>
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-search"></i>
                </div>
                <h6 class="fw-bold">2. Review</h6>
                <p class="text-muted small">Tim kami mereview naskah Anda</p>
            </div>
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-edit"></i>
                </div>
                <h6 class="fw-bold">3. Editing</h6>
                <p class="text-muted small">Proses editing & layout profesional</p>
            </div>
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h6 class="fw-bold">4. Persetujuan</h6>
                <p class="text-muted small">Penulis menyetujui hasil akhir</p>
            </div>
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-print"></i>
                </div>
                <h6 class="fw-bold">5. Cetak</h6>
                <p class="text-muted small">Buku dicetak dengan kualitas terbaik</p>
            </div>
            <div class="col-md-2 col-4">
                <div class="contact-icon mx-auto mb-3">
                    <i class="fas fa-truck"></i>
                </div>
                <h6 class="fw-bold">6. Distribusi</h6>
                <p class="text-muted small">Buku didistribusikan ke seluruh dunia</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center py-4">
        <h3 class="fw-bold mb-3">Siap Menerbitkan Buku Anda?</h3>
        <p class="text-muted mb-4">Hubungi kami sekarang dan konsultasikan naskah Anda secara gratis!</p>
        <a href="kontak.php" class="btn btn-primary btn-lg px-5 me-2">
            <i class="fas fa-envelope me-2"></i>Hubungi Kami
        </a>
        <a href="paket.php" class="btn btn-outline-primary btn-lg px-5">
            <i class="fas fa-tags me-2"></i>Lihat Paket
        </a>
    </div>

</div>

<?php include 'includes/footer.php'; ?>