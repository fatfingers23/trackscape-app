<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <style>[x-cloak] {
            display: none !important;
        }</style>
@livewireStyles
<!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>


@isset($clan)
    <x-clan-menu :clan="$clan"/>
@endisset

<main>

    <div class="mt-0 md:mt-5 shadow-xl">
        {{ $content }}
    </div>

</main>
@env ('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
@endenv
<script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
@livewireScripts

</body>
</html>
