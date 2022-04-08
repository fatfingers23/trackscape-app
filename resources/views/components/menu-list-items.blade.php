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

