<?php
// File: app/Helpers/helpers.php (Add to existing helpers file)

use App\Enums\OtpType;
use App\Models\OtpVerification;
use App\Services\ApplicationSettingsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



// ==================== Existing Auth Helpers ====================

if (!function_exists('timeFormat')) {
    function timeFormat($time, $compareValue = null)
    {
        return $time && $time != $compareValue ? date(('H:i A'), strtotime($time)) : 'N/A';
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $compareValue = null)
    {
        return $date && $date != $compareValue ? date(('d M Y'), strtotime($date)) : 'N/A';
    }
}
if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($dateTime, $compareValue = null)
    {
        return $dateTime && $dateTime != $compareValue ? dateFormat($dateTime) . ' ' . timeFormat($dateTime) : 'N/A';
    }
}
if (!function_exists('dateTimeHumanFormat')) {
    function dateTimeHumanFormat($dateTime, $compareValue = null): mixed
    {
        return $dateTime && $dateTime != $compareValue ? Carbon::parse($dateTime)->diffForHumans() : 'N/A';
    }
}

if (!function_exists('user')) {
    function user()
    {
        return Auth::guard('web')->user();
    }
}

if (!function_exists('admin')) {
    function admin()
    {
        return Auth::guard('admin')->user();
    }
}

// ==================== Existing Storage Helpers ====================

if (!function_exists('storage_url')) {
    function storage_url($urlOrArray)
    {
        $image = asset('assets/images/no_img.jpg');
        if (is_array($urlOrArray) || is_object($urlOrArray)) {
            $result = '';
            $count = 0;
            $itemCount = count($urlOrArray);
            foreach ($urlOrArray as $index => $url) {
                $result .= $url ? (Str::startsWith($url, 'https://') ? $url : asset('storage/' . $url)) : $image;

                if ($count === $itemCount - 1) {
                    $result .= '';
                } else {
                    $result .= ', ';
                }
                $count++;
            }
            return $result;
        } else {
            return $urlOrArray ? (Str::startsWith($urlOrArray, 'https://') ? $urlOrArray : asset('storage/' . $urlOrArray)) : $image;
        }
    }
}

if (!function_exists('auth_storage_url')) {
    function auth_storage_url($url)
    {
        $image = asset('assets/images/other.png');
        return $url ? $url : $image;
    }
}

// ==================== Existing Application Setting Helpers ====================

if (!function_exists('site_name')) {
    function site_name()
    {
        return config('app.name', 'Laravel Application');
    }
}

if (!function_exists('site_short_name')) {
    function site_short_name()
    {
        return app(ApplicationSettingsService::class)->findData('short_name', 'LA');
    }
}
if (!function_exists('site_logo')) {
    function site_logo()
    {
        return storage_url(app(ApplicationSettingsService::class)->findData('app_logo'));
    }
}
if (!function_exists('site_favicon')) {
    function site_favicon()
    {
        return storage_url(app(ApplicationSettingsService::class)->findData('favicon'));
    }
}

if (!function_exists('site_tagline')) {
    function site_tagline()
    {
        return config('app.tagline', 'Laravel Application Tagline');
    }
}

// ==================== NEW OTP Helpers ====================

if (!function_exists('generate_otp')) {
    /**
     * Generate a random OTP code
     *
     * @param int $digits Number of digits (default: 6)
     * @return string
     */
    function generate_otp(int $digits = 6): string
    {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;
        return (string) mt_rand($min, $max);
    }
}

// if (!function_exists('create_otp')) {
//     /**
//      * Create OTP for a model
//      *
//      * @param mixed $model Model instance (Admin, User, etc.)
//      * @param OtpType $type OTP type
//      * @param int $expiresInMinutes Expiration time in minutes
//      * @return OtpVerification
//      */
//     function create_otp($model, OtpType $type, int $expiresInMinutes = 10): OtpVerification
//     {
//         return $model->createOtp($type, $expiresInMinutes);
//     }
// }

