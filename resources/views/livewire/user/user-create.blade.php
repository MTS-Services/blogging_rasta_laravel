<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">{{__('Create User')}}</h1>
    </div>

    <div class="card max-w-2xl mx-auto shadow">
        <div class="card-body p-4">
            <form wire:submit="save">
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">{{__('Name *')}}</label>
                    <input type="text" id="name" wire:model="form.name"
                        class="input border  @error('form.name') border-red-500 @enderror">
                    @error('form.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">{{__('Email *')}}</label>
                    <input type="email" id="email" wire:model="form.email"
                        class="input border  @error('form.email') border-red-500 @enderror">
                    @error('form.email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">{{__('Password *')}}</label>
                    <input type="password" id="password" wire:model="form.password"
                        class="input border  @error('form.password') border-red-500 @enderror">
                    @error('form.password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">{{__('Confirm Password *')}}</label>
                    <input type="password" id="password_confirmation" wire:model="form.password_confirmation"
                        class="input border  @error('form.password_confirmation') border-red-500 @enderror">
                    @error('form.password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="form-label">{{__('Phone')}}</label>
                    <input type="text" id="phone" wire:model="form.phone"
                        class="input border  @error('form.phone') border-red-500 @enderror">
                    @error('form.phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="form-label">{{__('Address')}}</label>
                    <textarea id="address" wire:model="form.address" rows="3"
                        class="input border  @error('form.address') border-red-500 @enderror"></textarea>
                    @error('form.address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">{{__('Status *')}}</label>
                    <select id="status" wire:model="form.status"
                        class="form-select @error('form.status') border-red-500 @enderror">
                        @foreach ($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </select>
                    @error('form.status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Avatar -->
                <div class="mb-4">
                    <label for="avatar" class="form-label">{{__('Avatar')}}</label>
                    <input type="file" id="avatar" wire:model="form.avatar" accept="image/*"
                        class="input border  @error('form.avatar') border-red-500 @enderror">
                    @error('form.avatar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    @if ($form->avatar)
                        <div class="mt-2">
                            <img src="{{ $form->avatar->temporaryUrl() }}" alt="Preview"
                                class="w-24 h-24 rounded-full object-cover">
                        </div>
                    @endif

                    <div wire:loading wire:target="form.avatar" class="text-sm text-gray-500 mt-2">
                        {{ __('Uploading...') }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 mt-6">
                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">{{__('Create User')}}</span>
                        <span wire:loading wire:target="save">{{__('Creating...')}}</span>
                    </button>
                    <button type="button" wire:click="cancel" class="btn btn-secondary">
                        {{__('Cancel')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
