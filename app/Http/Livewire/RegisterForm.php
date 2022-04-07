<?php

namespace App\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Livewire\Component;

class RegisterForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $clanname;


    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('clanname')->required(),
            // ...
        ];
    }

    public function submit(): void
    {
        // ...
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}
