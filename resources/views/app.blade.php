<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance()
</head>
<body class="min-h-screen bg-linear-to-br from-start! to-end! text-text-primary">
    {{ $slot ?? '' }}
    @fluxScripts()
</body>
</html>
