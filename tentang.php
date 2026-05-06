<?php
// File: tentang.php - Halaman Tentang Kami
include 'includes/koneksi.php';
include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 mb-3">Tentang Penerbit SGN</h1>
                <p class="lead text-muted">Smart Global Nusantara - Mencerdaskan Bangsa</p>
                <div class="divider mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body p-5">
                    <h3><i class="fas fa-history text-primary me-2"></i> Sejarah Kami</h3>
                    <p class="text-muted">
                        Penerbit Smart Global Nusantara (SGN) berdiri sejak tahun 2020 dengan visi 
                        menjadi penerbit terdepan dalam menyediakan buku-buku berkualitas untuk 
                        masyarakat Indonesia. Berawal dari tim kecil yang berdedikasi, kami terus 
                        berkembang dan kini telah menerbitkan lebih dari 100 judul buku di berbagai bidang.
                    </p>
                    
                    <h3 class="mt-4"><i class="fas fa-bullseye text-primary me-2"></i> Visi</h3>
                    <p class="text-muted">
                        Menjadi penerbit buku terkemuka di Asia Tenggara yang berkomitmen pada 
                        kualitas dan inovasi, serta berkontribusi dalam mencerdaskan kehidupan bangsa.
                    </p>
                    
                    <h3 class="mt-4"><i class="fas fa-tasks text-primary me-2"></i> Misi</h3>
                    <ul class="text-muted">
                        <li>Menerbitkan buku-buku berkualitas yang sesuai dengan kebutuhan masyarakat</li>
                        <li>Mengembangkan jaringan penulis dan editor profesional</li>
                        <li>Memanfaatkan teknologi digital untuk menjangkau pembaca yang lebih luas</li>
                        <li>Berkontribusi pada peningkatan literasi nasional</li>
                    </ul>
                    
                    <h3 class="mt-4"><i class="fas fa-chart-line text-primary me-2"></i> Pencapaian</h3>
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <div class="display-4 text-primary fw-bold">100+</div>
                            <p class="text-muted">Judul Buku</p>
                        </div>
                        <div class="col-md-4">
                            <div class="display-4 text-primary fw-bold">50+</div>
                            <p class="text-muted">Penulis Terbaik</p>
                        </div>
                        <div class="col-md-4">
                            <div class="display-4 text-primary fw-bold">25k+</div>
                            <p class="text-muted">Pembaca Setia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>