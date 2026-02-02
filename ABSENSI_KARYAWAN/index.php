<?php
session_start();

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: karyawan/dashboard.php');
    }
    exit();
}

$page_title = "Beranda - Sistem Absensi Karyawan";
$show_navbar = false;
?>
<?php include 'includes/header.php'; ?>

<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Sistem Absensi Karyawan</h1>
                <p class="hero-subtitle">Kelola kehadiran karyawan dengan mudah, cepat, dan efisien. Solusi terbaik untuk manajemen absensi perusahaan Anda.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-count="500">0</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="99">0</div>
                        <div class="stat-label">% Kepuasan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="24">0</div>
                        <div class="stat-label">/7 Support</div>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    <a href="admin/login.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-shield"></i> Login Admin
                    </a>
                    <a href="karyawan/login.php" class="btn btn-outline btn-lg">
                        <i class="fas fa-user-tie"></i> Login Karyawan
                    </a>
                </div>
            </div>
            
            <div class="hero-image">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Dashboard Illustration">
            </div>
        </div>
    </div>
</div>

<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2>Fitur Unggulan</h2>
            <p>Solusi lengkap untuk kebutuhan absensi perusahaan Anda</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Absensi Real-time</h3>
                <p>Pencatatan kehadiran secara real-time dengan sistem Check In/Out yang akurat</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Analisis Data</h3>
                <p>Laporan dan statistik lengkap untuk evaluasi kinerja karyawan</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Akses Mobile</h3>
                <p>Responsive design untuk akses optimal dari berbagai perangkat</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Keamanan Terjamin</h3>
                <p>Data terlindungi dengan sistem enkripsi dan autentikasi aman</p>
            </div>
        </div>
    </div>
</section>

