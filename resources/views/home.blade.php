<x-main-layout>
    <x-slot name="content">
        <div class="container">

            <div class="hero min-h-screen bg-base-200 w-full">
                <div class="hero-content flex-col lg:flex-row-reverse">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl font-bold">Trackscape</h1>
                        <div class=" py-6">
                            <p>Tooling for OSRS Clans!</p>
                            <ul class="pl-6 list-disc">
                                <li>Tracks clan activity</li>
                                <li>Clan landing page</li>
                                <li>Clan leaderboards</li>
                                <li>Chat Stream to discord</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
                        <div class="card-body">
                            {{--                            <livewire:register-form/>--}}
                            <livewire:test/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-main-layout>
