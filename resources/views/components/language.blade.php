<div x-data="{ open: false }" class="relative">
    <!-- Dropdown Button -->
    <button @click="open = !open"
        class="flex items-center justify-between gap-2 px-4 py-2 md:px-6 md:py-2.5 btn-gradient text-white font-semibold rounded-full hover:shadow-lg transition-all duration-300 w-full md:w-auto">

        {{ App::getLocale() === 'fr' ? 'Français' : 'English' }}

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 transition-transform duration-200"
            :class="open ? 'rotate-180' : 'rotate-0'" fill="none" viewBox="0 0 24 24" stroke="white">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute right-0 md:right-0  w-full md:w-36 bg-white border border-zinc-200 rounded-xl shadow-lg z-50 overflow-hidden">

        <form action="{{ route('lang.change') }}" method="POST">
            @csrf

            <!-- French -->
            <button type="submit" name="lang" value="fr"
                class="block w-full text-left px-4 py-3 md:py-2 hover:bg-zinc-100
            {{ App::getLocale() == 'fr' ? 'bg-zinc-300/60 font-semibold' : '' }}">
                Français
            </button>

            <!-- English -->
            <button type="submit" name="lang" value="en"
                class="block w-full text-left px-4 py-3 md:py-2 hover:bg-zinc-100
            {{ App::getLocale() == 'en' ? 'bg-zinc-300/60 font-semibold' : '' }}">
                English
            </button>



        </form>
    </div>
</div>
