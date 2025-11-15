<div>

    <section class="bg-second-500/15  py-24">
        <div class="container">
            <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center mb-6">
                {{ __('Privacy Policy ') }}</h2>

            <p class="text-base font-normal font-montserrat text-text-primary">
                {{ __('At DiodioGlow, we value your privacy and are committed to protecting your personal information. This policy explains what data we collect, how we use it, and your rights.') }}
            </p>

            <div class="mt-6">
                <p class="text-base font-semibold font-inter text-text-primary mt-6">{{ __('Information We Collect') }}
                </p>
                <ul class="text-base font-normal font-inter text-text-primary list-disc pl-5 mt-2">
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('Basic account details (name, email).') }}</li>
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('Usage data such as viewed content, clicks, and device information.') }}</li>
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('Optional skincare preferences you choose to share.') }}</li>
                </ul>
            </div>
            <div class="mt-6">
                <p class="text-base font-semibold font-inter text-text-primary mt-6">
                    {{ __('How We Use Your Information') }}</p>
                <ul class="text-base font-normal font-inter text-text-primary list-disc pl-5 mt-2">
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('To personalize your skincare feed and recommendations.') }}</li>
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('To improve platform performance and user experience.') }}</li>
                    <li class="text-base font-normal font-inter text-text-primary">
                        {{ __('To send updates, tips, and service notifications.') }}</li>
                </ul>
            </div>

            <div class="flex flex-col md:flex-row gap-6 justify-between items-center mt-6">
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                    <flux:icon name="lock" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <p class="text-base font-semibold font-inter text-text-primary">{{ __('Data Protection') }}</p>
                        <p class="text-base font-normal font-inter text-text-primary">
                            {{ __('We use industry-standard security measures to safeguard your data and never sell your information to third parties.') }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                    <flux:icon name="users" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <p class="text-base font-semibold font-inter text-text-primary">{{ __('Your Rights') }}</p>
                        <p class="text-base font-normal font-inter text-text-primary">
                            {{ __('You can request deletion, correction, or access to your data anytime by contacting our support team.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
