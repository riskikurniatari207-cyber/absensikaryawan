<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Tambah karyawan
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (nama, email, password, role) 
            VALUES ('$nama', '$email', '$password', 'karyawan')";
    mysqli_query($conn, $sql);
    header('Location: karyawan.php');
    exit();
}

// Hapus karyawan
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $sql = "DELETE FROM users WHERE id = $id AND role = 'karyawan'";
    mysqli_query($conn, $sql);
    header('Location: karyawan.php');
    exit();
}

// Ambil data karyawan
$sql = "SELECT * FROM users WHERE role = 'karyawan' ORDER BY nama";
$karyawan = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Tambahkan style yang sama seperti dashboard.php */
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar (sama seperti dashboard.php) -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li class="active"><a href="karyawan.php">Daftar Karyawan</a></li>
                <li><a href="absensi.php">Data Absensi</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Daftar Karyawan</h1>
                <button onclick="openModal()" class="btn btn-primary">+ Tambah Karyawan</button>
            </div>
            
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($karyawan)): ?>
                            <tr>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo ucfirst($row['role']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-danger" 
                                            onclick="hapusKaryawan(<?php echo $row['id']; ?>)">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah Karyawan -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <h2>Tambah Karyawan Baru</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    <button type="button" onclick="closeModal()" class="btn">Batal</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openModal() {
            document.getElementById('modalTambah').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('modalTambah').style.display = 'none';
        }
        
        function hapusKaryawan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) {
                window.location.href = 'karyawan.php?hapus=' + id;
            }
        }
        
        // Tutup modal saat klik di luar
        window.onclick = function(event) {
            const modal = document.getElementById('modalTambah');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>