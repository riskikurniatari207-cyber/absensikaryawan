<?php
require_once 'config/database.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Cek apakah email sudah terdaftar
        $check_sql = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert ke database dengan role karyawan
            $sql = "INSERT INTO users (nama, email, password, role) 
                    VALUES ('$nama', '$email', '$hashed_password', 'karyawan')";
            
            if (mysqli_query($conn, $sql)) {
                $success = "Pendaftaran berhasil! Silakan login.";
                // Redirect ke halaman login setelah 3 detik
                header("refresh:3;url=index.php");
            } else {
                $error = "Terjadi kesalahan: " . mysqli_error($conn);
            }
        }
    }
}

// Set variables for header
$page_title = "Register";
$show_navbar = false;
$page_header = [
    'title' => 'Daftar Akun Baru',
    'description' => 'Bergabung dengan sistem absensi kami'
];
?>
<?php include 'includes/header.php'; ?>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <div class="register-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Isi form berikut untuk mendaftar</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                <p>Anda akan diarahkan ke halaman login...</p>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="register-form" onsubmit="return validateRegisterForm()">
            <div class="form-group">
                <label for="nama">
                    <i class="fas fa-user"></i> Nama Lengkap
                </label>
                <input type="text" name="nama" id="nama" required 
                       placeholder="masukkan nama lengkap Anda"
                       value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" name="email" id="email" required 
                       placeholder="contoh@email.com"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <small class="form-text">Gunakan email yang aktif</small>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required 
                           placeholder="minimal 6 karakter">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <span class="strength-segment"></span>
                        <span class="strength-segment"></span>
                        <span class="strength-segment"></span>
                    </div>
                    <span class="strength-text">Kekuatan password</span>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">
                    <i class="fas fa-lock"></i> Konfirmasi Password
                </label>
                <div class="password-wrapper">
                    <input type="password" name="confirm_password" id="confirm_password" required 
                           placeholder="ulangi password Anda">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-match">
                    <i class="fas fa-check-circle"></i>
                    <span>Password cocok</span>
                </div>
            </div>
            
            <div class="form-group terms">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>Saya menyetujui <a href="#" class="terms-link">Syarat & Ketentuan</a> dan <a href="#" class="terms-link">Kebijakan Privasi</a></span>
                </label>
            </div>
            
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>
            
            <div class="register-divider">
                <span>Sudah punya akun?</span>
            </div>
            
            <div class="register-options">
                <a href="index.php" class="btn-login-link">
                    <i class="fas fa-sign-in-alt"></i> Login ke Akun Saya
                </a>
            </div>
        </form>
        
        <div class="register-info">
            <h4><i class="fas fa-shield-alt"></i> Keamanan Data</h4>
            <p>Data Anda dilindungi dengan enkripsi SSL dan kami tidak akan membagikan informasi pribadi Anda kepada pihak ketiga.</p>
        </div>
    </div>
    
    <div class="register-benefits">
        <h3><i class="fas fa-star"></i> Keuntungan Bergabung</h3>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>Absensi Online</h4>
                <p>Lakukan absensi kapan saja dan di mana saja secara online</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4>Statistik Lengkap</h4>
                <p>Pantau riwayat dan statistik absensi Anda secara real-time</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h4>Notifikasi</h4>
                <p>Dapatkan pemberitahuan penting tentang absensi dan pengumuman</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Akses Mobile</h4>
                <p>Akses sistem melalui smartphone dengan responsif design</p>
            </div>
        </div>
    </div>
</div>

