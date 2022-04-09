<x-main-layout :clan="$clan">
    <x-slot name="content">
        <div class="hero min-h-screen bg-base-200">
            <div class="hero-content text-center ">
                <div class="max-w-full   ">
                    <h1 class="text-5xl font-bold">Welcome to {{$clan->name}}</h1>
                    {{--                    <p class="py-6">Enter at your own risk. Gnomes can't reach your shoulder but can bite.</p>--}}
                    <div class="flex justify-center">
                        @isset($clan->discord_server_id)
                            <iframe src="https://discord.com/widget?id={{$clan->discord_server_id}}&theme=dark&username="
                                    width="350"
                                    height="500" allowtransparency="true" frameborder="0"
                                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"
                                    class="py-6"></iframe>

                        @endisset

                    </div>
                </div>
            </div>
        </div>


        <!-- Put this part before </body> tag -->
        <input type="checkbox" id="new-clan-modal" class="modal-toggle">
        <div @class(['modal', 'modal-open' => $new]) id="new-clan">
            <div class="modal-box relative">
                <label onclick="hideModal()" for="new-clan-modal"
                       class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>

                <h3 class="font-bold text-lg">Welcome to Trackscape {{$clan->name}}!</h3>
                <p class="py-4">This is your clan's landing page. Below, you will see a code used inside the Chat log
                    plugin. This code is registered to your clan and how we identify you. Not everything on this site
                    needs chat log data, but you will find that it enriches the
                    overall experience, and many things like Leaderboards depends on it. For more information on setting
                    it up, please check our FAQ.
                </p>

                <div class="mockup-code">
                    <pre><code>{{$clan->confirmation_code}}</code></pre>
                </div>
                <div class="modal-action">
                    <label onclick="hideModal()" for="new-clan-modal" class="btn">Close</label>
                </div>
            </div>
        </div>
    </x-slot>


</x-main-layout>

<script>
    function hideModal() {
        document.getElementById('new-clan').classList.remove('modal-open')
    }
</script>


{{--<x-main-layout :clan="$clan">--}}
{{--    <x-slot name="content">--}}
{{--        <div class="container mx-auto md:mx-6 mt-0">--}}
{{--            <div class="hero min-h-screen bg-base-200">--}}
{{--                <div class="hero-content text-center">--}}
{{--                    <div class="max-w-md">--}}
{{--                        <h1 class="text-5xl font-bold">{{$clan->name}}</h1>--}}
{{--                        @isset($clan->discord_server_id)--}}
{{--                            <iframe src="https://discord.com/widget?id={{$clan->discord_server_id}}&theme=dark&username="--}}
{{--                                    width="350"--}}
{{--                                    height="500" allowtransparency="true" frameborder="0"--}}
{{--                                    sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"--}}
{{--                                    class="mt-3"></iframe>--}}

{{--                        @endisset--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </x-slot>--}}
{{--</x-main-layout>--}}
