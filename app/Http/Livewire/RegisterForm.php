<?php

namespace App\Http\Livewire;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Livewire\Component;

class RegisterForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $clanname;
    public $discordServerId;
    public $discordWebHook;
    public $womId;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('clanname')->
            required()->placeholder('Clan Name')->disableLabel(),
            TextInput::make('womId')->required()->placeholder('Wise Old Man Group Id')->disableLabel()->numeric(),
            TextInput::make('discordServerId')->placeholder('Discord Server Id')->disableLabel()->numeric(),
            TextInput::make('discordWebHook')->placeholder('Discord Web Hook')->disableLabel()->url(),

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
