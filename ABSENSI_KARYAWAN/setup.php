<?php
// File: setup.php - Untuk setup database awal
require_once 'config/database.php';

echo "<h2>Setup Database Absensi Karyawan</h2>";

// Buat tabel users
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'karyawan') DEFAULT 'karyawan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Buat tabel absensi
$sql_absensi = "CREATE TABLE IF NOT EXISTS absensi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    tanggal DATE NOT NULL,
    check_in TIME,
    check_out TIME,
    status ENUM('hadir', 'terlambat', 'izin', 'cuti', 'alfa') DEFAULT 'hadir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_attendance (user_id, tanggal)
)";

// Jalankan query
if (mysqli_query($conn, $sql_users)) {
    echo "<p style='color:green;'>✓ Tabel users berhasil dibuat</p>";
} else {
    echo "<p style='color:red;'>✗ Error users: " . mysqli_error($conn) . "</p>";
}

if (mysqli_query($conn, $sql_absensi)) {
    echo "<p style='color:green;'>✓ Tabel absensi berhasil dibuat</p>";
} else {
    echo "<p style='color:red;'>✗ Error absensi: " . mysqli_error($conn) . "</p>";
}

// Tambahkan user admin dan karyawan
$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$karyawan_password = password_hash('karyawan123', PASSWORD_DEFAULT);

$users = [
    ['Administrator', 'admin@company.com', $admin_password, 'admin'],
    ['Budi Santoso', 'budi@company.com', $karyawan_password, 'karyawan'],
    ['Siti Nurhaliza', 'siti@company.com', $karyawan_password, 'karyawan'],
    ['Ahmad Wijaya', 'ahmad@company.com', $karyawan_password, 'karyawan']
];

foreach ($users as $user) {
    $sql = "INSERT INTO users (nama, email, password, role) 
            VALUES ('$user[0]', '$user[1]', '$user[2]', '$user[3]')
            ON DUPLICATE KEY UPDATE 
            nama = VALUES(nama), 
            password = VALUES(password), 
            role = VALUES(role)";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>✓ User {$user[0]} berhasil diupdate</p>";
    } else {
        echo "<p style='color:red;'>✗ Error user {$user[0]}: " . mysqli_error($conn) . "</p>";
    }
}

echo "<hr><h3>Setup Selesai!</h3>";
echo "<p><a href='index.php' class='btn'>Lihat Beranda</a></p>";
echo "<p><a href='admin/login.php' class='btn'>Login Admin</a></p>";
echo "<p><a href='karyawan/login.php' class='btn'>Login Karyawan</a></p>";

echo "<h4>Informasi Login:</h4>";
echo "<ul>";
echo "<li><strong>Admin:</strong> admin@company.com / admin123</li>";
echo "<li><strong>Karyawan:</strong> budi@company.com / karyawan123</li>";
echo "<li><strong>Karyawan:</strong> siti@company.com / karyawan123</li>";
echo "<li><strong>Karyawan:</strong> ahmad@company.com / karyawan123</li>";
echo "</ul>";

// Tambahkan style
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .btn { display: inline-block; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
    .btn:hover { background: #2980b9; }
</style>";
?>