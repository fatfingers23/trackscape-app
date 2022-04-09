<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/icons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/icons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/icons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/icons/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('/icons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <link rel="shortcut icon" href="{{asset('/icons/favicon.ico')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="{{asset('')}}">
    <meta name="theme-color" content="#ffffff">


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

<x-main-menu :clan="$clan ?? null"/>


<main>

    <div class="mt-0 md:mt-5 shadow-xl min-h-screen">
        {{ $content }}
    </div>
    <footer class="footer p-10 bg-neutral text-neutral-content">
        <div>
            <div class="w-10 rounded-full">
                <img src="{{asset('images/logo.png')}}"/>
            </div>
            <p>Trackscape.<br>OSRS tooling for clans!</p>
        </div>

    </footer>
</main>

@env ('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
@endenv
<script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>
@livewireScripts

</body>

</html>