<style>
    .register-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .register-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: slideUp 0.8s ease;
    }
    
    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .register-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .register-logo i {
        font-size: 2.5rem;
        color: white;
    }
    
    .register-header h2 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }
    
    .register-header p {
        color: #666;
        margin: 0;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #2ecc71;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-success i {
        font-size: 1.2rem;
    }
    
    .register-form .form-group {
        margin-bottom: 25px;
    }
    
    .register-form label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .register-form input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e1e1e1;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s;
        background: #f9f9f9;
    }
    
    .register-form input:focus {
        outline: none;
        border-color: #4facfe;
        background: white;
        box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
    }
    
    .form-text {
        display: block;
        margin-top: 5px;
        color: #888;
        font-size: 0.85rem;
    }
    
    .password-wrapper {
        position: relative;
    }
    
    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        font-size: 1.1rem;
        padding: 5px;
    }
    
    .password-strength {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .strength-bar {
        display: flex;
        gap: 3px;
        flex: 1;
    }
    
    .strength-segment {
        flex: 1;
        height: 5px;
        background: #e1e1e1;
        border-radius: 3px;
        transition: all 0.3s;
    }
    
    .strength-text {
        font-size: 0.85rem;
        color: #888;
    }
    
    .password-match {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #888;
        font-size: 0.85rem;
        opacity: 0;
        transition: all 0.3s;
    }
    
    .password-match.active {
        opacity: 1;
        color: #2ecc71;
    }
    
    .terms {
        margin-top: 30px;
    }
    
    .checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        cursor: pointer;
        color: #555;
        font-size: 0.95rem;
        line-height: 1.4;
    }
    
    .checkbox-label input {
        width: auto;
        margin-top: 3px;
    }
    
    .terms-link {
        color: #4facfe;
        text-decoration: none;
    }
    
    .terms-link:hover {
        text-decoration: underline;
    }
    
    .btn-register {
        width: 100%;
        padding: 16px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        margin: 10px 0 25px;
    }
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
    }
    
    .register-divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
    }
    
    .register-divider span {
        background: white;
        padding: 0 15px;
        color: #999;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }
    
    .register-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e1e1e1;
    }
    
    .register-options {
        text-align: center;
    }
    
    .btn-login-link {
        display: inline-block;
        padding: 12px 30px;
        background: #f8f9fa;
        color: #555;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
    }
    
    .btn-login-link:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }
    
    .register-info {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #4facfe;
    }
    
    .register-info h4 {
        color: #333;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .register-info p {
        color: #666;
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    .register-benefits {
        color: white;
        animation: fadeIn 1s ease;
    }
    
    .register-benefits h3 {
        font-size: 2rem;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
    
    .benefit-item {
        background: rgba(255,255,255,0.1);
        padding: 25px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }
    
    .benefit-item:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-5px);
    }
    
    .benefit-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    
    .benefit-icon i {
        font-size: 1.8rem;
        color: white;
    }
    
    .benefit-item h4 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: white;
    }
    
    .benefit-item p {
        color: rgba(255,255,255,0.8);
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @media (max-width: 1200px) {
        .benefits-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 992px) {
        .register-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .register-benefits {
            order: -1;
            text-align: center;
        }
        
        .register-benefits h3 {
            justify-content: center;
        }
    }
    
    @media (max-width: 768px) {
        .register-card {
            padding: 30px 20px;
        }
        
        .benefits-grid {
            grid-template-columns: 1fr;
        }
        
        .benefit-item {
            padding: 20px;
        }
    }
    
    @media (max-width: 576px) {
        .register-container {
            padding: 15px;
        }
        
        .register-header h2 {
            font-size: 1.5rem;
        }
        
        .register-benefits h3 {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    function validateRegisterForm() {
        const nama = document.getElementById('nama').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const terms = document.getElementById('terms');
        
        if (!nama) {
            alert('Nama lengkap harus diisi!');
            document.getElementById('nama').focus();
            return false;
        }
        
        if (!email) {
            alert('Email harus diisi!');
            document.getElementById('email').focus();
            return false;
        }
        
        if (!email.includes('@') || !email.includes('.')) {
            alert('Format email tidak valid!');
            document.getElementById('email').focus();
            return false;
        }
        
        if (!password) {
            alert('Password harus diisi!');
            document.getElementById('password').focus();
            return false;
        }
        
        if (password.length < 6) {
            alert('Password minimal 6 karakter!');
            document.getElementById('password').focus();
            return false;
        }
        
        if (!confirmPassword) {
            alert('Konfirmasi password harus diisi!');
            document.getElementById('confirm_password').focus();
            return false;
        }
        
        if (password !== confirmPassword) {
            alert('Password dan konfirmasi password tidak cocok!');
            document.getElementById('confirm_password').focus();
            return false;
        }
        
        if (!terms.checked) {
            alert('Anda harus menyetujui Syarat & Ketentuan!');
            terms.focus();
            return false;
        }
        
        return true;
    }
    
    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleButton = passwordInput.parentElement.querySelector('.toggle-password i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.classList.remove('fa-eye');
            toggleButton.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleButton.classList.remove('fa-eye-slash');
            toggleButton.classList.add('fa-eye');
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const strengthSegments = document.querySelectorAll('.strength-segment');
        const passwordMatch = document.querySelector('.password-match');
        
        // Check password strength
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Length check
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            
            // Complexity checks
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Cap strength at 3 for segments
            strength = Math.min(strength, 3);
            
            // Update strength bar
            strengthSegments.forEach((segment, index) => {
                if (index < strength) {
                    let color;
                    if (strength === 1) color = '#e74c3c';
                    else if (strength === 2) color = '#f39c12';
                    else color = '#2ecc71';
                    
                    segment.style.background = color;
                } else {
                    segment.style.background = '#e1e1e1';
                }
            });
        });
        
        // Check password match
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password === confirmPassword) {
                passwordMatch.classList.add('active');
            } else {
                passwordMatch.classList.remove('active');
            }
        });
        
        // Auto focus on first field
        if (document.getElementById('nama') && !document.getElementById('nama').value) {
            document.getElementById('nama').focus();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>