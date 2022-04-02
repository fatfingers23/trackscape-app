<x-main-layout :clan="$clan">
    @php

        function formatTime($time){
            $mins = floor($time / 60);
            $seconds = $time % 60;
            if($seconds < 10){
                $seconds = "0$seconds";
            }

            return "$mins:$seconds";
    }

    @endphp
    <x-slot name="content">
        <div class=" w-full">
            <h1 class="text-center  md:text-600 md:text-5xl text-3xl font-bold mt-3 mb-3">
                Personal Best Boss Times!
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-0 md:mx-6">
                @foreach($pbs as $boss)
                    <div class="card bg-primary text-primary-content mx-6 md:mx-0">
                        <div class="card-body ">
                            <h2 class="card-title">{{$boss->name}}</h2>
                            @php
                                $loopTimes = $boss->Pbs->count();
                                if($loopTimes > 5){
                                    $loopTimes = 5;
                                }
                            @endphp
                            <ul class="list-decimal">
                                @for($i = 0; $i < $loopTimes; $i++)

                                    <li>{{formatTime($boss->Pbs[$i]->kill_time)}}
                                        - {{$boss->Pbs[$i]->player->username}} </li>
                                @endfor
                            </ul>
                        </div>
                        @if($boss->Pbs->count() > 5)
                            <div tabindex="0" class="collapse">
                                <input type="checkbox" class="peer">
                                <div class="collapse-title bg-primary text-primary-content ">
                                    See the rest!
                                </div>
                                <div class="collapse-content bg-primary text-primary-content">
                                    <ul class="list-disc mx-2">
                                        @ray($boss->Pbs->count())
                                        @for($i = 5; $i < $boss->Pbs->count(); $i++)

                                            <li>{{formatTime($boss->Pbs[$i]->kill_time)}}
                                                - {{$boss->Pbs[$i]->player->username}} </li>
                                        @endfor

                                    </ul>
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-main-layout>
