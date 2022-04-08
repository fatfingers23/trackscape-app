<x-clan-menu :clan="$clan">
    <x-slot name="content">
        <div class="hero min-h-screen bg-base-200">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h1 class="text-5xl font-bold">Welcome to {{$clan->name}}</h1>
                    <p class="py-6"></p>
                    <button class="btn btn-primary">Get Started</button>
                </div>
            </div>
        </div>
    </x-slot>
</x-clan-menu>