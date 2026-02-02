<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if (isset($page_title)) {
            echo htmlspecialchars($page_title) . " - ";
        }
        ?>Sistem Absensi Karyawan
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }
        
        .logo-icon {
            font-size: 1.8rem;
        }
        
        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        
        .logo-text p {
            font-size: 0.8rem;
            opacity: 0.8;
            margin: 0;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .nav-link i {
            font-size: 1.1rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
        }
        
        .user-avatar {
            width: 30px;
            height: 30px;
            background: white;
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .user-details h4 {
            margin: 0;
            font-size: 0.9rem;
        }
        
        .user-details p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.8;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 30px 0;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .breadcrumb ul {
            list-style: none;
            display: flex;
            gap: 10px;
        }
        
        .breadcrumb li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .breadcrumb li:not(:last-child)::after {
            content: "›";
            color: #999;
        }
        
        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary-color);
        }
        
        .page-header h1 {
            color: var(--secondary-color);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        
        .page-header p {
            color: #666;
            margin: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .user-info {
                order: -1;
                width: 100%;
                justify-content: center;
            }
            
            .main-content {
                padding: 20px 0;
            }
        }
    </style>
</head>
<body>
    <?php if (isset($show_navbar) && $show_navbar): ?>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="<?php echo isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ? 'admin/dashboard.php' : 'karyawan/dashboard.php'; ?>" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="logo-text">
                    <h1>Sistem Absensi</h1>
                    <p>Manajemen Karyawan</p>
                </div>
            </a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="nav-links">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <h4><?php echo htmlspecialchars($_SESSION['nama']); ?></h4>
                        <p><?php echo ucfirst($_SESSION['role']); ?></p>
                    </div>
                </div>
                
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="admin/dashboard.php" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="admin/karyawan.php" class="nav-link">
                        <i class="fas fa-users"></i> Karyawan
                    </a>
                    <a href="admin/absensi.php" class="nav-link">
                        <i class="fas fa-calendar-check"></i> Absensi
                    </a>
                <?php else: ?>
                    <a href="karyawan/dashboard.php" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                <?php endif; ?>
                
                <a href="logout.php" class="nav-link" onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>
    
    <div class="container main-content">
        <?php if (isset($show_breadcrumb) && $show_breadcrumb): ?>
        <div class="breadcrumb">
            <ul>
                <li><a href="<?php echo isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ? 'admin/dashboard.php' : 'karyawan/dashboard.php'; ?>">Dashboard</a></li>
                <?php if (isset($breadcrumb_items)): ?>
                    <?php foreach ($breadcrumb_items as $item): ?>
                        <li>
                            <?php if (isset($item['link'])): ?>
                                <a href="<?php echo $item['link']; ?>"><?php echo $item['text']; ?></a>
                            <?php else: ?>
                                <span><?php echo $item['text']; ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if (isset($page_header) && $page_header): ?>
        <div class="page-header">
            <h1><?php echo $page_header['title']; ?></h1>
            <?php if (isset($page_header['description'])): ?>
                <p><?php echo $page_header['description']; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>