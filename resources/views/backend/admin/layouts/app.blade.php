<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ isset($title) ? $title . ' - ' : '' }}
        {{ site_name() }}
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}"> --}}
    @fluxAppearance
    <style>
        @keyframes bounce-dot {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        :root {
            --livewire-progress-bar-color: var(--color-secondary-500) !important;
        }
    </style>
    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('notify', (event) => {
                showAlert(event.type, event.message);
            });
        });
    </script>
    @stack('styles')
</head>

<body x-data="dashboardData();" class="h-full max-h-screen antialiased animated-bg">
    <div x-show="mobile_menu_open && !desktop" x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-all duration-300 ease-in" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="closeMobileMenu()" class="fixed inset-0 z-40 glass-card lg:hidden">
    </div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <livewire:backend.admin.partials.sidebar :active="$pageSlug" />


        <!-- Main Content -->
        <div class="flex-1 flex flex-col custom-scrollbar overflow-y-auto">
            <!-- Header -->

            {{-- <x-admin::header :breadcrumb="$breadcrumb" /> --}}
            <livewire:backend.admin.partials.header :breadcrumb="$breadcrumb" />

            <!-- Main Content Area -->
            <main class="flex-1 p-4 lg:p-6">
                <div class="mx-auto space-y-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <div id="navigation-loader" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-bg-primary/50 backdrop-blur-md">
        <div class="flex space-x-2">
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.8s;"></div>
            <div class="w-4 h-4 rounded-full bg-accent-foreground animate-[bounce-dot_1.2s_infinite]"
                style="animation-delay: -0.4s;"></div>
            <div class="w-4 h-4 rounded-full bg-accent animate-[bounce-dot_1.2s_infinite]"></div>
        </div>
    </div>

    @fluxScripts
    <script>
        function dashboardData() {
            return {
                // Responsive state
                desktop: window.innerWidth >= 1024,
                mobile: window.innerWidth <= 768,
                tablet: window.innerWidth < 1024,
                sidebar_expanded: window.innerWidth >= 1024,
                mobile_menu_open: false,

                // App state
                searchQuery: '',
                // darkMode: true,
                showNotifications: false,

                stats: {
                    users: 12384,
                    revenue: 48392,
                    orders: 2847,
                    activeUsers: 847
                },

                notifications: [{
                        id: 1,
                        title: 'System Update',
                        message: 'System maintenance scheduled for tonight',
                        time: '5 minutes ago',
                        icon: 'settings',
                        iconBg: 'bg-blue-500/20',
                        iconColor: 'text-blue-400'
                    },
                    {
                        id: 2,
                        title: 'New Comment',
                        message: 'Someone commented on your post',
                        time: '10 minutes ago',
                        icon: 'message-circle',
                        iconBg: 'bg-green-500/20',
                        iconColor: 'text-green-400'
                    },
                    {
                        id: 3,
                        title: 'Security Alert',
                        message: 'New login from unknown device',
                        time: '1 hour ago',
                        icon: 'shield-alert',
                        iconBg: 'bg-red-500/20',
                        iconColor: 'text-red-400'
                    }
                ],

                // Methods
                init() {
                    this.handleResize();
                    this.initChart();
                    window.addEventListener('resize', () => this.handleResize());

                    // Keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                            e.preventDefault();
                            this.focusSearch();
                        }
                    });
                },

                handleResize() {
                    this.desktop = window.innerWidth >= 1024;
                    if (this.desktop) {
                        this.mobile_menu_open = false;
                        this.sidebar_expanded = true;
                    } else {
                        this.sidebar_expanded = false;
                    }
                },

                toggleSidebar() {
                    if (this.desktop) {
                        this.sidebar_expanded = !this.sidebar_expanded;
                    } else {
                        this.mobile_menu_open = !this.mobile_menu_open;
                    }
                },

                closeMobileMenu() {
                    if (!this.desktop) {
                        this.mobile_menu_open = false;
                    }
                },

                toggleNotifications() {
                    this.showNotifications = !this.showNotifications;
                },

                initChart() {
                    this.$nextTick(() => {
                        const canvas = document.getElementById('revenueChart');
                        if (!canvas) return;

                        const ctx = canvas.getContext('2d');

                        // Destroy existing chart if it exists
                        if (window.revenueChart instanceof Chart) {
                            window.revenueChart.destroy();
                        }

                        // Create gradient
                        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)');
                        gradient.addColorStop(1, 'rgba(118, 75, 162, 0.1)');

                        window.revenueChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                    'Oct', 'Nov', 'Dec'
                                ],
                                datasets: [{
                                    label: 'Revenue',
                                    data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000,
                                        32000, 38000, 42000, 48000
                                    ],
                                    borderColor: '#667eea',
                                    backgroundColor: gradient,
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#667eea',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 6,
                                    pointHoverRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: 'rgba(255, 255, 255, 0.6)'
                                        }
                                    },
                                    y: {
                                        grid: {
                                            color: 'rgba(255, 255, 255, 0.1)'
                                        },
                                        ticks: {
                                            color: 'rgba(255, 255, 255, 0.6)',
                                            callback: function(value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                },
                                elements: {
                                    point: {
                                        hoverBackgroundColor: '#ffffff'
                                    }
                                }
                            }
                        });
                    });
                }
            }
        }

        // Smooth scrolling for anchor links
        document.addEventListener('click', function(e) {
            if (e.target.matches('a[href^="#"]')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
        document.addEventListener('livewire:navigate', (event) => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });
        document.addEventListener('livewire:navigating', () => {
            document.getElementById('navigation-loader').classList.remove('hidden');
        });
        document.addEventListener('livewire:navigated', () => {
            document.getElementById('navigation-loader').classList.add('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>
