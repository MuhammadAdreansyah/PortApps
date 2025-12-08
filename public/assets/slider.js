// ============================================
// IMAGE SLIDER CONFIGURATION
// ============================================
// CARA PENGGUNAAN:
// 1. Simpan gambar Anda di folder: assets/image/
// 2. Tambahkan nama file gambar ke array 'images' di bawah ini
// 3. Contoh: 'dashboard-1.png', 'dashboard-2.jpg', 'crm-view.png'
// ============================================

const sliderConfig = {
    // Daftar gambar yang akan ditampilkan di slider
    // Sesuaikan dengan nama file gambar Anda di folder assets/image/
    images: [
        'assets/image/dashboard-1.png',
        'assets/image/dashboard-2.png',
        'assets/image/dashboard-3.png'
    ],
    
    // Interval pergantian slide otomatis (dalam milidetik)
    autoPlayInterval: 4000, // 4 detik
    
    // Aktifkan/nonaktifkan autoplay
    autoPlay: true
};

// ============================================
// SLIDER FUNCTIONALITY - NO NEED TO EDIT BELOW
// ============================================
let currentSlide = 0;
let autoPlayTimer = null;

function initSlider() {
    const slider = document.getElementById('slider');
    const dotsContainer = document.getElementById('slider-dots');
    
    // Check if slider elements exist
    if (!slider || !dotsContainer) {
        console.warn('Slider elements not found. Slider will not initialize.');
        return;
    }

    // Clear existing content
    slider.innerHTML = '';
    dotsContainer.innerHTML = '';

    // Create slides
    sliderConfig.images.forEach((imagePath, index) => {
        // Create slide
        const slide = document.createElement('div');
        slide.className = 'slider-slide';
        
        const img = document.createElement('img');
        img.src = imagePath;
        img.alt = `Dashboard view ${index + 1}`;
        img.loading = 'lazy';
        
        // Add loading skeleton
        img.onload = function() {
            this.classList.remove('loading-skeleton');
        };
        img.className = 'loading-skeleton';
        
        // Error handling - show placeholder if image fails to load
        img.onerror = function() {
            console.warn(`Failed to load image: ${imagePath}`);
            this.src = `https://placehold.co/800x500/6366f1/ffffff?text=Dashboard+${index + 1}`;
            this.classList.remove('loading-skeleton');
        };
        
        slide.appendChild(img);
        slider.appendChild(slide);

        // Create dot
        const dot = document.createElement('button');
        dot.className = `slider-dot ${index === 0 ? 'active' : ''}`;
        dot.onclick = () => goToSlide(index);
        dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
        dotsContainer.appendChild(dot);
    });

    // Start autoplay if enabled
    if (sliderConfig.autoPlay) {
        startAutoPlay();
    }
}

function updateSlider() {
    const slider = document.getElementById('slider');
    const dots = document.querySelectorAll('.slider-dot');
    
    if (!slider) return;

    // Move slider
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;

    // Update dots
    dots.forEach((dot, index) => {
        if (index === currentSlide) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

function changeSlide(direction) {
    const totalSlides = sliderConfig.images.length;
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
    updateSlider();
    resetAutoPlay();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
    resetAutoPlay();
}

function startAutoPlay() {
    if (!sliderConfig.autoPlay) return;
    
    // Clear any existing timer
    if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
    }
    
    autoPlayTimer = setInterval(() => {
        changeSlide(1);
    }, sliderConfig.autoPlayInterval);
}

function resetAutoPlay() {
    if (!sliderConfig.autoPlay) return;
    
    clearInterval(autoPlayTimer);
    startAutoPlay();
}

// Initialize slider when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the slider
    initSlider();

    // Keyboard navigation for slider
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            changeSlide(-1);
        } else if (e.key === 'ArrowRight') {
            changeSlide(1);
        }
    });

    // Pause autoplay on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', () => {
            if (autoPlayTimer) {
                clearInterval(autoPlayTimer);
            }
        });
        
        sliderContainer.addEventListener('mouseleave', () => {
            if (sliderConfig.autoPlay) {
                startAutoPlay();
            }
        });
    }
});