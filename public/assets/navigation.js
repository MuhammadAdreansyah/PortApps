// ============================================
// SELLORA PAGE NAVIGATION SYSTEM
// SPA-Style Transition (No Page Refresh)
// ============================================

// Cache untuk menyimpan konten halaman yang sudah di-load
const pageCache = {};

async function navigateToPage(event, targetPage) {
    event.preventDefault();
    
    const formColumn = document.getElementById('formColumn');
    
    if (!formColumn) {
        // Fallback jika element tidak ditemukan
        window.location.href = targetPage;
        return;
    }
    
    // Determine transition direction based on page type
    let direction = 'left'; // default: slide to left (forward navigation)
    
    // If going back to login, slide right
    if (targetPage === 'index.html' || targetPage === 'login.html') {
        direction = 'right';
    }
    
    // Add slide-out animation
    if (direction === 'left') {
        formColumn.classList.add('page-slide-left');
    } else {
        formColumn.classList.add('page-slide-right');
    }
    
    // Wait for animation to complete
    setTimeout(async () => {
        try {
            // Fetch konten halaman baru
            let htmlContent;
            
            if (pageCache[targetPage]) {
                // Gunakan cache jika tersedia
                htmlContent = pageCache[targetPage];
            } else {
                // Fetch halaman baru
                const response = await fetch(targetPage);
                const fullHtml = await response.text();
                
                // Parse HTML untuk extract konten formColumn
                const parser = new DOMParser();
                const doc = parser.parseFromString(fullHtml, 'text/html');
                const newFormColumn = doc.getElementById('formColumn');
                
                if (newFormColumn) {
                    htmlContent = newFormColumn.innerHTML;
                    // Simpan ke cache
                    pageCache[targetPage] = htmlContent;
                } else {
                    // Fallback ke full page load jika struktur tidak sesuai
                    window.location.href = targetPage;
                    return;
                }
            }
            
            // Remove slide-out class
            formColumn.classList.remove('page-slide-left', 'page-slide-right');
            
            // Replace konten
            formColumn.innerHTML = htmlContent;
            
            // Update URL tanpa reload (history API)
            window.history.pushState({page: targetPage}, '', targetPage);
            
            // Add slide-in animation
            if (direction === 'left') {
                formColumn.classList.add('page-slide-in-right');
            } else {
                formColumn.classList.add('page-slide-in-left');
            }
            
            // Remove slide-in class after animation
            setTimeout(() => {
                formColumn.classList.remove('page-slide-in-right', 'page-slide-in-left');
            }, 500);
            
            // Re-attach event listeners untuk link di halaman baru
            attachNavigationListeners();
            
        } catch (error) {
            console.error('Navigation error:', error);
            // Fallback ke normal navigation jika ada error
            window.location.href = targetPage;
        }
    }, 500); // 500ms matches the CSS transition duration
}

// Function untuk attach event listeners ke semua navigation links
function attachNavigationListeners() {
    const formColumn = document.getElementById('formColumn');
    if (!formColumn) return;
    
    // Find all links with data-navigate attribute or onclick="navigateToPage"
    const links = formColumn.querySelectorAll('a[data-navigate], a[onclick*="navigateToPage"]');
    links.forEach(link => {
        // Remove inline onclick if exists
        link.removeAttribute('onclick');
        
        // Add event listener
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('http')) {
                navigateToPage(e, href);
            }
        });
    });
}

// Handle browser back/forward button
window.addEventListener('popstate', function(event) {
    if (event.state && event.state.page) {
        // Reload ke halaman yang sesuai saat back button
        window.location.href = event.state.page;
    }
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    const formColumn = document.getElementById('formColumn');
    
    if (!formColumn) return;
    
    // Attach event listeners ke semua navigation links
    attachNavigationListeners();
    
    // Set initial state untuk history
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    window.history.replaceState({page: currentPage}, '', currentPage);
});