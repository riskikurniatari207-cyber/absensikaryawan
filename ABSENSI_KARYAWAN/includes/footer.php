    </div> <!-- Close main-content -->
    
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>Sistem Absensi Karyawan</h3>
                    </div>
                    <p class="footer-description">
                        Sistem manajemen absensi online untuk meningkatkan produktivitas dan efisiensi perusahaan.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Menu Utama</h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] == 'admin'): ?>
                                <li><a href="admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</a></li>
                                <li><a href="admin/karyawan.php"><i class="fas fa-users"></i> Kelola Karyawan</a></li>
                                <li><a href="admin/absensi.php"><i class="fas fa-calendar-check"></i> Data Absensi</a></li>
                            <?php else: ?>
                                <li><a href="karyawan/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard Karyawan</a></li>
                            <?php endif; ?>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        <?php else: ?>
                            <li><a href="index.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Kontak Kami</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Jakarta</li>
                        <li><i class="fas fa-phone"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-envelope"></i> info@company.com</li>
                        <li><i class="fas fa-clock"></i> Senin - Jumat: 08:00 - 17:00</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Sistem Absensi Karyawan. Semua hak dilindungi.</p>
                <p>Versi 1.0.0 | Dibuat dengan <i class="fas fa-heart" style="color: #e74c3c;"></i></p>
            </div>
        </div>
    </footer>
    
    <style>
        .footer {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #1a252f 100%);
            color: white;
            padding: 50px 0 20px;
            margin-top: 50px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-section h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-section h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background: var(--primary-color);
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .footer-logo i {
            font-size: 2rem;
            color: var(--primary-color);
        }
        
        .footer-logo h3 {
            font-size: 1.3rem;
            margin: 0;
        }
        
        .footer-description {
            color: #bdc3c7;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .footer-social {
            display: flex;
            gap: 15px;
        }
        
        .social-icon {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
        }
        
        .footer-contact {
            list-style: none;
        }
        
        .footer-contact li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #bdc3c7;
        }
        
        .footer-contact i {
            color: var(--primary-color);
            width: 20px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            text-align: center;
            color: #bdc3c7;
            font-size: 0.9rem;
        }
        
        .footer-bottom p {
            margin: 5px 0;
        }
        
        @media (max-width: 768px) {
            .footer {
                padding: 30px 0 20px;
            }
            
            .footer-content {
                gap: 30px;
            }
        }
    </style>
    
    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
    <script>
        // Scroll to top button
        const scrollToTopBtn = document.createElement('button');
        scrollToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
        scrollToTopBtn.className = 'scroll-to-top';
        document.body.appendChild(scrollToTopBtn);
        
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.style.opacity = '1';
                scrollToTopBtn.style.visibility = 'visible';
            } else {
                scrollToTopBtn.style.opacity = '0';
                scrollToTopBtn.style.visibility = 'hidden';
            }
        });
        
        // Style for scroll to top button
        const style = document.createElement('style');
        style.textContent = `
            .scroll-to-top {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 50px;
                height: 50px;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                font-size: 1.2rem;
                box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
                transition: all 0.3s;
                opacity: 0;
                visibility: hidden;
                z-index: 1000;
            }
            
            .scroll-to-top:hover {
                background: #2980b9;
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            }
            
            @media (max-width: 768px) {
                .scroll-to-top {
                    bottom: 20px;
                    right: 20px;
                    width: 45px;
                    height: 45px;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Show alerts with animation
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>