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
                       href="#">Collection</a></li>

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
        <ul class="menu menu-horizontal p-0">
            <li><a class=" {{Route::current()->getName() == 'faq' ? 'active' : ''}}"
                   href="{{route('faq')}}">FAQ</a></li>
        </ul>
        {{--        <label class="label invisible md:visible ">Pick a theme</label>--}}
        <select class="select" data-choose-theme>
            <option disabled selected>Pick A theme</option>
            @foreach($themeNames as $themeName)
                <option value="{{$themeName}}">{{$themeName}}</option>
            @endforeach

        </select>
    </div>
</div>
