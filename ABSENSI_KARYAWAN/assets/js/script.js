// ===== UTILITY FUNCTIONS =====

// Format date to Indonesian
function formatDateToIndonesian(dateString) {
    const date = new Date(dateString);
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    return date.toLocaleDateString('id-ID', options);
}

// Format time
function formatTime(timeString) {
    if (!timeString) return '--:--';
    const date = new Date(`2000-01-01T${timeString}`);
    return date.toLocaleTimeString('id-ID', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
}

// Calculate work duration
function calculateDuration(checkIn, checkOut) {
    if (!checkIn || !checkOut) return '--:--';
    
    const start = new Date(`2000-01-01T${checkIn}`);
    const end = new Date(`2000-01-01T${checkOut}`);
    const diff = end - start;
    
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    
    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
}

// ===== LIVE CLOCK =====
function initLiveClock(elementId) {
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });
        
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = timeString;
        }
    }
    
    updateClock();
    setInterval(updateClock, 1000);
}

// ===== FORM VALIDATION =====
function validateLoginForm() {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    
    if (!email || !password) return true;
    
    if (!email.value.trim()) {
        alert('Email harus diisi!');
        email.focus();
        return false;
    }
    
    if (!email.value.includes('@')) {
        alert('Email tidak valid!');
        email.focus();
        return false;
    }
    
    if (!password.value.trim()) {
        alert('Password harus diisi!');
        password.focus();
        return false;
    }
    
    return true;
}

function validateKaryawanForm() {
    const nama = document.getElementById('nama');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    
    if (!nama.value.trim()) {
        alert('Nama harus diisi!');
        nama.focus();
        return false;
    }
    
    if (!email.value.trim()) {
        alert('Email harus diisi!');
        email.focus();
        return false;
    }
    
    if (!email.value.includes('@')) {
        alert('Email tidak valid!');
        email.focus();
        return false;
    }
    
    if (!password.value.trim()) {
        alert('Password harus diisi!');
        password.focus();
        return false;
    }
    
    if (password.value.length < 6) {
        alert('Password minimal 6 karakter!');
        password.focus();
        return false;
    }
    
    return true;
}

// ===== MODAL FUNCTIONS =====
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// ===== CONFIRMATION DIALOGS =====
function confirmCheckIn() {
    return confirm('Apakah Anda yakin ingin Check In?');
}

function confirmCheckOut() {
    return confirm('Apakah Anda yakin ingin Check Out?');
}

function confirmDelete(action, itemName = 'data') {
    return confirm(`Apakah Anda yakin ingin menghapus ${itemName}?\nTindakan ini tidak dapat dibatalkan.`);
}

function confirmResetPassword() {
    return confirm('Reset password ke default (karyawan123)?');
}

// ===== AUTO-HIDE ALERTS =====
function initAutoHideAlerts() {
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
}

// ===== EXPORT FUNCTIONS =====
function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    if (!table) {
        alert('Tabel tidak ditemukan!');
        return;
    }
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const rowData = [];
        const cols = row.querySelectorAll('td, th');
        
        cols.forEach(col => {
            // Clean the data (remove HTML and trim)
            let data = col.textContent.trim();
            // Escape quotes and wrap in quotes if contains comma
            if (data.includes(',') || data.includes('"')) {
                data = '"' + data.replace(/"/g, '""') + '"';
            }
            rowData.push(data);
        });
        
        csv.push(rowData.join(','));
    });
    
    // Create and download file
    const csvContent = "data:text/csv;charset=utf-8," + csv.join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `${filename}_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// ===== AUTO REFRESH =====
function initAutoRefresh(seconds = 30) {
    // Auto refresh untuk halaman yang butuh update real-time
    if (window.location.pathname.includes('dashboard')) {
        setTimeout(() => {
            window.location.reload();
        }, seconds * 1000);
    }
}

// ===== INITIALIZE ON LOAD =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize live clock if element exists
    if (document.getElementById('liveClock')) {
        initLiveClock('liveClock');
    }
    
    // Initialize auto-hide alerts
    initAutoHideAlerts();
    
    // Initialize auto refresh for dashboard
    initAutoRefresh(30);
    
    // Add loading state to buttons on click
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = 'Loading...';
                submitBtn.disabled = true;
            }
        });
    });
});

// ===== KEYBOARD SHORTCUTS =====
document.addEventListener('keydown', function(event) {
    // Ctrl + E = Export
    if (event.ctrlKey && event.key === 'e') {
        event.preventDefault();
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) exportBtn.click();
    }
    
    // Ctrl + P = Print
    if (event.ctrlKey && event.key === 'p') {
        event.preventDefault();
        window.print();
    }
    
    // Esc = Close modal
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});

// ===== RESPONSIVE TABLE HELPER =====
function initResponsiveTables() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (table.offsetWidth > table.parentElement.offsetWidth) {
            table.parentElement.classList.add('table-scroll');
        }
    });
}

// Call on window resize
window.addEventListener('resize', initResponsiveTables);

// ===== COPY TO CLIPBOARD =====
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success message
        const toast = document.createElement('div');
        toast.textContent = 'Teks berhasil disalin!';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2ecc71;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2000);
    }).catch(err => {
        console.error('Gagal menyalin: ', err);
        alert('Gagal menyalin teks!');
    });
}