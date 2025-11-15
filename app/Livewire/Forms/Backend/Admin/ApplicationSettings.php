<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use App\Models\ApplicationSetting;
use Illuminate\Validation\Rule;

class ApplicationSettings extends Form
{
    public $app_name, $short_name, $timezone, $date_format, $time_format;
    public $favicon, $app_logo, $theme_mode;
    public $public_registration, $registration_approval;
    public $environment, $app_debug, $debugbar;
    public $database_driver, $database_host, $database_port, $database_name, $database_username, $database_password;
    public $smtp_driver, $smtp_host, $smtp_port, $smtp_encryption, $smtp_username, $smtp_password, $smtp_from_address, $smtp_from_name;

    public function rules(): array
    {
        $app = new ApplicationSetting;

        return [
            'app_name' => 'nullable|string|min:3|max:255',
            'short_name' => 'nullable|string|min:2|max:255',
            'timezone' => 'nullable|string',
            'date_format' => 'nullable|string',
            'time_format' => 'nullable|string',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'theme_mode' => ['nullable','string', Rule::in([$app::THEME_MODE_LIGHT, $app::THEME_MODE_DARK, $app::THEME_MODE_SYSTEM])],
            'public_registration' => ['nullable','integer', Rule::in([$app::ALLOW_PUBLIC_REGISTRATION, $app::DENY_PUBLIC_REGISTRATION])],
            'registration_approval' => ['nullable','integer', Rule::in([$app::REGISTRATION_APPROVAL_AUTO, $app::REGISTRATION_APPROVAL_MANUAL])],
            'environment' => ['nullable','string', Rule::in([$app::ENVIRONMENT_DEVELOPMENT, $app::ENVIRONMENT_PRODUCTION])],
            'app_debug' => ['nullable','integer', Rule::in([$app::APP_DEBUG_TRUE, $app::APP_DEBUG_FALSE])],
            'debugbar' => ['nullable','integer', Rule::in([$app::ENABLE_DEBUGBAR, $app::DISABLE_DEBUGBAR])],

            'database_driver' => ['nullable','string', Rule::in([$app::DATATBASE_DRIVER_MYSQL, $app::DATATBASE_DRIVER_PGSQL, $app::DATATBASE_DRIVER_SQLITE, $app::DATATBASE_DRIVER_SQLSRV])],
            'database_host' => 'nullable|string',
            'database_port' => 'nullable|string',
            'database_name' => 'nullable|string',
            'database_username' => 'nullable|string',
            'database_password' => 'nullable|string',

            'smtp_host' => 'nullable|string',
            'smtp_port' => 'nullable|string',
            'smtp_username' => 'nullable|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => ['nullable','string', Rule::in([$app::SMTP_ENCRYPTION_TLS, $app::SMTP_ENCRYPTION_SSL, $app::SMTP_ENCRYPTION_NONE])],
            'smtp_driver' => ['nullable','string', Rule::in([$app::SMTP_DRIVER_MAILER, $app::SMTP_DRIVER_MAILGUN, $app::SMTP_DRIVER_SES, $app::SMTP_DRIVER_POSTMARK, $app::SMTP_DRIVER_SENDMAIL])],
            'smtp_from_address' => 'nullable|email',
            'smtp_from_name' => 'nullable|string',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Filter out null/empty values
        $validated = array_filter($validated, function($value) {
            return !is_null($value) && $value !== '';
        });

        foreach ($validated as $key => $value) {
            // Handle file uploads
            if (in_array($key, ['app_logo', 'favicon']) && $value) {
                $value = app('App\Http\Traits\FileManagementTrait')->handleFileUpload($value, 'application_settings', $key);
            }

            // Get env_key mapping
            $envKeyMap = $this->getEnvKeyMap();
            $envKey = $envKeyMap[$key] ?? null;

            // Save to database and update .env file
            ApplicationSetting::set($key, $value, $envKey);
        }

        // Clear all settings cache
        ApplicationSetting::clearCache();
    }

    /**
     * Get env key mapping for settings
     */
    private function getEnvKeyMap(): array
    {
        return [
            'app_name' => 'APP_NAME',
            'timezone' => 'TIMEZONE',
            'environment' => 'APP_ENV',
            'app_debug' => 'APP_DEBUG',
            'database_driver' => 'DB_CONNECTION',
            'database_host' => 'DB_HOST',
            'database_port' => 'DB_PORT',
            'database_name' => 'DB_DATABASE',
            'database_username' => 'DB_USERNAME',
            'database_password' => 'DB_PASSWORD',
            'smtp_driver' => 'MAIL_MAILER',
            'smtp_host' => 'MAIL_HOST',
            'smtp_port' => 'MAIL_PORT',
            'smtp_encryption' => 'MAIL_ENCRYPTION',
            'smtp_username' => 'MAIL_USERNAME',
            'smtp_password' => 'MAIL_PASSWORD',
            'smtp_from_address' => 'MAIL_FROM_ADDRESS',
            'smtp_from_name' => 'MAIL_FROM_NAME',
        ];
    }
}