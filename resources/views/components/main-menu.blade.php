@php
    $themeNames = ["light", "dark", "cupcake", "bumblebee", "emerald", "corporate", "synthwave", "retro", "cyberpunk", "valentine", "halloween", "garden", "forest", "aqua", "lofi", "pastel", "fantasy", "wireframe", "black", "luxury", "dracula", "cmyk", "autumn", "business", "acid", "lemonade", "night", "coffee", "winter"];

@endphp

<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                @isset($clan)
                    <li><a href="{{route('clanlanding-page', $clan->name)}}"
                        >{{$clan->name}}</a></li>
                @endisset
                <x-menu-list-items :clan="$clan"/>
            </ul>
        </div>
        <a href="/" tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
                <img src="{{asset('/images/logo.png')}}"/>
            </div>
        </a>
        <a href="/"
           class="btn btn-ghost normal-case text-xl md:visible invisible">Trackscape</a>
        @isset($clan)
            <a href="{{route('clanlanding-page', $clan->name)}}"
               class="btn btn-ghost normal-case text-xl">{{$clan->name}}</a>
        @endisset
    </div>
    <div class="navbar-end md:flex">
        <ul class="menu menu-horizontal p-0 hidden lg:flex">
            <x-menu-list-items :clan="$clan"/>

        </ul>
        <select class="select" data-choose-theme>
            <option disabled selected>Pick A theme</option>
            @foreach($themeNames as $themeName)
                <option value="{{$themeName}}">{{$themeName}}</option>
            @endforeach

        </select>
    </div>
</div>
