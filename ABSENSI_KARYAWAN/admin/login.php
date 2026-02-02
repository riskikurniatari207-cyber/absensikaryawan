<?php
session_start();
require_once '../config/database.php';
$error = '';

// Jika sudah login sebagai admin, redirect ke dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Jika sudah login sebagai karyawan, redirect ke karyawan dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'karyawan') {
    header('Location: ../karyawan/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND role = 'admin'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];
            
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email admin tidak ditemukan!";
    }
}

$page_title = "Login Admin";
$show_navbar = false;
?>
<?php include '../includes/header.php'; ?>

<div class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <a href="../index.php" class="back-home">
                    <i class="fas fa-arrow-left"></i> Beranda
                </a>
                <div class="login-logo">
                    <i class="fas fa-user-shield"></i>
                    <h2>Login Admin</h2>
                    <p>Panel Administrasi Sistem Absensi</p>
                </div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form" id="adminLoginForm">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Admin
                    </label>
                    <input type="email" name="email" id="email" required 
                           placeholder="admin@company.com"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'admin@company.com'; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required 
                               placeholder="Masukkan password admin"
                               value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : 'admin123'; ?>">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
                </button>
                
                <div class="login-divider">
                    <span>atau</span>
                </div>
                
                <div class="login-options">
                    <p>Bukan admin? 
                        <a href="../karyawan/login.php">Login sebagai Karyawan</a>
                    </p>
                    <p>
                        <a href="../index.php">
                            <i class="fas fa-home"></i> Kembali ke Beranda
                        </a>
                    </p>
                </div>
            </form>
            
            <div class="login-info">
                <h4><i class="fas fa-info-circle"></i> Informasi Login</h4>
                <div class="demo-account">
                    <p><strong>Email:</strong> admin@company.com</p>
                    <p><strong>Password:</strong> admin123</p>
                </div>
            </div>
        </div>
        
        <div class="login-sidebar">
            <div class="sidebar-content">
                <h3><i class="fas fa-user-shield"></i> Hak Akses Admin</h3>
                <ul class="admin-features">
                    <li><i class="fas fa-check"></i> Kelola data karyawan</li>
                    <li><i class="fas fa-check"></i> Monitoring absensi real-time</li>
                    <li><i class="fas fa-check"></i> Generate laporan bulanan</li>
                    <li><i class="fas fa-check"></i> Pengaturan sistem</li>
                    <li><i class="fas fa-check"></i> Analisis statistik</li>
                    <li><i class="fas fa-check"></i> Manajemen izin & cuti</li>
                </ul>
                
                <div class="security-info">
                    <h4><i class="fas fa-shield-alt"></i> Keamanan</h4>
                    <p>Akses admin dilindungi dengan autentikasi dua faktor dan enkripsi data.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1200px;
        width: 100%;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.5s ease;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .login-box {
        padding: 50px;
    }
    
    .login-header {
        margin-bottom: 40px;
    }
    
    .back-home {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3498db;
        text-decoration: none;
        font-size: 0.9rem;
        margin-bottom: 20px;
        transition: color 0.3s;
    }
    
    .back-home:hover {
        color: #2980b9;
    }
    
    .login-logo {
        text-align: center;
    }
    
    .login-logo i {
        font-size: 3.5rem;
        color: #3498db;
        margin-bottom: 15px;
    }
    
    .login-logo h2 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 2rem;
    }
    
    .login-logo p {
        color: #666;
        margin: 0;
    }
    
    .alert-error {
        background: #fee;
        color: #c33;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-left: 4px solid #e74c3c;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .login-form .form-group {
        margin-bottom: 25px;
    }
    
    .login-form label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .login-form input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e1e1e1;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s;
        background: #f9f9f9;
    }
    
    .login-form input:focus {
        outline: none;
        border-color: #3498db;
        background: white;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
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
    
    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: #555;
    }
    
    .remember-me input {
        width: auto;
        margin: 0;
    }
    
    .forgot-password {
        color: #3498db;
        text-decoration: none;
        font-size: 0.9rem;
    }
    
    .forgot-password:hover {
        text-decoration: underline;
    }
    
    .btn-login {
        width: 100%;
        padding: 16px;
        background: linear-gradient(to right, #2c3e50, #3498db);
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
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
    }
    
    .login-divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
    }
    
    .login-divider span {
        background: white;
        padding: 0 15px;
        color: #999;
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }
    
    .login-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e1e1e1;
    }
    
    .login-options {
        text-align: center;
    }
    
    .login-options p {
        margin: 10px 0;
        color: #666;
    }
    
    .login-options a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
    }
    
    .login-options a:hover {
        text-decoration: underline;
    }
    
    .login-info {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #3498db;
    }
    
    .login-info h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .demo-account p {
        margin: 8px 0;
        color: #666;
    }
    
    .demo-account strong {
        color: #333;
    }
    
    .login-sidebar {
        background: linear-gradient(135deg, #1a252f 0%, #2c3e50 100%);
        color: white;
        padding: 50px;
        display: flex;
        align-items: center;
    }
    
    .sidebar-content h3 {
        font-size: 1.8rem;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .admin-features {
        list-style: none;
        margin-bottom: 40px;
    }
    
    .admin-features li {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1rem;
    }
    
    .admin-features li i {
        color: #2ecc71;
    }
    
    .security-info {
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        border-left: 4px solid #3498db;
    }
    
    .security-info h4 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .security-info p {
        margin: 0;
        opacity: 0.9;
        line-height: 1.6;
    }
    
    @media (max-width: 992px) {
        .login-container {
            grid-template-columns: 1fr;
        }
        
        .login-sidebar {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .login-box {
            padding: 30px 20px;
        }
        
        .remember-forgot {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .login-logo h2 {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    function validateLoginForm() {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        if (!email) {
            alert('Email admin harus diisi!');
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
        
        return true;
    }
    
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.querySelector('.toggle-password i');
        
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
        const form = document.getElementById('adminLoginForm');
        if (form) {
            form.onsubmit = validateLoginForm;
        }
        
        // Auto fill for demo
        const emailField = document.getElementById('email');
        if (emailField && !emailField.value) {
            emailField.value = 'admin@company.com';
        }
    });
</script>

<?php include '../includes/footer.php'; ?>