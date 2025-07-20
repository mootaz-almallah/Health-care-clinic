/**
 * Health Pulse Admin JavaScript
 * JavaScript for the Health Pulse admin panel
 */

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleSidebarBtn && sidebar) {
        toggleSidebarBtn.addEventListener('click', function() {
            sidebar.classList.add('show');
        });
    }
    
    if (closeSidebarBtn && sidebar) {
        closeSidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('show');
        });
    }
    
    // Close sidebar when clicking outside of it on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
            // If the click is outside the sidebar and not on the toggle button
            if (!sidebar.contains(event.target) && event.target !== toggleSidebarBtn) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // Enable tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    // Enable popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
    
    // Initialize datepickers if they exist
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d',
            allowInput: true
        });
    }
    
    // Confirmation modals
    const confirmForms = document.querySelectorAll('.confirm-form');
    confirmForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = form.dataset.confirmMessage || 'Are you sure you want to perform this action?';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // Data tables initialization
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search...",
                lengthMenu: "_MENU_ records per page",
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function() {
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_length select').addClass('form-select form-select-sm');
            }
        });
    }
    
    // File input customization
    const fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = this.files[0].name;
            const label = this.nextElementSibling;
            label.textContent = fileName;
        });
    });
    
    // Activate sidebar links based on current URL
    const currentLocation = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
    
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        if (href && currentLocation.includes(href) && href !== '/admin') {
            link.classList.add('active');
            
            // If the link is in a collapsed menu, expand it
            const parent = link.closest('.collapse');
            if (parent) {
                parent.classList.add('show');
                const controlElement = document.querySelector(`[data-bs-target="#${parent.id}"]`);
                if (controlElement) {
                    controlElement.classList.remove('collapsed');
                    controlElement.setAttribute('aria-expanded', 'true');
                }
            }
        }
    });
    
    // Initialize any dismissible alerts to auto-close after 5 seconds
    const autoCloseAlerts = document.querySelectorAll('.alert-dismissible:not(.alert-danger)');
    autoCloseAlerts.forEach(alert => {
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
    
    // Add animation to stat cards if they exist
    const statCards = document.querySelectorAll('.dashboard-stat-card');
    statCards.forEach((card, index) => {
        card.style.animation = `fadeIn 0.3s ease-in forwards ${index * 0.1}s`;
        card.style.opacity = '0';
    });
}); 