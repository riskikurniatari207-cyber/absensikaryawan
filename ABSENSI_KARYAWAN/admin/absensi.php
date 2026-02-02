<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

// Filter berdasarkan tanggal
$tanggal_filter = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

$sql = "SELECT u.nama, a.* FROM absensi a 
        JOIN users u ON a.user_id = u.id 
        WHERE a.tanggal = '$tanggal_filter' 
        ORDER BY a.check_in DESC";
$absensi = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Absensi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .filter-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .filter-form input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="karyawan.php">Daftar Karyawan</a></li>
                <li class="active"><a href="absensi.php">Data Absensi</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Semua Absensi</h1>
            </div>
            
            <!-- Filter -->
            <div class="card">
                <form method="GET" class="filter-form">
                    <input type="date" name="tanggal" value="<?php echo $tanggal_filter; ?>">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="absensi.php" class="btn">Reset</a>
                </form>
            </div>
            
            <!-- Tabel Absensi -->
            <div class="card">
                <h3>Data Absensi - <?php echo date('d F Y', strtotime($tanggal_filter)); ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($absensi) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($absensi)): ?>
                                <tr>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                    <td><?php echo $row['check_in'] ? date('H:i', strtotime($row['check_in'])) : '--:--'; ?></td>
                                    <td><?php echo $row['check_out'] ? date('H:i', strtotime($row['check_out'])) : '--:--'; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $row['status']; ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Belum ada data absensi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>