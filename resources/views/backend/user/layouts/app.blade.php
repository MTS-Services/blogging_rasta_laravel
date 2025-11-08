<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @fluxAppearance

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false, mobileMenuOpen: false }" class="h-full max-h-screen antialiased bg-bg-secondary">

    <div class="flex flex-col h-screen">
        @if (
            !(request()->routeIs('login') ||
                request()->routeIs('register') ||
                request()->routeIs('password.request') ||
                request()->routeIs('password.reset') ||
                request()->routeIs('verify-reset-otp') ||
                request()->routeIs('verification.notice') ||
                request()->routeIs('verify-otp') ||
                request()->routeIs('verification.verify') ||
                request()->routeIs('two-factor.*') ||
                request()->routeIs('two-factor.login') ||
                request()->routeIs('two-factor.login.store') ||
                request()->routeIs('admin.*')
            ))
            <livewire:frontend.partials.header />
        @endif

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <livewire:backend.user.partials.sidebar :pageSlug="$pageSlug" />

            <!-- Main content -->
            <div class="flex-1 flex flex-col custom-scrollbar overflow-y-auto">
                <main class="flex-1 p-4 lg:p-6">
                    <div class="mx-auto space-y-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
        class="fixed inset-0 bg-bg-primary/60 z-40 lg:hidden transition-opacity"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    @fluxScripts

    <script>
        // Dashboard JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            initTooltips();

            // Handle table row clicks
            handleTableRowClicks();

            // Handle search functionality
            initSearchFunctionality();

            // Handle dropdown filters
            initDropdownFilters();
        });

        // Tooltips initialization
        function initTooltips() {
            const tooltipElements = document.querySelectorAll('[data-tooltip]');

            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    showTooltip(this);
                });

                element.addEventListener('mouseleave', function() {
                    hideTooltip();
                });
            });
        }

        function showTooltip(element) {
            const text = element.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = text;
            tooltip.id = 'active-tooltip';

            document.body.appendChild(tooltip);

            const rect = element.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
            tooltip.style.left = (rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)) + 'px';
        }

        function hideTooltip() {
            const tooltip = document.getElementById('active-tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        }

        // Table row click handlers
        function handleTableRowClicks() {
            const tableRows = document.querySelectorAll('.data-table tbody tr');

            tableRows.forEach(row => {
                row.style.cursor = 'pointer';

                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on a button or link
                    if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                        return;
                    }

                    const orderId = this.getAttribute('data-order-id');
                    if (orderId) {
                        window.location.href = `/orders/${orderId}`;
                    }
                });
            });
        }

        // Search functionality
        function initSearchFunctionality() {
            const searchInput = document.querySelector('.search-input');

            if (searchInput) {
                let searchTimeout;

                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);

                    searchTimeout = setTimeout(() => {
                        performSearch(e.target.value);
                    }, 300);
                });
            }
        }

        function performSearch(query) {
            console.log('Searching for:', query);
            // Implement your search logic here
        }

        // Dropdown filters
        function initDropdownFilters() {
            const filterDropdowns = document.querySelectorAll('.filter-dropdown');

            filterDropdowns.forEach(dropdown => {
                dropdown.addEventListener('change', function(e) {
                    applyFilter(this.name, this.value);
                });
            });
        }

        function applyFilter(filterName, filterValue) {
            console.log(`Applying filter: ${filterName} = ${filterValue}`);
            // Implement your filter logic here
        }

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }).format(date);
        }

        // Notification helper
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('show');
            }, 100);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification('Copied to clipboard!', 'success');
            }).catch(err => {
                console.error('Failed to copy:', err);
                showNotification('Failed to copy', 'error');
            });
        }

        // Confirm action
        function confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }

        // Export functions for global use
        window.dashboardUtils = {
            scrollToTop,
            formatCurrency,
            formatDate,
            showNotification,
            copyToClipboard,
            confirmAction
        };
    </script>

    @stack('scripts')
</body>

</html>
