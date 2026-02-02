<?php
require_once 'config/database.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];
            
            if ($row['role'] == 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: karyawan/dashboard.php');
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}

// Set variables for header
$page_title = "Login";
$show_navbar = false;
$page_header = [
    'title' => 'Login ke Sistem',
    'description' => 'Masuk untuk mengakses dashboard'
];
?>
<?php include 'includes/header.php'; ?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h2>Selamat Datang</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="login-form" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" name="email" id="email" required 
                       placeholder="masukkan email Anda" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required 
                           placeholder="masukkan password Anda">
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
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
            
            <div class="login-divider">
                <span>atau</span>
            </div>
            
            <div class="login-options">
                <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
                <p>Login sebagai tamu? <a href="karyawan/dashboard.php?guest=true">Coba demo</a></p>
            </div>
        </form>
        
        <div class="login-footer">
            <h4>Login Default</h4>
            <div class="demo-accounts">
                <div class="demo-account">
                    <strong>Admin:</strong>
                    <p>admin@company.com / admin123</p>
                </div>
                <div class="demo-account">
                    <strong>Karyawan:</strong>
                    <p>budi@company.com / karyawan123</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="login-info">
        <h3><i class="fas fa-info-circle"></i> Tentang Sistem</h3>
        <ul>
            <li><i class="fas fa-check-circle"></i> Absensi online real-time</li>
            <li><i class="fas fa-check-circle"></i> Manajemen karyawan lengkap</li>
            <li><i class="fas fa-check-circle"></i> Laporan dan statistik</li>
            <li><i class="fas fa-check-circle"></i> Notifikasi dan pengingat</li>
            <li><i class="fas fa-check-circle"></i> Akses mobile-friendly</li>
        </ul>
    </div>
</div>

<style>
    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .login-card {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideInLeft 0.8s ease;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .login-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .login-logo i {
        font-size: 2.5rem;
        color: white;
    }
    
    .login-header h2 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }
    
    .login-header p {
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
    
    .alert-error i {
        font-size: 1.2rem;
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
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
        color: #667eea;
        text-decoration: none;
        font-size: 0.9rem;
    }
    
    .forgot-password:hover {
        text-decoration: underline;
    }
    
    .btn-login {
        width: 100%;
        padding: 16px;
        background: linear-gradient(to right, #667eea, #764ba2);
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
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
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
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .login-options a:hover {
        text-decoration: underline;
    }
    
    .login-footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e1e1e1;
    }
    
    .login-footer h4 {
        text-align: center;
        color: #333;
        margin-bottom: 15px;
        font-size: 1rem;
    }
    
    .demo-accounts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .demo-account {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
    
    .demo-account strong {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
    
    .demo-account p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
        word-break: break-all;
    }
    
    .login-info {
        color: white;
        animation: slideInRight 0.8s ease;
    }
    
    .login-info h3 {
        font-size: 2rem;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .login-info ul {
        list-style: none;
        font-size: 1.1rem;
    }
    
    .login-info li {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .login-info i {
        font-size: 1.3rem;
        color: #4ade80;
    }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @media (max-width: 992px) {
        .login-container {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        
        .login-info {
            order: -1;
            text-align: center;
        }
        
        .login-info h3 {
            justify-content: center;
        }
        
        .login-info li {
            justify-content: center;
        }
        
        .demo-accounts {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 576px) {
        .login-card {
            padding: 30px 20px;
        }
        
        .remember-forgot {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .login-info h3 {
            font-size: 1.5rem;
        }
        
        .login-info li {
            font-size: 1rem;
        }
    }
</style>

<script>
    function validateLoginForm() {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
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
    
    // Auto focus on email field
    document.addEventListener('DOMContentLoaded', function() {
        const emailField = document.getElementById('email');
        if (emailField && !emailField.value) {
            emailField.focus();
        }
        
        // Remember me functionality
        const rememberCheckbox = document.getElementById('remember');
        const savedEmail = localStorage.getItem('rememberedEmail');
        
        if (savedEmail && rememberCheckbox) {
            document.getElementById('email').value = savedEmail;
            rememberCheckbox.checked = true;
        }
        
        // Save email if remember me is checked
        document.querySelector('.login-form').addEventListener('submit', function() {
            if (rememberCheckbox && rememberCheckbox.checked) {
                localStorage.setItem('rememberedEmail', document.getElementById('email').value);
            } else {
                localStorage.removeItem('rememberedEmail');
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>