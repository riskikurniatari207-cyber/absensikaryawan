<?php
session_start();
require_once '../config/database.php';

// Jika sudah login sebagai admin, redirect ke dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin') {
    header('Location: dashboard.php');
    exit();
}

// Jika belum login, redirect ke halaman login admin
header('Location: login.php');
exit();
?>