<div class="min-h-screen bg-bg-primary py-12 px-4">
    <div class="container mx-auto">
        <div class="">
            {{-- Header --}}
            <div class="mb-8 mx-auto max-w-xl">
                <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-text-primary mb-3 ">Video Feed</h1>
                <p class="text-text-secondary text-base ">Trending skincare routines and beauty tips from TikTok</p>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex flex-wrap gap-2 ps-20 mb-10 max-w-2xl mx-auto">
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    All
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Morning
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Evening
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Haul
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Tips
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Problem-Solving
                </button>
                <button
                    class="px-3 py-2 rounded-lg bg-second-800/10 font-inter text-second-500 font-medium text-sm hover:bg-second-400/40 transition-colors">
                    Makeup
                </button>
            </div>
        </div>

        {{-- Video Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Card 1 --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative">
                    <img src="/api/placeholder/400/320" alt="10-Step Korean Skincare Routine"
                        class="w-full h-80 object-cover">
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">10-Step Korean Skincare Routine</h3>
                    <p class="text-sm text-gray-500 mb-4">Diodio Glow</p>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <button
                                class="flex items-center gap-1.5 text-gray-600 hover:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">2.8K</span>
                            </button>
                        </div>
                        <button class="flex items-center gap-1.5 text-gray-600 hover:text-green-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Share</span>
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs text-yellow-600 font-medium">#GlowSkin</span>
                        <span class="text-xs text-yellow-600 font-medium">#KoreanSkincare</span>
                        <span class="text-xs text-yellow-600 font-medium">#DiodioTips</span>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative">
                    <img src="/api/placeholder/400/320" alt="Budget Skincare Haul" class="w-full h-80 object-cover">
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Budget Skincare Haul (Under $50)</h3>
                    <p class="text-sm text-gray-500 mb-4">Diodio Glow</p>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <button
                                class="flex items-center gap-1.5 text-gray-600 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">18K</span>
                            </button>
                            <button
                                class="flex items-center gap-1.5 text-gray-600 hover:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">2.8K</span>
                            </button>
                        </div>
                        <button class="flex items-center gap-1.5 text-gray-600 hover:text-green-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Share</span>
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs text-yellow-600 font-medium">#GlowSkin</span>
                        <span class="text-xs text-yellow-600 font-medium">#KoreanSkincare</span>
                        <span class="text-xs text-yellow-600 font-medium">#DiodioTips</span>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                <div class="relative">
                    <img src="/api/placeholder/400/320" alt="How to Fix Dehydrated Skin Fast"
                        class="w-full h-80 object-cover">
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">How to Fix Dehydrated Skin Fast</h3>
                    <p class="text-sm text-gray-500 mb-4">Diodio Glow</p>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <button
                                class="flex items-center gap-1.5 text-gray-600 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">18K</span>
                            </button>
                            <button
                                class="flex items-center gap-1.5 text-gray-600 hover:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium">2.8K</span>
                            </button>
                        </div>
                        <button class="flex items-center gap-1.5 text-gray-600 hover:text-green-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Share</span>
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="text-xs text-yellow-600 font-medium">#GlowSkin</span>
                        <span class="text-xs text-yellow-600 font-medium">#KoreanSkincare</span>
                        <span class="text-xs text-yellow-600 font-medium">#DiodioTips</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
