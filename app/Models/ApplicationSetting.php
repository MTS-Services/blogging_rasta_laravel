<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ApplicationSetting extends Model
{
    // Constants for theme modes
    const THEME_MODE_LIGHT = 'light';
    const THEME_MODE_DARK = 'dark';
    const THEME_MODE_SYSTEM = 'system';

    // Constants for registration
    const ALLOW_PUBLIC_REGISTRATION = 1;
    const DENY_PUBLIC_REGISTRATION = 0;
    const REGISTRATION_APPROVAL_AUTO = 0;
    const REGISTRATION_APPROVAL_MANUAL = 1;

    // Constants for environment
    const ENVIRONMENT_DEVELOPMENT = 'local';
    const ENVIRONMENT_PRODUCTION = 'production';

    // Constants for debug
    const APP_DEBUG_TRUE = 1;
    const APP_DEBUG_FALSE = 0;
    const ENABLE_DEBUGBAR = 1;
    const DISABLE_DEBUGBAR = 0;

    // Constants for database drivers
    const DATATBASE_DRIVER_MYSQL = 'mysql';
    const DATATBASE_DRIVER_PGSQL = 'pgsql';
    const DATATBASE_DRIVER_SQLITE = 'sqlite';
    const DATATBASE_DRIVER_SQLSRV = 'sqlsrv';

    // Constants for SMTP
    const SMTP_DRIVER_MAILER = 'smtp';
    const SMTP_DRIVER_MAILGUN = 'mailgun';
    const SMTP_DRIVER_SES = 'ses';
    const SMTP_DRIVER_POSTMARK = 'postmark';
    const SMTP_DRIVER_SENDMAIL = 'sendmail';
    const SMTP_ENCRYPTION_TLS = 'tls';
    const SMTP_ENCRYPTION_SSL = 'ssl';
    const SMTP_ENCRYPTION_NONE = 'none';

    // Constants for date/time formats
    const DATE_FORMAT_ONE = 'd/m/Y';
    const DATE_FORMAT_TWO = 'm/d/Y';
    const DATE_FORMAT_THREE = 'Y-m-d';
    const TIME_FORMAT_12 = 'h:i A';
    const TIME_FORMAT_24 = 'H:i:s';

    protected $fillable = [
        'key',
        'value',
        'env_key',
    ];

    /**
     * Get a single setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::rememberForever("app_setting_{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Get multiple settings at once
     */
    public static function getMany(array $keys)
    {
        $settings = [];
        
        foreach ($keys as $key) {
            $settings[$key] = self::get($key);
        }
        
        return $settings;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $envKey = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'env_key' => $envKey,
            ]
        );

        // Update .env file if env_key is provided
        if ($envKey) {
            self::updateEnvFile($envKey, $value);
        }

        // Clear cache
        Cache::forget("app_setting_{$key}");

        return $setting;
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("app_setting_{$setting->key}");
        }
    }

    /**
     * Update .env file
     */
    private static function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        
        if (!file_exists($path)) {
            return;
        }

        $envContent = file_get_contents($path);
        $value = str_replace('"', '\"', $value);
        
        // Check if key exists
        if (preg_match("/^{$key}=/m", $envContent)) {
            // Update existing key
            $envContent = preg_replace(
                "/^{$key}=.*/m",
                "{$key}=\"{$value}\"",
                $envContent
            );
        } else {
            // Add new key
            $envContent .= "\n{$key}=\"{$value}\"";
        }

        file_put_contents($path, $envContent);
    }

    /**
     * Get theme mode options
     */
    public static function getThemeModeInfos()
    {
        return [
            self::THEME_MODE_LIGHT => __('Light'),
            self::THEME_MODE_DARK => __('Dark'),
            self::THEME_MODE_SYSTEM => __('System'),
        ];
    }

    /**
     * Get environment options
     */
    public static function getEnvironmentInfos()
    {
        return [
            self::ENVIRONMENT_DEVELOPMENT => __('Local'),
            self::ENVIRONMENT_PRODUCTION => __('Production'),
        ];
    }

    /**
     * Get app debug options
     */
    public static function getAppDebugInfos()
    {
        return [
            self::APP_DEBUG_TRUE => __('Enable'),
            self::APP_DEBUG_FALSE => __('Disable'),
        ];
    }

    /**
     * Get debugbar options
     */
    public static function getDebugbarInfos()
    {
        return [
            self::ENABLE_DEBUGBAR => __('Enable'),
            self::DISABLE_DEBUGBAR => __('Disable'),
        ];
    }

    /**
     * Get date format options
     */
    public static function getDateFormatInfos()
    {
        return [
            self::DATE_FORMAT_ONE => 'd/m/Y',
            self::DATE_FORMAT_TWO => 'm/d/Y',
            self::DATE_FORMAT_THREE => 'Y-m-d',
        ];
    }

    /**
     * Get time format options
     */
    public static function getTimeFormatInfos()
    {
        return [
            self::TIME_FORMAT_12 => '12 Hour',
            self::TIME_FORMAT_24 => '24 Hour',
        ];
    }
}