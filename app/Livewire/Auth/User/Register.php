<?php

namespace App\Livewire\Auth\User;

use App\Models\User;
use App\Models\Country;
use App\Enums\UserType;
use App\Enums\UserAccountStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public string $username = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?int $country_id = null;
    public bool $terms_accepted = false;
    public bool $privacy_accepted = false;

    public $countries = [];

    /**
     * Mount component and load countries
     */
    public function mount(): void
    {
        $this->countries = Country::select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'regex:/^[a-zA-Z0-9_]+$/'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms_accepted' => ['accepted', 'boolean'],
            'privacy_accepted' => ['accepted', 'boolean'],
        ];
    }

    /**
     * Custom validation messages
     */
    protected function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already registered.',
            'email.email' => 'Please provide a valid email address.',
            'country_id.required' => 'Please select your country.',
            'country_id.exists' => 'Selected country is invalid.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms_accepted.accepted' => 'You must accept the Terms of Service.',
            'privacy_accepted.accepted' => 'You must accept the Privacy Policy.',
        ];
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate();

        // Create user with all required fields
        $user = User::create([
            'username' => $validated['username'],
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            // 'display_name' => trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? '')) ?: $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'country_id' => $validated['country_id'],
            'password' => Hash::make($validated['password']),
            'user_type' => UserType::BUYER,
            'account_status' => UserAccountStatus::PENDING_VERIFICATION,
            'terms_accepted_at' => now(),
            'privacy_accepted_at' => now(),
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        // Load country relationship for newly created user
        $user->load('country');

        // Fire registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Regenerate session
        Session::regenerate();

        // Redirect to profile or dashboard
        $this->redirect(route('user.purchased-orders', absolute: false), navigate: true);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.auth.user.register');
    }
}