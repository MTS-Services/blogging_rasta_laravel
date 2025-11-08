 <div class="container mx-auto ">
     <div class="min-h-screen flex items-center justify-center bg-[#0D061A] text-white ">
         <form method="POST" wire:submit.prevent="login"
             class="-mt-28 w-full h-[600px] max-w-lg bg-[#1a0b2e] rounded-2xl p-8 shadow-lg space-y-8">
             <!-- Header -->
             <div class="text-center">
                 <h2 class="text-5xl font-medium p-4 text-white">{{__('Gmail Verification')}}</h2>
                 <p class="text-gray-300 lg:text-xl text-base">
                     {{ __('Hi! Welcome back, you’ve been missed.') }}
                 </p>
             </div>

             <!-- Email -->
             <div>
                 <label class="block text-xl font-medium mb-2 text-white">{{__('Email')}}</label>
                 <input type="email" placeholder="example@gmail.com" wire:model="email"
                     class="w-full px-4 py-3 bg-[#2d1f43] text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
             </div>
                <!-- Error message -->
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror

             <!-- Submit button -->
             <div>
                 <button type="submit" wire:click="sendCode"
                     class="w-full bg-[#853fee] hover:bg-purple-700 transition-colors text-white font-medium py-3 rounded-full">
                     {{__('Send Code')}}
                 </button>
             </div>

             <!-- Divider -->
             <div class="flex items-center justify-center space-x-2">
                 <hr class="flex-1 border-gray-700" />
                 <span class="text-gray-200 text-sm">{{__('Or sign in with')}}</span>
                 <hr class="flex-1 border-gray-700" />
             </div>

             <!-- Social login -->
             <div class="flex justify-center gap-4">
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-6 h-6" alt="Google" />
                 </button>
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}" class="w-6 h-6" alt="Apple" />
                 </button>
                 <button class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                     <img src="{{ asset('assets/icons/icons8-facebook.svg') }}" class="w-6 h-6" alt="Facebook" />
                 </button>
             </div>

             <!-- Footer -->
             <div class="text-center text-gray-200 text-sm">
                 {{__('Don’t have an account?')}}
                 <a href="{{ route('register') }}" class="text-purple-400 hover:underline">{{__('Sign up')}}</a>
             </div>
         </form>
     </div>
 </div>
