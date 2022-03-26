<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="synthwave">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="text-center mx-4 space-y-2">
<div class="container mx-auto">
    <h1 class="text-600 text-5xl font-bold">
        {{$clan->name}}
    </h1>
    <div class=" mt-5 shadow-xl">
        <table class="table w-full">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Player</th>
                <th>Total Collection Log</th>

            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
            @php
                $count = 1;
            @endphp

            @foreach($collectionLogs as $collectionLog)
                <tr>
                    <th>{{$count}}</th>
                    <th>{{$collectionLog->player->username}}</th>
                    <td>{{$collectionLog->collection_count}}</td>

                </tr>
                @php
                    $count++;
                @endphp
            @endforeach
            </tbody>
        </table>
    </div>

</div>
@env ('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
@endenv
</body>
</html>
