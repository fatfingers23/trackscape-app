<?php

namespace App\Http\Livewire;

use Filament\Forms;
use App\Models\RunescapeUser;
use App\Models\User;
use Livewire\Component;

class Test extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $search = '';

    public function render()
    {

        return view('livewire.test',
            [
                'users' => RunescapeUser::where('username', $this->search)->get(),

            ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('search')->required(),

            // ...
        ];
    }
}
