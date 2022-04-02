<x-main-layout :clan="$clan">
    <x-slot name="content">
        <div class="py-12 text-center mx-0 md:mx-10">
            <h1 class="md:text-600 md:text-5xl text-3xl font-bold">
                Collection Log Leaderboard!
            </h1>
            <div class="mt-10 text-center">

                <table class="table w-full mt-7 ">
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
    </x-slot>
</x-main-layout>
