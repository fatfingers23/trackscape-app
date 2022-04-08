<x-main-layout>
    <x-slot name="content">
        <div class="py-12 text-center mx-0 md:mx-10 min-h-screen">
            <h1 class="md:text-600 md:text-5xl text-3xl font-bold">
                FAQs
            </h1>
            <div class="mt-10">
                <div class="container mx-auto text-left">
                    <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box">
                        <input type="checkbox" class="peer">

                        <div class="collapse-title text-xl font-medium peer-checked:text-secondary-content">
                            Why do you need all of this information to sign up?
                        </div>
                        <div class="collapse-content peer-checked:text-secondary-content text-left">
                            <x-faq-info-needed/>
                        </div>
                    </div>

                    <div tabindex="0"
                         class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box my-6">
                        <input type="checkbox" class="peer">

                        <div class="collapse-title text-xl font-medium peer-checked:text-secondary-content">
                            How do i set up chat log?
                        </div>
                        <div class="collapse-content peer-checked:text-secondary-content text-left">
                            <p class="py-4">We use the RuneLite plug <a class="link"
                                                                        href="https://runelite.net/plugin-hub/show/chat-logger">Chat
                                    Logger</a> to record chat
                                logs. This is where we get information for leaderboards, new personal bests, new
                                collection log items, and more. The more who use it the better leaderboards work. Follow
                                the list below for set up instructions</p>
                            <ul class="list-decimal">
                                <li>Install the Chat Logger plugin to runelite.</li>
                                <li>Inside of the settings for the plugin make sure to have Clan Chat Checked and Remote
                                    Clan Chat under Remote Submission.
                                </li>
                                <li>For Authorization please use the code generated when you registered your clan.</li>
                                <li>For the Endpoint use: <label
                                            class="underline">https://trackscape.app/api/clan/chatlog</label></li>

                            </ul>
                            <div class="w-75 rounded-full">

                                <img src="{{asset('/images/chat_logger.png')}}"/>
                            </div>
                        </div>
                    </div>

                    <div tabindex="0"
                         class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box my-6">
                        <input type="checkbox" class="peer">

                        <div class="collapse-title text-xl font-medium peer-checked:text-secondary-content">
                            What information do you store?
                        </div>
                        <div class="collapse-content peer-checked:text-secondary-content text-left">
                            <p class="py-4">As of 4/7/2022 we do not store chat log data for extended time.We check for
                                any of the information that we use for our graphs then pass it along to discord.
                                Besides,
                                that
                                we store the information on registration, clan members, rank, joined date, and anything
                                else you see on public leaderboards.</p>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </x-slot>
</x-main-layout>
