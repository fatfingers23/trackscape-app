<x-main-layout :clan="$clan">
    <x-slot name="content">
        <div class="py-12 text-center mx-0 md:mx-10">
            <h1 class="md:text-600 md:text-5xl text-3xl font-bold">
                Member List
            </h1>
            <div class="mt-10 text-center">
                <livewire:member-list :clan="$clan"/>
            </div>
        </div>
    </x-slot>
</x-main-layout>
