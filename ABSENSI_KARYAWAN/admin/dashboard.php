<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

// Cek apakah user adalah admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Statistik
$total_karyawan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'karyawan'"))['total'];
$total_hadir_hari_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND status = 'hadir'"))['total'];
$total_terlambat_hari_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND status = 'terlambat'"))['total'];
$total_absensi_bulan_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM absensi WHERE MONTH(tanggal) = MONTH(CURDATE())"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: #34495e;
        }
        .sidebar ul li.active a {
            background: #3498db;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .stat-card p {
            color: #7f8c8d;
        }
        .stat-card i {
            font-size: 3em;
            color: #3498db;
            margin-bottom: 15px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card h3 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-success {
            background: #2ecc71;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="karyawan.php">Daftar Karyawan</a></li>
                <li><a href="absensi.php">Data Absensi</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div style="margin-top: 50px; padding: 20px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                <p>Admin:</p>
                <h3><?php echo $_SESSION['nama']; ?></h3>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Dashboard Admin</h1>
                <p>Sistem Manajemen Absensi Karyawan</p>
            </div>
            
            <!-- Statistik -->
            <div class="stats">
                <div class="stat-card">
                    <i>👥</i>
                    <h3><?php echo $total_karyawan; ?></h3>
                    <p>Total Karyawan</p>
                </div>
                <div class="stat-card">
                    <i>✅</i>
                    <h3><?php echo $total_hadir_hari_ini; ?></h3>
                    <p>Hadir Hari Ini</p>
                </div>
                <div class="stat-card">
                    <i>⏰</i>
                    <h3><?php echo $total_terlambat_hari_ini; ?></h3>
                    <p>Terlambat Hari Ini</p>
                </div>
                <div class="stat-card">
                    <i>📊</i>
                    <h3><?php echo $total_absensi_bulan_ini; ?></h3>
                    <p>Absensi Bulan Ini</p>
                </div>
            </div>
            
            <!-- Absensi Terbaru -->
            <div class="card">
                <h3>Absensi Hari Ini</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT u.nama, a.* FROM absensi a 
                                JOIN users u ON a.user_id = u.id 
                                WHERE a.tanggal = CURDATE() 
                                ORDER BY a.check_in DESC";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0):
                            while($row = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['check_in'] ? date('H:i', strtotime($row['check_in'])) : '--:--'; ?></td>
                                <td><?php echo $row['check_out'] ? date('H:i', strtotime($row['check_out'])) : '--:--'; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Belum ada absensi hari ini</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>