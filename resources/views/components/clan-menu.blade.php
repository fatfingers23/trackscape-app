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

                <li><a class=" {{Route::current()->getName() == 'collection-logs' ? 'active' : ''}}"
                       href="{{route('collection-logs', $clan->id)}}">Collection
                        Log Leaderboard</a></li>
                <li><a class="{{Route::current()->getName() == 'pb' ? 'active' : ''}}"
                       href="{{route('pb', $clan->id)}}">PB Leaderboard</a></li>
            </ul>
        </div>
        <a href="{{route('clanlanding-page', $clan->name)}}"
           class="btn btn-ghost normal-case text-xl">{{$clan->name}}</a>


    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal p-0">
            <li><a class="{{Route::current()->getName() == 'collection-logs' ? 'active' : ''}}"
                   href="{{route('collection-logs', $clan->id)}}">Collection
                    Log Leaderboard</a>
            </li>
            <li><a class="{{Route::current()->getName() == 'pb' ? 'active' : ''}}"
                   href="{{route('pb', $clan->id)}}">PB Leaderboard</a>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        <label class="label invisible md:visible ">Pick a theme</label>
        <select class="select" data-choose-theme>
            <option disabled selected>Pick A theme</option>
            @foreach($themeNames as $themeName)
                <option value="{{$themeName}}">{{$themeName}}</option>
            @endforeach

        </select>
    </div>
</div>