// if (!function_exists('verify_otp')) {
//     /**
//      * Verify OTP code for a model
//      *
//      * @param mixed $model Model instance
//      * @param string $code OTP code to verify
//      * @param OtpType $type OTP type
//      * @return bool
//      */
//     function verify_otp($model, string $code, OtpType $type): bool
//     {
//         $otp = $model->latestOtp($type);

//         if (!$otp) {
//             return false;
//         }

//         return $otp->verify($code);
//     }
// }

// if (!function_exists('has_valid_otp')) {
//     /**
//      * Check if model has valid unexpired OTP
//      *
//      * @param mixed $model Model instance
//      * @param OtpType $type OTP type
//      * @return bool
//      */
//     function has_valid_otp($model, OtpType $type): bool
//     {
//         $otp = $model->latestOtp($type);

//         if (!$otp) {
//             return false;
//         }

//         return !$otp->isExpired() && !$otp->isVerified();
//     }
// }

// if (!function_exists('get_otp_remaining_time')) {
//     /**
//      * Get remaining time for OTP expiration in seconds
//      *
//      * @param mixed $model Model instance
//      * @param OtpType $type OTP type
//      * @return int|null Remaining seconds or null
//      */
//     function get_otp_remaining_time($model, OtpType $type): ?int
//     {
//         $otp = $model->latestOtp($type);

//         if (!$otp || $otp->isExpired()) {
//             return null;
//         }

//         return max(0, $otp->expires_at->diffInSeconds(now()));
//     }
// }

if (! function_exists('detectFileType')) {
    function detectFileType($filePath)
    {
        // Check if the file exists
        if (!file_exists($filePath)) {
            return 'missing';
        }

        // Get MIME type
        $mime = mime_content_type($filePath);

        if (!$mime) {
            return 'unknown';
        }

        // Check for image
        if (str_starts_with($mime, 'image/')) {
            return 'image';
        }

        // Check for video
        if (str_starts_with($mime, 'video/')) {
            return 'video';
        }

        // If neither image nor video
        return 'unknown';
    }
}


if (!function_exists('format_otp_time')) {
    /**
     * Format OTP remaining time in human-readable format
     *
     * @param int|null $seconds
     * @return string
     */
    function format_otp_time(?int $seconds): string
    {
        if (!$seconds || $seconds <= 0) {
            return 'Expired';
        }

        if ($seconds < 60) {
            return $seconds . ' second' . ($seconds > 1 ? 's' : '');
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($remainingSeconds > 0) {
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ' .
                $remainingSeconds . ' second' . ($remainingSeconds > 1 ? 's' : '');
        }

        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }
}

if (!function_exists('is_email_verified')) {
    /**
     * Check if user/admin email is verified
     *
     * @param mixed $model
     * @return bool
     */
    function is_email_verified($model): bool
    {
        return !is_null($model?->email_verified_at);
    }
}

if (!function_exists('is_phone_verified')) {
    /**
     * Check if user/admin phone is verified
     *
     * @param mixed $model
     * @return bool
     */
    function is_phone_verified($model): bool
    {
        return !is_null($model?->phone_verified_at);
    }
}

if (!function_exists('availableTimezones')) {
    function availableTimezones()
    {
        $timezones = [];
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();

        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $timezone = new DateTimeZone($timezoneIdentifier);
            $offset = $timezone->getOffset(new DateTime());
            $offsetPrefix = $offset < 0 ? '-' : '+';
            $offsetFormatted = gmdate('H:i', abs($offset));

            $timezones[] = [
                'timezone' => $timezoneIdentifier,
                'name' => "(UTC $offsetPrefix$offsetFormatted) $timezoneIdentifier",
            ];
        }

        return $timezones;
    }

    if (!function_exists('getAuditorName')) {
        function getAuditorName($model)
        {
            return $model && $model->name ? $model->name : 'N/A';
        }
    }
}
