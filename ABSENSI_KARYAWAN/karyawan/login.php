<?php
session_start();
require_once '../config/database.php';
$error = '';

// Jika sudah login sebagai karyawan, redirect ke dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'karyawan') {
    header('Location: dashboard.php');
    exit();
}

// Jika sudah login sebagai admin, redirect ke admin dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    header('Location: ../admin/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND role = 'karyawan'";
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
        $error = "Email karyawan tidak ditemukan!";
    }
}

$page_title = "Login Karyawan";
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
                    <i class="fas fa-user-tie"></i>
                    <h2>Login Karyawan</h2>
                    <p>Sistem Absensi Online Perusahaan</p>
                </div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="login-form" id="employeeLoginForm">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Karyawan
                    </label>
                    <input type="email" name="email" id="email" required 
                           placeholder="budi@company.com"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'budi@company.com'; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required 
                               placeholder="Masukkan password"
                               value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : 'karyawan123'; ?>">
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
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai Karyawan
                </button>
                
                <div class="login-divider">
                    <span>atau</span>
                </div>
                
                <div class="login-options">
                    <p>Bukan karyawan? 
                        <a href="../admin/login.php">Login sebagai Admin</a>
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
                <div class="demo-accounts">
                    <div class="demo-account">
                        <p><strong>Email:</strong> budi@company.com</p>
                        <p><strong>Password:</strong> karyawan123</p>
                    </div>
                    <div class="demo-account">
                        <p><strong>Email:</strong> siti@company.com</p>
                        <p><strong>Password:</strong> karyawan123</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="login-sidebar">
            <div class="sidebar-content">
                <h3><i class="fas fa-user-tie"></i> Fitur untuk Karyawan</h3>
                <ul class="employee-features">
                    <li><i class="fas fa-check"></i> Absensi Check In/Out</li>
                    <li><i class="fas fa-check"></i> Riwayat kehadiran</li>
                    <li><i class="fas fa-check"></i> Status absensi real-time</li>
                    <li><i class="fas fa-check"></i> Pengajuan izin & cuti</li>
                    <li><i class="fas fa-check"></i> Notifikasi penting</li>
                    <li><i class="fas fa-check"></i> Akses mobile-friendly</li>
                </ul>
                
                <div class="attendance-tips">
                    <h4><i class="fas fa-lightbulb"></i> Tips Absensi</h4>
                    <ul>
                        <li>Lakukan Check In sebelum jam kerja</li>
                        <li>Check Out setelah selesai bekerja</li>
                        <li>Ajukan izin minimal 1 hari sebelumnya</li>
                        <li>Periksa status absensi secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
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
        color: #2ecc71;
        text-decoration: none;
        font-size: 0.9rem;
        margin-bottom: 20px;
        transition: color 0.3s;
    }
    
    .back-home:hover {
        color: #27ae60;
    }
    
    .login-logo {
        text-align: center;
    }
    
    .login-logo i {
        font-size: 3.5rem;
        color: #2ecc71;
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
        border-color: #2ecc71;
        background: white;
        box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
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
        color: #2ecc71;
        text-decoration: none;
        font-size: 0.9rem;
    }
    
    .forgot-password:hover {
        text-decoration: underline;
    }
    
    .btn-login {
        width: 100%;
        padding: 16px;
        background: linear-gradient(to right, #27ae60, #2ecc71);
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
        box-shadow: 0 10px 20px rgba(46, 204, 113, 0.3);
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
        color: #2ecc71;
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
        border-left: 4px solid #2ecc71;
    }
    
    .login-info h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .demo-accounts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .demo-account {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e1e1e1;
    }
    
    .demo-account p {
        margin: 5px 0;
        color: #666;
        font-size: 0.9rem;
    }
    
    .demo-account strong {
        color: #333;
    }
    
    .login-sidebar {
        background: linear-gradient(135deg, #219653 0%, #27ae60 100%);
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
    
    .employee-features {
        list-style: none;
        margin-bottom: 40px;
    }
    
    .employee-features li {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1rem;
    }
    
    .employee-features li i {
        color: #fff;
    }
    
    .attendance-tips {
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        border-left: 4px solid #fff;
    }
    
    .attendance-tips h4 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }
    
    .attendance-tips ul {
        list-style: none;
    }
    
    .attendance-tips li {
        margin-bottom: 10px;
        padding-left: 20px;
        position: relative;
    }
    
    .attendance-tips li:before {
        content: "•";
        position: absolute;
        left: 0;
        color: #fff;
    }
    
    @media (max-width: 992px) {
        .login-container {
            grid-template-columns: 1fr;
        }
        
        .login-sidebar {
            display: none;
        }
        
        .demo-accounts {
            grid-template-columns: 1fr;
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
            alert('Email karyawan harus diisi!');
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
        const form = document.getElementById('employeeLoginForm');
        if (form) {
            form.onsubmit = validateLoginForm;
        }
        
        // Auto fill for demo
        const emailField = document.getElementById('email');
        if (emailField && !emailField.value) {
            emailField.value = 'budi@company.com';
        }
    });
</script>

<?php include '../includes/footer.php'; ?>