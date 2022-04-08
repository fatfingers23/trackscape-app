<div>
    <form wire:submit.prevent="create">
        {{ $this->form }}


        <div class="form-control">
            <label for="signup-info-modal" class="link modal-button">Why do we need this information?</label>

        </div>
        <div class="form-control mt-6">

            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="signup-info-modal" class="modal-toggle">
    <label for="signup-info-modal" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            <x-faq-info-needed/>

        </label>
    </label>
</div>
