  <div class=" bg-bg-primary shadow-glass-card border-b  mb-6 space-x-2 overflow-x-auto  rounded-2xl p-6 ">
      {{-- Personal Info Tab --}}
      <a type="button" wire:navigate href="{{ route('admin.um.user.profileInfo', $user->id) }}"
          class="px-4 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none
    {{ request()->routeIs('admin.um.user.profileInfo') ? 'border-b-2 border-zinc-500 text-text-text-primary font-semibold' : 'text-gray-600 hover:text-gray-900 dark:hover:text-white transition-all duration-200' }}">
          {{ __('Personal Info') }}
      </a>

      {{-- Shop Info Tab --}}
      <a type="button" wire:navigate href="{{ route('admin.um.user.shopInfo', $user->id) }}"
          class="px-4 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none
    {{ request()->routeIs('admin.um.user.shopInfo') ? 'border-b-2 border-zinc-500 text-text-text-primary font-semibold' : 'text-text-text-primary hover:text-gray-900 dark:hover:text-white transition-all duration-200' }}">
          {{ __('Shop Info') }}
      </a>

        {{-- KYC Info Tab --}}
      <a type="button" wire:navigate href="{{ route('admin.um.user.kycInfo', $user->id) }}"
          class="px-4 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none
    {{ request()->routeIs('admin.um.user.kycInfo') ? 'border-b-2 border-zinc-500 text-text-text-primary font-semibold' : 'text-text-text-primary hover:text-gray-900 dark:hover:text-white transition-all duration-200' }}">
          {{ __('KYC') }}
      </a>
      <a type="button" wire:navigate href="{{ route('admin.um.user.statistic', $user->id) }}"
          class="px-4 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none
    {{ request()->routeIs('admin.um.user.statistic') ? 'border-b-2 border-zinc-500 text-text-text-primary font-semibold' : 'text-text-text-primary hover:text-gray-900 dark:hover:text-white transition-all duration-200' }}">
          {{ __('Statistic') }}
      </a>
      <a type="button" wire:navigate href="{{ route('admin.um.user.referral', $user->id) }}"
          class="px-4 py-2 text-sm font-medium transition duration-150 ease-in-out focus:outline-none
    {{ request()->routeIs('admin.um.user.referral') ? 'border-b-2 border-zinc-500 text-text-text-primary font-semibold' : 'text-text-text-primary hover:text-gray-900 dark:hover:text-white transition-all duration-200' }}">
          {{ __('Referral') }}
      </a>

  </div>
