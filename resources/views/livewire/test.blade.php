<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <button type="submit">
            Submit
        </button>
    </form>
    <input wire:model="search" type="text" placeholder="Search users..."/>


    <ul>

        @foreach($users as $user)

            <li>{{ $user->username }}</li>

        @endforeach

    </ul>
</div>
