import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

/**
 * Flux-Inspired UI Lightweight JavaScript Support
 * Clean, reactive, no heavy frameworks, accessible.
 */

// Theme Controller Module
(function () {
    const STORAGE_PRIMARY = 'flux_theme_primary';
    const STORAGE_NEUTRAL = 'flux_theme_neutral';
    const STORAGE_MODE = 'flux_theme_mode';

    let currentPrimary = localStorage.getItem(STORAGE_PRIMARY) || 'orange'; // default to orange as in user mockup or base
    let currentNeutral = localStorage.getItem(STORAGE_NEUTRAL) || 'neutral';
    let currentMode = localStorage.getItem(STORAGE_MODE) || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

    function applyThemeToDOM(primary, neutral, mode) {
        document.documentElement.setAttribute('data-primary', primary);
        document.documentElement.setAttribute('data-neutral', neutral);

        if (mode === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        updateCustomizerUI(primary, neutral, mode);

        try {
            window.dispatchEvent(new CustomEvent('flux-theme-changed', {
                detail: { primary, neutral, mode }
            }));
        } catch (e) {}
    }

    function updateCustomizerUI(primary, neutral, mode) {
        // Highlight active primary button
        document.querySelectorAll('.theme-primary-btn').forEach((btn) => {
            const btnColor = btn.getAttribute('data-primary-btn');
            if (btnColor === primary) {
                btn.classList.add('ring-2', 'ring-primary-500', 'border-primary-500', 'bg-zinc-50', 'dark:bg-zinc-700/80');
            } else {
                btn.classList.remove('ring-2', 'ring-primary-500', 'border-primary-500', 'bg-zinc-50', 'dark:bg-zinc-700/80');
            }
        });

        // Highlight active neutral button
        document.querySelectorAll('.theme-neutral-btn').forEach((btn) => {
            const btnNeutral = btn.getAttribute('data-neutral-btn');
            const innerSquare = btn.querySelector('div');
            if (btnNeutral === neutral) {
                innerSquare?.classList.add('border-primary-500', 'ring-2', 'ring-primary-500/30');
                innerSquare?.classList.remove('border-zinc-200', 'dark:border-zinc-700');
            } else {
                innerSquare?.classList.remove('border-primary-500', 'ring-2', 'ring-primary-500/30');
                innerSquare?.classList.add('border-zinc-200', 'dark:border-zinc-700');
            }
        });

        // Highlight mode buttons
        const lightBtn = document.getElementById('theme-mode-light-btn');
        const darkBtn = document.getElementById('theme-mode-dark-btn');

        if (mode === 'dark') {
            darkBtn?.classList.add('bg-white', 'dark:bg-zinc-700', 'text-zinc-900', 'dark:text-white', 'shadow-xs');
            darkBtn?.classList.remove('text-zinc-500', 'dark:text-zinc-400');
            lightBtn?.classList.remove('bg-white', 'dark:bg-zinc-700', 'text-zinc-900', 'dark:text-white', 'shadow-xs');
            lightBtn?.classList.add('text-zinc-500', 'dark:text-zinc-400');
        } else {
            lightBtn?.classList.add('bg-white', 'dark:bg-zinc-700', 'text-zinc-900', 'dark:text-white', 'shadow-xs');
            lightBtn?.classList.remove('text-zinc-500', 'dark:text-zinc-400');
            darkBtn?.classList.remove('bg-white', 'dark:bg-zinc-700', 'text-zinc-900', 'dark:text-white', 'shadow-xs');
            darkBtn?.classList.add('text-zinc-500', 'dark:text-zinc-400');
        }
    }

    window.selectPrimaryTheme = function (primary) {
        currentPrimary = primary;
        localStorage.setItem(STORAGE_PRIMARY, currentPrimary);
        applyThemeToDOM(currentPrimary, currentNeutral, currentMode);
    };

    window.selectNeutralTheme = function (neutral) {
        currentNeutral = neutral;
        localStorage.setItem(STORAGE_NEUTRAL, currentNeutral);
        applyThemeToDOM(currentPrimary, currentNeutral, currentMode);
    };

    window.selectThemeMode = function (mode) {
        currentMode = mode;
        localStorage.setItem(STORAGE_MODE, currentMode);
        applyThemeToDOM(currentPrimary, currentNeutral, currentMode);
    };

    window.toggleDarkMode = function () {
        const isDark = document.documentElement.classList.contains('dark');
        const newMode = isDark ? 'light' : 'dark';
        window.selectThemeMode(newMode);
    };

    window.openThemeCustomizer = function () {
        const modal = document.getElementById('theme-customizer-modal');
        if (!modal) return;
        updateCustomizerUI(currentPrimary, currentNeutral, currentMode);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    window.closeThemeCustomizer = function () {
        const modal = document.getElementById('theme-customizer-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    window.applyAndSaveTheme = function () {
        localStorage.setItem(STORAGE_PRIMARY, currentPrimary);
        localStorage.setItem(STORAGE_NEUTRAL, currentNeutral);
        localStorage.setItem(STORAGE_MODE, currentMode);

        window.closeThemeCustomizer();

        // Spawn toast
        window.showToast?.('Tema berhasil disimpan dan diterapkan!', 'success');
    };

    // Apply on load
    applyThemeToDOM(currentPrimary, currentNeutral, currentMode);
})();

// Desktop Mini Sidebar Collapse Controller
window.toggleSidebarCollapse = function () {
    const isCollapsed = document.documentElement.classList.toggle('sidebar-collapsed');
    try {
        localStorage.setItem('flux_sidebar_collapsed', isCollapsed ? 'true' : 'false');
    } catch (e) {}

    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    if (toggleBtn) {
        toggleBtn.setAttribute('title', isCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar');
        toggleBtn.setAttribute('aria-label', isCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Sidebar Drawer
    const sidebar = document.getElementById('mobile-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('-translate-x-full');
        backdrop?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('-translate-x-full');
        backdrop?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    backdrop?.addEventListener('click', closeSidebar);

    // Profile Dropdown
    const profileDropdownBtn = document.getElementById('profile-dropdown-btn');
    const profileDropdownMenu = document.getElementById('profile-dropdown-menu');

    if (profileDropdownBtn && profileDropdownMenu) {
        profileDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!profileDropdownMenu.contains(e.target) && !profileDropdownBtn.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !profileDropdownMenu.classList.contains('hidden')) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
    }

    // Modal Confirmation Dialog Support
    window.openConfirmModal = function ({ title, message, action, method = 'DELETE', confirmText = 'Hapus' }) {
        const modal = document.getElementById('confirm-dialog-modal');
        const modalTitle = document.getElementById('confirm-dialog-title');
        const modalMessage = document.getElementById('confirm-dialog-message');
        const modalForm = document.getElementById('confirm-dialog-form');
        const modalConfirmBtn = document.getElementById('confirm-dialog-confirm-btn');

        if (!modal) return;

        if (modalTitle) modalTitle.textContent = title || 'Konfirmasi Tindakan';
        if (modalMessage) modalMessage.textContent = message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        if (modalConfirmBtn) modalConfirmBtn.textContent = confirmText;

        if (modalForm) {
            modalForm.action = action;
            let methodInput = modalForm.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.value = method;
            }
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    window.closeConfirmModal = function () {
        const modal = document.getElementById('confirm-dialog-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    // Close modals on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeConfirmModal();
            window.closeThemeCustomizer();
        }
    });

    // Dynamic Toast Creator
    window.showToast = function (message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const isSuccess = type === 'success';
        const toast = document.createElement('div');
        toast.className = `flux-toast pointer-events-auto flex items-start gap-3 p-4 bg-white dark:bg-zinc-900 border ${
            isSuccess ? 'border-zinc-200 dark:border-zinc-800' : 'border-rose-200 dark:border-rose-900/50'
        } rounded-xl shadow-lg shadow-zinc-950/5 text-zinc-900 dark:text-zinc-100 transition-all duration-300 transform translate-y-0 opacity-100`;

        const iconColor = isSuccess ? 'text-primary-600 dark:text-primary-400' : 'text-rose-600 dark:text-rose-400';
        const iconSvg = isSuccess
            ? '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'
            : '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 7.5h.008v.008H12v-.008Z" /></svg>';

        toast.innerHTML = `
            <div class="flex-shrink-0 mt-0.5 ${iconColor}">${iconSvg}</div>
            <div class="flex-1 text-sm font-medium leading-5">${message}</div>
            <button type="button" class="toast-close-btn flex-shrink-0 -mr-1 -mt-1 p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        `;

        container.appendChild(toast);

        const timer = setTimeout(() => {
            dismissToast(toast);
        }, 4500);

        toast.querySelector('.toast-close-btn')?.addEventListener('click', () => {
            clearTimeout(timer);
            dismissToast(toast);
        });
    };

    // Auto dismiss existing server-flashed toasts
    const existingToasts = document.querySelectorAll('.flux-toast');
    existingToasts.forEach((toast) => {
        const timer = setTimeout(() => {
            dismissToast(toast);
        }, 4500);

        const closeBtn = toast.querySelector('.toast-close-btn');
        closeBtn?.addEventListener('click', () => {
            clearTimeout(timer);
            dismissToast(toast);
        });
    });

    function dismissToast(toast) {
        toast.style.transition = 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-10px) scale(0.95)';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
});
