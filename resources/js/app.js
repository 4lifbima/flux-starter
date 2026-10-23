/**
 * Flux-Inspired UI Lightweight JavaScript Support
 * Clean, reactive, no heavy frameworks, accessible.
 */

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

    // Close modal on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            window.closeConfirmModal();
        }
    });

    // Auto dismiss toasts after 4.5 seconds
    const toasts = document.querySelectorAll('.flux-toast');
    toasts.forEach((toast) => {
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
