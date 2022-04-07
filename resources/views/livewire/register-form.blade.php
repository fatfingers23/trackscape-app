<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}


        <div class="form-control">
            <label for="signup-info-modal" class="link modal-button">Why do you need this information?</label>

        </div>
        <div class="form-control mt-6">

            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="signup-info-modal" class="modal-toggle">
    <label for="signup-info-modal" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <h3 class="text-lg font-bold"> We know sharing information can be scary. That is why we are as open as
                possible and try to share as
                much information on why we need the items below.</h3>
  
            <p class="py-4"><span class="underline">Wise Old Man Id</span> -
                Our website uses discord Wise Old Man Groups to track clan mates. From this, we can find clan members,
                detect name changes, and help keep attendance records. You can find your WOM id on the left panel of
                your groups' page. At this point this is required.
            <p class="py-4"><span class="underline">Discord Server id</span> -
                is used to populate the discord widget on your clan's landing page. In addition, our website will use
                the id in future updates to direct traffic from the discord bot. This is optional. You can find your
                discord id by following <a class="link"
                                           href="https://support.discord.com/hc/en-us/articles/206346498-Where-can-I-find-my-User-Server-Message-ID-">these
                    directions.</a></p>
            <p class="py-4"><span class="underline">Discord Web Hook</span> -
                Our website uses discord Web Hook to forward in-game messages to your Discord and future notifications.
                This is optional.
            </p>

            <p class="py-4">You've been selected for a chance to get one year of subscription to use Wikipedia for
                free!</p>
        </label>
    </label>
</div>