<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>Cara Kerja Sistem</h2>
            <p>Mudah digunakan oleh admin dan karyawan</p>
        </div>
        
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Login ke Sistem</h3>
                    <p>Admin atau karyawan login ke sistem dengan akun terdaftar</p>
                </div>
            </div>
            
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Absensi Harian</h3>
                    <p>Karyawan melakukan Check In saat datang dan Check Out saat pulang</p>
                </div>
            </div>
            
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Monitoring & Laporan</h3>
                    <p>Admin memantau kehadiran dan generate laporan</p>
                </div>
            </div>
            
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Analisis Data</h3>
                    <p>Evaluasi performa berdasarkan data absensi terkumpul</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="login-options">
    <div class="container">
        <div class="login-cards">
            <div class="login-card admin-login">
                <div class="login-card-header">
                    <i class="fas fa-user-shield"></i>
                    <h3>Login Admin</h3>
                </div>
                <div class="login-card-body">
                    <p>Akses panel admin untuk mengelola sistem, karyawan, dan melihat laporan</p>
                    <ul>
                        <li><i class="fas fa-check"></i> Kelola data karyawan</li>
                        <li><i class="fas fa-check"></i> Monitoring absensi</li>
                        <li><i class="fas fa-check"></i> Generate laporan</li>
                        <li><i class="fas fa-check"></i> Pengaturan sistem</li>
                    </ul>
                    <a href="admin/login.php" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                    </a>
                </div>
            </div>
            
            <div class="login-card employee-login">
                <div class="login-card-header">
                    <i class="fas fa-user-tie"></i>
                    <h3>Login Karyawan</h3>
                </div>
                <div class="login-card-body">
                    <p>Akses dashboard karyawan untuk absensi dan melihat riwayat kehadiran</p>
                    <ul>
                        <li><i class="fas fa-check"></i> Absensi harian</li>
                        <li><i class="fas fa-check"></i> Riwayat kehadiran</li>
                        <li><i class="fas fa-check"></i> Status absensi</li>
                        <li><i class="fas fa-check"></i> Pengajuan izin</li>
                    </ul>
                    <a href="karyawan/login.php" class="btn btn-success">
                        <i class="fas fa-sign-in-alt"></i> Login sebagai Karyawan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info">
                <h2>Butuh Bantuan?</h2>
                <p>Tim support kami siap membantu 24/7</p>
                <div class="contact-details">
                    <p><i class="fas fa-envelope"></i> support@absensi.com</p>
                    <p><i class="fas fa-phone"></i> (021) 1234-5678</p>
                    <p><i class="fas fa-clock"></i> Senin - Sabtu, 08:00 - 15:00</p>
                </div>
            </div>
            <div class="contact-action">
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-question-circle"></i> Panduan Penggunaan
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        min-height: 90vh;
        display: flex;
        align-items: center;
    }
    
    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 40px;
        line-height: 1.6;
    }
    
    .hero-stats {
        display: flex;
        gap: 40px;
        margin-bottom: 40px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    .hero-buttons {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .btn-outline {
        background: transparent;
        border: 2px solid white;
        color: white;
    }
    
    .btn-outline:hover {
        background: white;
        color: #667eea;
    }
    
    .hero-image img {
        max-width: 100%;
        height: auto;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    /* Features Section */
    .features-section {
        padding: 100px 0;
        background: #f8f9fa;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        color: #333;
        margin-bottom: 15px;
    }
    
    .section-header p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }
    
    .feature-card {
        background: white;
        padding: 40px 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }
    
    .feature-icon i {
        font-size: 1.8rem;
        color: white;
    }
    
    .feature-card h3 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.3rem;
    }
    
    .feature-card p {
        color: #666;
        line-height: 1.6;
    }
    
    /* How It Works */
    .how-it-works {
        padding: 100px 0;
        background: white;
    }
    
    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        position: relative;
    }
    
    .steps::before {
        content: '';
        position: absolute;
        top: 40px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e1e1e1;
        z-index: 1;
    }
    
    .step {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .step-number {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 auto 25px;
        position: relative;
        z-index: 2;
    }
    
    .step-content h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.2rem;
    }
    
    .step-content p {
        color: #666;
        line-height: 1.6;
    }
    
    /* Login Options */
    .login-options {
        padding: 100px 0;
        background: #f8f9fa;
    }
    
    .login-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .login-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .login-card:hover {
        transform: translateY(-10px);
    }
    
    .login-card-header {
        padding: 30px;
        text-align: center;
        color: white;
    }
    
    .admin-login .login-card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    }
    
    .employee-login .login-card-header {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    }
    
    .login-card-header i {
        font-size: 3rem;
        margin-bottom: 20px;
    }
    
    .login-card-header h3 {
        font-size: 1.8rem;
        margin: 0;
    }
    
    .login-card-body {
        padding: 40px 30px;
    }
    
    .login-card-body p {
        color: #666;
        margin-bottom: 25px;
        line-height: 1.6;
    }
    
    .login-card-body ul {
        list-style: none;
        margin-bottom: 30px;
    }
    
    .login-card-body li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #555;
    }
    
    .login-card-body li i {
        color: #2ecc71;
    }
    
    .login-card-body .btn {
        width: 100%;
        padding: 15px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    /* Contact Section */
    .contact-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
    }
    
    .contact-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 40px;
    }
    
    .contact-info h2 {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .contact-info p {
        opacity: 0.9;
        margin-bottom: 20px;
    }
    
    .contact-details p {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .btn-outline {
        border: 2px solid white;
        color: white;
        padding: 15px 30px;
    }
    
    .btn-outline:hover {
        background: white;
        color: #2c3e50;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .hero-content {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .hero-stats {
            justify-content: center;
        }
        
        .hero-buttons {
            justify-content: center;
        }
        
        .steps::before {
            display: none;
        }
        
        .contact-content {
            flex-direction: column;
            text-align: center;
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-stats {
            flex-direction: column;
            gap: 20px;
        }
        
        .hero-buttons {
            flex-direction: column;
        }
        
        .features-grid,
        .login-cards {
            grid-template-columns: 1fr;
        }
        
        .steps {
            grid-template-columns: 1fr;
            gap: 60px;
        }
    }
</style>

<script>
    // Animated counter
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 100;
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.textContent = target;
                }
            };
            
            // Start counter when in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            observer.observe(counter);
        });
    });
</script>

<?php include 'includes/footer.php'; ?>