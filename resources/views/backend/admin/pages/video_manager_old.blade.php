<x-admin::app>
    <x-slot name="pageSlug">{{ __('video-manager') }}</x-slot>
    <x-slot name="title">{{ __('Video Management') }}</x-slot>
    <x-slot name="breadcrumb">{{ __('Video Management') }}</x-slot>
    <div class="container mx-auto px-4 py-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Video Management</h1>
            <p class="text-gray-600">Manage TikTok video downloads and cleanup expired videos</p>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Videos --}}
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Videos</p>
                        <p class="text-3xl font-bold text-gray-900" id="stat-total">{{ $stats['total_videos'] ?? 0 }}
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
                            {{ $stats['with_local_storage'] ?? 0 }}</p>
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
                            {{ $stats['without_local_storage'] ?? 0 }}</p>
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
                            {{ isset($stats['storage_size_mb']) ? number_format($stats['storage_size_mb'], 2) : '0' }}
                            MB
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

                        <div class="flex items-center gap-3 mb-4">
                            <div>
                                <label class="text-xs text-gray-600">Limit</label>
                                <input type="number" id="redownload-limit" value="50" min="1" max="500"
                                    class="mt-1 block w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="redownload-force" class="mr-2">
                                <label for="redownload-force" class="text-sm text-gray-600">Force redownload all</label>
                            </div>
                        </div>

                        <button onclick="redownloadMissing()"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="btn-redownload">
                            <span class="btn-text">Start Redownload</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin inline-block w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </button>
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

                        <div class="flex items-center gap-3 mb-4">
                            <div>
                                <label class="text-xs text-gray-600">Older than (days)</label>
                                <input type="number" id="cleanup-days" value="7" min="1"
                                    max="365"
                                    class="mt-1 block w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="cleanup-delete" class="mr-2">
                                <label for="cleanup-delete" class="text-sm text-gray-600">Delete inactive</label>
                            </div>
                        </div>

                        <button onclick="cleanupExpired()"
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
                        </button>
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

                        <div class="mb-4">
                            <label class="text-xs text-gray-600">Check limit</label>
                            <input type="number" id="verify-limit" value="100" min="1" max="500"
                                class="mt-1 block w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                        </div>

                        <button onclick="verifyAndFix()"
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
                        </button>
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

                        <div class="flex items-center gap-3 mb-4">
                            <div>
                                <label class="text-xs text-gray-600">Older than (days)</label>
                                <input type="number" id="delete-days" value="90" min="30" max="365"
                                    class="mt-1 block w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Limit</label>
                                <input type="number" id="delete-limit" value="100" min="1"
                                    max="500"
                                    class="mt-1 block w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                            </div>
                        </div>

                        <button onclick="deleteOld()"
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
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Results Section --}}
        <div id="results-section" class="hidden bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Results</h3>
            <div id="results-content" class="text-sm"></div>
        </div>

    </div>
    @push('scripts')
        <script>
            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

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

                // Scroll to results
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

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
                                'Accept': 'application/json' // Add this
                            },
                            body: JSON.stringify({
                                limit,
                                force
                            })
                        });

                        // Add response status check
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Response not OK:', response.status, errorText);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();

                        if (result.success) {
                            showNotification(result.message, 'success');
                            showResults(result.message, result.data);
                            refreshStatistics();
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
                            showResults(result.message, result.data);
                            refreshStatistics();
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
                            showResults(result.message, result.data);
                            refreshStatistics();
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
                            showResults(result.message, result.data);
                            refreshStatistics();
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
                        document.getElementById('stat-storage').textContent = (stats.storage_size_mb || 0).toFixed(2) +
                            ' MB';
                    }
                } catch (error) {
                    console.error('Error refreshing statistics:', error);
                }
            }

            // Auto-refresh statistics every 30 seconds
            setInterval(refreshStatistics, 30000);
        </script>
    @endpush
</x-admin::app>
