<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

// Cek apakah user adalah karyawan
if ($_SESSION['role'] != 'karyawan') {
    header('Location: ../index.php');
    exit();
}

// Tanggal sekarang
$today = date('Y-m-d');
$user_id = $_SESSION['user_id'];

// Cek absensi hari ini
$absensi_hari_ini = null;
$sql = "SELECT * FROM absensi WHERE user_id = $user_id AND tanggal = '$today'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $absensi_hari_ini = mysqli_fetch_assoc($result);
}

// Handle Check In
if (isset($_POST['check_in'])) {
    $waktu_sekarang = date('H:i:s');
    $status = 'hadir';
    
    // Cek apakah terlambat (setelah jam 9)
    if ($waktu_sekarang > '09:00:00') {
        $status = 'terlambat';
    }
    
    $sql = "INSERT INTO absensi (user_id, tanggal, check_in, status) 
            VALUES ($user_id, '$today', '$waktu_sekarang', '$status')";
    mysqli_query($conn, $sql);
    header('Location: dashboard.php');
    exit();
}

// Handle Check Out
if (isset($_POST['check_out'])) {
    $waktu_sekarang = date('H:i:s');
    $sql = "UPDATE absensi SET check_out = '$waktu_sekarang' 
            WHERE user_id = $user_id AND tanggal = '$today'";
    mysqli_query($conn, $sql);
    header('Location: dashboard.php');
    exit();
}

// Ambil riwayat absensi
$sql = "SELECT * FROM absensi WHERE user_id = $user_id ORDER BY tanggal DESC LIMIT 30";
$riwayat_result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan</title>
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
        .welcome {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .attendance-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .time-display {
            font-size: 2.5em;
            font-weight: bold;
            text-align: center;
            color: #2c3e50;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-success {
            background: #2ecc71;
            color: white;
        }
        .btn-success:hover {
            background: #27ae60;
        }
        .btn:disabled {
            background: #95a5a6;
            cursor: not-allowed;
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
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-hadir { background: #d4edda; color: #155724; }
        .status-terlambat { background: #fff3cd; color: #856404; }
        .status-izin { background: #d1ecf1; color: #0c5460; }
        .status-cuti { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Sistem Absensi</h2>
            <ul>
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <div style="margin-top: 50px; padding: 20px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                <p>Selamat datang,</p>
                <h3><?php echo $_SESSION['nama']; ?></h3>
                <p style="font-size: 0.9em; opacity: 0.8;"><?php echo $_SESSION['email']; ?></p>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="welcome">
                    <div>
                        <h1>Absensi Hari Ini</h1>
                        <p><?php echo date('l, d F Y'); ?></p>
                    </div>
                    <div id="live-clock" style="font-size: 1.5em; font-weight: bold;"></div>
                </div>
            </div>
            
            <!-- Absensi Card -->
            <div class="card">
                <h3>Absensi Hari Ini</h3>
                <div class="attendance-info">
                    <div>
                        <p style="margin-bottom: 10px;">Check In</p>
                        <div class="time-display">
                            <?php echo $absensi_hari_ini ? date('H:i', strtotime($absensi_hari_ini['check_in'])) : '--:--'; ?>
                        </div>
                    </div>
                    <div>
                        <p style="margin-bottom: 10px;">Check Out</p>
                        <div class="time-display">
                            <?php echo $absensi_hari_ini && $absensi_hari_ini['check_out'] ? date('H:i', strtotime($absensi_hari_ini['check_out'])) : '--:--'; ?>
                        </div>
                    </div>
                </div>
                
                <div class="btn-group">
                    <form method="POST">
                        <?php if (!$absensi_hari_ini): ?>
                            <button type="submit" name="check_in" class="btn btn-primary">Check In</button>
                        <?php endif; ?>
                        
                        <?php if ($absensi_hari_ini && !$absensi_hari_ini['check_out']): ?>
                            <button type="submit" name="check_out" class="btn btn-success">Check Out</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            
            <!-- Riwayat Absensi -->
            <div class="card">
                <h3>Riwayat Absensi Saya</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($riwayat_result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($riwayat_result)): ?>
                                <tr>
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
                                <td colspan="4" style="text-align: center;">Belum ada riwayat absensi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>