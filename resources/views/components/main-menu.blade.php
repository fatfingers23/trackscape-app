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


    </div>
    <div class="navbar-center hidden lg:flex">

    </div>
    <div class="navbar-end">
        <ul class="menu menu-horizontal p-0 hidden lg:fle">
            @isset($clan)
                <li tabindex="0">
                    <a @class([
'active' => Route::current()->getName() == 'collection-logs'|| Route::current()->getName() == 'pb'
])>
                        Leaderboards
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24">
                            <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                        </svg>
                    </a>
                    <ul class="p-2 bg-base-100">
                        <li><a class="{{Route::current()->getName() == 'collection-logs' ? 'active' : ''}}"
                               href="{{route('collection-logs', $clan->id)}}">Collection
                                Log Leaderboard</a>
                        </li>
                        <li><a class="{{Route::current()->getName() == 'pb' ? 'active' : ''}}"
                               href="{{route('pb', $clan->id)}}">PB Leaderboard</a>
                        </li>
                    </ul>
                </li>
            @endisset

            <li><a class=" {{Route::current()->getName() == 'faq' ? 'active' : ''}}"
                   href="{{route('faq')}}">FAQ</a></li>
        </ul>
        <select class="select" data-choose-theme>
            <option disabled selected>Pick A theme</option>
            @foreach($themeNames as $themeName)
                <option value="{{$themeName}}">{{$themeName}}</option>
            @endforeach

        </select>
    </div>
</div>
