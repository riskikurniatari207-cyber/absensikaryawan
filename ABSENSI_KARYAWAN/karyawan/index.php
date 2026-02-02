<?php
session_start();
require_once '../config/database.php';

// Jika sudah login sebagai karyawan, redirect ke dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'karyawan') {
    header('Location: dashboard.php');
    exit();
}

// Jika belum login, redirect ke halaman login karyawan
header('Location: login.php');
exit();
?>