<x-main-layout>
    <x-slot name="content">
        <div class="flex text-center mx-0 md:mx-10 justify-center">
            <div class="mt-10 w-1/2 content-center">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <!-- head -->
                        <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clans as $clan)
                            <tr>
                                <th><a href="{{route('clanlanding-page', $clan->name)}}">{{$clan->name}} </a></th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="flex justify-center items-center mt-5">

                        {{ $clans->links('vendor.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-main-layout>
