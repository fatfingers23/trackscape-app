<x-main-layout :clan="$clan">
    <x-slot name="content">
        <div class="container mx-auto md:mx-6 mt-0">
            <div class="hero min-h-screen bg-base-200">
                <div class="hero-content text-center">
                    <div class="max-w-md">
                        <h1 class="text-5xl font-bold">{{$clan->name}}</h1>
                        <iframe src="https://discord.com/widget?id={{$clan->discord_server_id}}&theme=dark&username="
                                width="350"
                                height="500" allowtransparency="true" frameborder="0"
                                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"
                                class="mt-3"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </x-slot>
</x-main-layout>
