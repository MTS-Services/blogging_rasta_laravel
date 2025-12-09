<x-admin::app>
    <x-slot name="pageSlug">{{ __('video-manager') }}</x-slot>
    <x-slot name="title">{{ __('Video Management') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Video Management') }}</x-slot>
    <div class="container mx-auto px-4 py-8">

        {{-- Page Header with Action Buttons --}}
        <div class="mb-8 flex items-center justify-between flex-col sm:flex-row w-full sm:w-auto">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Video Management</h1>
                <p class="text-gray-600">Manage TikTok video downloads and cleanup expired videos</p>
            </div>
            <div class="flex gap-3 flex-col sm:flex-row w-full sm:w-auto">
                <x-ui.button onclick="openStatisticsModal()" variant="secondary" class="w-full py-2! sm:w-auto">
                    <flux:icon icon="chart-pie" class="w-4 h-4" />
                    See Statistics
                </x-ui.button>
                <x-ui.button onclick="openJobsModal()" variant="primary" class="w-full py-2! sm:w-auto">
                    <flux:icon icon="clock" class="w-4 h-4" />
                    Jobs Progress
                </x-ui.button>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Videos</p>
                        <p class="text-3xl font-bold text-gray-900" id="stat-total">
                            {{ $stats['total_videos'] ? number_format($stats['total_videos']) : 0 }}
                        </p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- With Local Storage --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Stored Locally</p>
                        <p class="text-3xl font-bold text-green-600" id="stat-local">
                            {{ $stats['with_local_storage'] ? number_format($stats['with_local_storage']) : 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['storage_percentage'] ?? 0 }}%</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Without Local Storage --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Missing Local</p>
                        <p class="text-3xl font-bold text-yellow-600" id="stat-missing">
                            {{ $stats['without_local_storage'] ? number_format($stats['without_local_storage']) : 0 }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Storage Size --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Storage Used</p>
                        <p class="text-3xl font-bold text-purple-600" id="stat-storage">
                            {{ isset($stats['storage_size_mb']) ? number_format($stats['storage_size_mb'] / 1024, 2) : '0' }}
                            GB
                        </p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- Redownload Missing Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start gap-4">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Redownload Missing Videos</h3>
                        <p class="text-sm text-gray-600 mb-4">Download videos that don't have local storage. This helps
                            recover videos with expired CDN URLs.</p>

                        <div class="flex items-center gap-3 mb-4  flex-col sm:flex-row w-full sm:w-auto">
                            <div class="w-full">
                                <label class="text-xs text-gray-600">Limit</label>
                                <input type="number" id="redownload-limit" value="50" min="1" max="500"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                <strong><small>Max Limit: 500</small></strong>
                            </div>
                            <div class="flex items-center w-full">
                                <input type="checkbox" id="redownload-force" class="mr-2">
                                <label for="redownload-force" class="text-sm text-gray-600">Force redownload
                                    all</label>
                            </div>
                        </div>

                        <x-ui.button onclick="redownloadMissing()" variant="secondary"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="btn-redownload">
                            <span class="btn-text">Start Redownload</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Cleanup Expired Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start gap-4">
                    <div class="bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cleanup Expired Videos</h3>
                        <p class="text-sm text-gray-600 mb-4">Check for videos with expired CDN URLs and deactivate or
                            delete them.</p>

                        <div class="flex items-center gap-3 mb-4  flex-col sm:flex-row w-full sm:w-auto">
                            <div class="w-full">
                                <label class="text-xs text-gray-600">Older than (days)</label>
                                <input type="number" id="cleanup-days" value="7" min="1"
                                    max="365"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div class="flex items-center w-full">
                                <input type="checkbox" id="cleanup-delete" class="mr-2">
                                <label for="cleanup-delete" class="text-sm text-gray-600">Delete inactive</label>
                            </div>
                        </div>

                        <x-ui.button onclick="cleanupExpired()" variant="primary"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="btn-cleanup">
                            <span class="btn-text">Start Cleanup</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Verify and Fix Broken Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start gap-4">
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Verify & Fix Broken Videos</h3>
                        <p class="text-sm text-gray-600 mb-4">Check if local video files exist and attempt to fix
                            broken references.</p>

                        <div class="mb-4 w-full">
                            <label class="text-xs text-gray-600">Check limit</label>
                            <input type="number" id="verify-limit" value="100" min="1" max="500"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            <strong><small>Max Limit: 500</small></strong>
                        </div>

                        <x-ui.button onclick="verifyAndFix()" variant="secondary"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="btn-verify">
                            <span class="btn-text">Verify & Fix</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>

            {{-- Delete Old Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start gap-4">
                    <div class="bg-orange-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Old Videos</h3>
                        <p class="text-sm text-gray-600 mb-4">Free up storage space by deleting inactive videos older
                            than specified days.</p>

                        <div class="flex items-center gap-3 mb-4 flex-col sm:flex-row w-full sm:w-auto">
                            <div class="w-full">
                                <label class="text-xs text-gray-600">Older than (days)</label>
                                <input type="number" id="delete-days" value="90" min="30" max="365"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div class="w-full">
                                <label class="text-xs text-gray-600">Limit</label>
                                <input type="number" id="delete-limit" value="100" min="1"
                                    max="500"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                                <strong><small>Max Limit: 500</small></strong>
                            </div>
                        </div>

                        <x-ui.button onclick="deleteOld()" variant="primary"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="btn-delete">
                            <span class="btn-text">Delete Old Videos</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Results Section --}}
        <div id="results-section" class="hidden bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Results</h3>
            <div id="results-content" class="text-sm"></div>
        </div>

        {{-- Statistics Modal --}}
        <div id="statistics-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Detailed Statistics</h3>
                    <button onclick="closeStatisticsModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="statistics-modal-content" class="mt-4">
                    <div class="flex items-center justify-center py-8">
                        <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="ml-2 text-gray-600">Loading statistics...</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jobs Progress Modal --}}
        <div id="jobs-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-900">Running Jobs Progress</h3>
                    <div class="flex items-center gap-3">
                        <button onclick="refreshJobsProgress()"
                            class="text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <span class="text-sm">Refresh</span>
                        </button>
                        <button onclick="closeJobsModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="jobs-modal-content" class="mt-4">
                    <div class="flex items-center justify-center py-8">
                        <svg class="animate-spin h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="ml-2 text-gray-600">Loading jobs...</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            // Store active job IDs
            let activeJobs = [];

            // Show notification
            function showNotification(message, type = 'success') {
                const colors = {
                    success: 'bg-green-500',
                    error: 'bg-red-500',
                    info: 'bg-blue-500',
                    warning: 'bg-yellow-500'
                };

                const notification = document.createElement('div');
                notification.className =
                    `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            }

            // Show/hide loading state
            function setButtonLoading(buttonId, isLoading) {
                const button = document.getElementById(buttonId);
                const textSpan = button.querySelector('.btn-text');
                const loadingSpan = button.querySelector('.btn-loading');

                if (isLoading) {
                    button.disabled = true;
                    textSpan.classList.add('hidden');
                    loadingSpan.classList.remove('hidden');
                } else {
                    button.disabled = false;
                    textSpan.classList.remove('hidden');
                    loadingSpan.classList.add('hidden');
                }
            }

            // Show results
            function showResults(message, data = null) {
                const section = document.getElementById('results-section');
                const content = document.getElementById('results-content');

                let html = `<p class="text-green-600 font-medium mb-3">${message}</p>`;

                if (data) {
                    html += '<div class="bg-gray-50 rounded p-4">';
                    html += '<dl class="grid grid-cols-2 gap-2 text-sm">';

                    for (const [key, value] of Object.entries(data)) {
                        if (typeof value !== 'object') {
                            const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                            html += `<dt class="text-gray-600">${label}:</dt><dd class="font-semibold">${value}</dd>`;
                        }
                    }

                    html += '</dl></div>';
                }

                content.innerHTML = html;
                section.classList.remove('hidden');

                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            // Modal functions
            function openStatisticsModal() {
                document.getElementById('statistics-modal').classList.remove('hidden');
                loadDetailedStatistics();
            }

            function closeStatisticsModal() {
                document.getElementById('statistics-modal').classList.add('hidden');
            }

            function openJobsModal() {
                document.getElementById('jobs-modal').classList.remove('hidden');
                loadJobsProgress();
            }

            function closeJobsModal() {
                document.getElementById('jobs-modal').classList.add('hidden');
            }

            // Load detailed statistics
            async function loadDetailedStatistics() {
                try {
                    const response = await fetch('{{ route('admin.vm.statistics') }}');
                    const result = await response.json();

                    const content = document.getElementById('statistics-modal-content');

                    if (result.success) {
                        const stats = result.data;
                        content.innerHTML = `
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold text-blue-900 mb-4">Video Storage</h4>
                                    <dl class="space-y-3">
                                        <div class="flex justify-between">
                                            <dt class="text-blue-700">Total Videos:</dt>
                                            <dd class="font-bold text-blue-900">${stats.total_videos || 0}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-blue-700">With Local Storage:</dt>
                                            <dd class="font-bold text-green-600">${stats.with_local_storage || 0}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-blue-700">Missing Local Storage:</dt>
                                            <dd class="font-bold text-yellow-600">${stats.without_local_storage || 0}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-blue-700">Storage Percentage:</dt>
                                            <dd class="font-bold text-blue-900">${stats.storage_percentage || 0}%</dd>
                                        </div>
                                    </dl>
                                </div>

                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold text-purple-900 mb-4">Storage Details</h4>
                                    <dl class="space-y-3">
                                        <div class="flex justify-between">
                                            <dt class="text-purple-700">Total Size:</dt>
                                            <dd class="font-bold text-purple-900">${((stats.storage_size_mb/1024 || 0)).toFixed(2)} GB</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-purple-700">Total Size (GB):</dt>
                                            <dd class="font-bold text-purple-900">${((stats.storage_size_mb/1024 || 0)).toFixed(2)} GB</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-purple-700">Average Size:</dt>
                                            <dd class="font-bold text-purple-900">${stats.with_local_storage > 0 ? ((stats.storage_size_mb || 0) / stats.with_local_storage).toFixed(2) : 0} MB</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Quick Actions</h4>
                                <div class="flex gap-3">
                                    <x-ui.button variant="secondary" onclick="refreshStatistics(); closeStatisticsModal();"
                                        class="w-full py-2! ">
                                        Refresh Main Dashboard
                                    </x-ui.button>
                                    <x-ui.button variant="primary" onclick="closeStatisticsModal();"
                                        class="w-full py-2! ">
                                        Close
                                    </x-ui.button>
                                </div>
                            </div>
                        `;
                    } else {
                        content.innerHTML = `
                            <div class="text-center py-8 text-red-600">
                                <p>Failed to load statistics</p>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Error loading statistics:', error);
                    document.getElementById('statistics-modal-content').innerHTML = `
                        <div class="text-center py-8 text-red-600">
                            <p>Error loading statistics: ${error.message}</p>
                        </div>
                    `;
                }
            }

            // Load jobs progress
            async function loadJobsProgress() {
                const content = document.getElementById('jobs-modal-content');

                if (activeJobs.length === 0) {
                    content.innerHTML = `
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No active jobs</h3>
                            <p class="mt-1 text-sm text-gray-500">Start a job to see its progress here</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="space-y-4">';

                for (const job of activeJobs) {
                    try {
                        const response = await fetch(
                            `{{ route('admin.vm.job-progress') }}?job_id=${job.id}&type=${job.type}`);
                        const result = await response.json();

                        if (result.success) {
                            const progress = result.data;
                            const isComplete = progress.completed;
                            const progressPercent = progress.progress || 0;

                            const typeColors = {
                                redownload: {
                                    bg: 'bg-blue-50',
                                    border: 'border-blue-200',
                                    text: 'text-blue-900',
                                    bar: 'bg-blue-600'
                                },
                                cleanup: {
                                    bg: 'bg-red-50',
                                    border: 'border-red-200',
                                    text: 'text-red-900',
                                    bar: 'bg-red-600'
                                },
                                verify: {
                                    bg: 'bg-green-50',
                                    border: 'border-green-200',
                                    text: 'text-green-900',
                                    bar: 'bg-green-600'
                                },
                                delete: {
                                    bg: 'bg-orange-50',
                                    border: 'border-orange-200',
                                    text: 'text-orange-900',
                                    bar: 'bg-orange-600'
                                }
                            };

                            const colors = typeColors[job.type] || typeColors.redownload;

                            html += `
                                <div class="${colors.bg} border ${colors.border} rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold ${colors.text}">${job.type.charAt(0).toUpperCase() + job.type.slice(1)} Job</span>
                                            ${isComplete ?
                                                '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Completed</span>' :
                                                '<span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Running</span>'
                                            }
                                        </div>
                                        <span class="text-sm font-medium ${colors.text}">${progressPercent}%</span>
                                    </div>

                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                        <div class="${colors.bar} h-2.5 rounded-full transition-all duration-300" style="width: ${progressPercent}%"></div>
                                    </div>

                                    <p class="text-sm text-gray-700 mb-2">${progress.message || 'Processing...'}</p>

                                    ${progress.data && Object.keys(progress.data).length > 0 ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="mt-3 bg-white rounded p-3 text-xs">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ${Object.entries(progress.data).map(([key, value]) => {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            if (typeof value !== 'object') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                return `
                                                            <div>
                                                                <span class="text-gray-500">${label}:</span>
                                                                <span class="font-semibold ml-1">${value}</span>
                                                            </div>
                                                        `;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            return '';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }).join('')}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ` : ''}

                                    <p class="text-xs text-gray-500 mt-2">Job ID: ${job.id}</p>
                                    <p class="text-xs text-gray-500">Updated: ${progress.updated_at || 'N/A'}</p>
                                </div>
                            `;

                            // Remove completed jobs after displaying
                            if (isComplete) {
                                setTimeout(() => {
                                    activeJobs = activeJobs.filter(j => j.id !== job.id);
                                }, 10000); // Keep for 10 seconds after completion
                            }
                        } else {
                            // Job not found, remove from active list
                            activeJobs = activeJobs.filter(j => j.id !== job.id);
                        }
                    } catch (error) {
                        console.error(`Error loading job ${job.id}:`, error);
                    }
                }

                html += '</div>';
                content.innerHTML = html;
            }

            // Refresh jobs progress
            function refreshJobsProgress() {
                loadJobsProgress();
            }

            // Auto-refresh jobs when modal is open
            let jobsRefreshInterval;

            function startJobsAutoRefresh() {
                jobsRefreshInterval = setInterval(() => {
                    if (!document.getElementById('jobs-modal').classList.contains('hidden')) {
                        loadJobsProgress();
                    }
                }, 3000); // Refresh every 3 seconds
            }

            function stopJobsAutoRefresh() {
                if (jobsRefreshInterval) {
                    clearInterval(jobsRefreshInterval);
                }
            }

            // Start auto-refresh when jobs modal opens
            const originalOpenJobsModal = openJobsModal;
            openJobsModal = function() {
                originalOpenJobsModal();
                startJobsAutoRefresh();
            };

            const originalCloseJobsModal = closeJobsModal;
            closeJobsModal = function() {
                originalCloseJobsModal();
                stopJobsAutoRefresh();
            };

            // Redownload missing videos
            async function redownloadMissing() {
                const limit = parseInt(document.getElementById('redownload-limit').value);
                const force = document.getElementById('redownload-force').checked;

                if (confirm(`This will process up to ${limit} videos. Continue?`)) {
                    setButtonLoading('btn-redownload', true);

                    try {
                        const response = await fetch('{{ route('admin.vm.redownload-missing') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                limit,
                                force
                            })
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Response not OK:', response.status, errorText);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();

                        if (result.success) {
                            showNotification(result.message, 'success');

                            // Add job to tracking
                            if (result.job_id) {
                                activeJobs.push({
                                    id: result.job_id,
                                    type: 'redownload'
                                });
                            }

                            // Show jobs modal
                            // setTimeout(() => openJobsModal(), 500);
                        } else {
                            showNotification(result.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('An error occurred. Check console for details.', 'error');
                    } finally {
                        setButtonLoading('btn-redownload', false);
                    }
                }
            }

            // Cleanup expired videos
            async function cleanupExpired() {
                const olderThanDays = parseInt(document.getElementById('cleanup-days').value);
                const deleteInactive = document.getElementById('cleanup-delete').checked;

                const action = deleteInactive ? 'delete' : 'deactivate';
                if (confirm(`This will check and ${action} expired videos. Continue?`)) {
                    setButtonLoading('btn-cleanup', true);

                    try {
                        const response = await fetch('{{ route('admin.vm.cleanup-expired') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                older_than_days: olderThanDays,
                                delete_inactive: deleteInactive
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            showNotification(result.message, 'success');

                            if (result.job_id) {
                                activeJobs.push({
                                    id: result.job_id,
                                    type: 'cleanup'
                                });
                            }

                            // setTimeout(() => openJobsModal(), 500);
                        } else {
                            showNotification(result.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('An error occurred. Check console for details.', 'error');
                    } finally {
                        setButtonLoading('btn-cleanup', false);
                    }
                }
            }

            // Verify and fix broken videos
            async function verifyAndFix() {
                const limit = parseInt(document.getElementById('verify-limit').value);

                if (confirm(`This will verify up to ${limit} videos. Continue?`)) {
                    setButtonLoading('btn-verify', true);

                    try {
                        const response = await fetch('{{ route('admin.vm.verify-fix') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                limit
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            showNotification(result.message, 'success');

                            if (result.job_id) {
                                activeJobs.push({
                                    id: result.job_id,
                                    type: 'verify'
                                });
                            }

                            // setTimeout(() => openJobsModal(), 500);
                        } else {
                            showNotification(result.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('An error occurred. Check console for details.', 'error');
                    } finally {
                        setButtonLoading('btn-verify', false);
                    }
                }
            }

            // Delete old videos
            async function deleteOld() {
                const olderThanDays = parseInt(document.getElementById('delete-days').value);
                const limit = parseInt(document.getElementById('delete-limit').value);

                if (confirm(
                        `⚠️ WARNING: This will permanently delete local video files older than ${olderThanDays} days. This action cannot be undone. Continue?`
                    )) {
                    setButtonLoading('btn-delete', true);

                    try {
                        const response = await fetch('{{ route('admin.vm.delete-old') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                older_than_days: olderThanDays,
                                limit
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            showNotification(result.message, 'success');

                            if (result.job_id) {
                                activeJobs.push({
                                    id: result.job_id,
                                    type: 'delete'
                                });
                            }

                            // setTimeout(() => openJobsModal(), 500);
                        } else {
                            showNotification(result.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('An error occurred. Check console for details.', 'error');
                    } finally {
                        setButtonLoading('btn-delete', false);
                    }
                }
            }

            // Refresh statistics
            async function refreshStatistics() {
                try {
                    const response = await fetch('{{ route('admin.vm.statistics') }}');
                    const result = await response.json();

                    if (result.success) {
                        const stats = result.data;
                        document.getElementById('stat-total').textContent = stats.total_videos || 0;
                        document.getElementById('stat-local').textContent = stats.with_local_storage || 0;
                        document.getElementById('stat-missing').textContent = stats.without_local_storage || 0;
                        document.getElementById('stat-storage').textContent = (stats.storage_size_mb / 1024 || 0).toFixed(
                                2) +
                            ' GB';
                    }
                } catch (error) {
                    console.error('Error refreshing statistics:', error);
                }
            }

            // Auto-refresh statistics every 30 seconds
            setInterval(refreshStatistics, 30000);

            // Close modals on outside click
            document.getElementById('statistics-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeStatisticsModal();
                }
            });

            document.getElementById('jobs-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeJobsModal();
                }
            });
        </script>
    @endpush
</x-admin::app>
