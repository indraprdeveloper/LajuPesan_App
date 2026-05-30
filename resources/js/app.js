import './bootstrap';

// Mobile Navigation Improvements for Filament Sidebar
function applyMobileNavigationImprovements() {
    injectMobileCloseButton();
    initSwipeToClose();
}

function injectMobileCloseButton() {
    const sidebarHeader = document.querySelector('.fi-sidebar-header');
    if (!sidebarHeader) return;

    // Check if the mobile close button already exists
    if (sidebarHeader.querySelector('.fi-sidebar-mobile-close-btn')) return;

    // Create the button
    const closeBtn = document.createElement('button');
    closeBtn.className = 'fi-sidebar-mobile-close-btn lg:hidden ms-auto flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors focus:outline-none';
    closeBtn.setAttribute('aria-label', 'Close sidebar');
    
    // Set SVG icon (Heroicon X)
    closeBtn.innerHTML = `
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    `;

    // Click handler to close sidebar
    closeBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (window.Alpine) {
            window.Alpine.store('sidebar').close();
        } else {
            // Fallback: Click the overlay
            const overlay = document.querySelector('.fi-sidebar-close-overlay');
            if (overlay) overlay.click();
        }
    });

    // Append to sidebar header
    sidebarHeader.appendChild(closeBtn);
}

function initSwipeToClose() {
    const sidebar = document.querySelector('.fi-sidebar');
    if (!sidebar) return;

    // Prevent duplicate listeners
    if (sidebar.dataset.swipeInitialized) return;
    sidebar.dataset.swipeInitialized = 'true';

    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    sidebar.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    sidebar.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const diffX = touchEndX - touchStartX;
        const diffY = touchEndY - touchStartY;

        // We want a swipe to the left (negative diffX)
        // Ensure vertical movement is minimal (to not trigger when scrolling down/up)
        const thresholdX = -60; // Swiped at least 60px to the left
        const thresholdY = 40;  // Vertical limit

        if (diffX < thresholdX && Math.abs(diffY) < thresholdY) {
            if (window.Alpine) {
                window.Alpine.store('sidebar').close();
            } else {
                const overlay = document.querySelector('.fi-sidebar-close-overlay');
                if (overlay) overlay.click();
            }
        }
    }
}

// Run immediately and on relevant load events
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', applyMobileNavigationImprovements);
} else {
    applyMobileNavigationImprovements();
}

document.addEventListener('livewire:navigated', applyMobileNavigationImprovements);
document.addEventListener('livewire:load', applyMobileNavigationImprovements);

// Use MutationObserver to handle dynamic DOM replacement/hydration by Livewire
const observer = new MutationObserver((mutations) => {
    const sidebarHeader = document.querySelector('.fi-sidebar-header');
    if (sidebarHeader && !sidebarHeader.querySelector('.fi-sidebar-mobile-close-btn')) {
        applyMobileNavigationImprovements();
    }
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

// === Notifikasi Suara Transaksi ===
window.addEventListener('play-transaction-sound', (event) => {
    const type = event.detail.type;
    let audioFile = '';

    if (type === 'non-cash-success') {
        audioFile = '/sounds/pembayaran non tunai status berhasil.mp3';
    } else if (type === 'cash-pending') {
        audioFile = '/sounds/pembayaran tunai transaksi masuk atau pending.mp3';
    }

    if (audioFile) {
        const audio = new Audio(audioFile);
        audio.play().catch(error => {
            console.log('Autoplay ditunda oleh browser hingga pengguna berinteraksi dengan halaman.', error);
        });
    }
});
