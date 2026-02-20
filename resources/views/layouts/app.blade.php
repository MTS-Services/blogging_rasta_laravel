<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance()
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-linear-to-br from-start! to-end! text-text-primary">
    <main class="flex-1">
        {{ $slot }}
    </main>
    @fluxScripts()
    @stack('scripts')
</body>
</html>
