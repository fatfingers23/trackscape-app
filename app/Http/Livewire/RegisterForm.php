<?php

namespace App\Http\Livewire;

use App\Models\Clan;
use App\Services\WOMService;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Livewire\Component;

class RegisterForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $clanname;
    public $discord_server_id;
    public $discord_webHook;
    public $wom_id;

    protected WOMService $womService;

    public function __construct($id = null)
    {
        $this->womService = new WOMService();
        parent::__construct($id);
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        $formFields = [
            TextInput::make('name')->
            required()->placeholder('Clan Name')->disableLabel()->maxLength(30)->different('clanName'),
            TextInput::make('wom_id')->required()->placeholder('Wise Old Man Group Id')->disableLabel()->numeric()
                ->rules([function () {
                    return function (string $attribute, $value, Closure $fail) {
                        $validWom = $this->womService->checkValidGroupId($value);
                        if (!$validWom) {
                            $fail("This is not a valid Wise Old Man group id.");
                        }
                    };
                }])->unique(),
            TextInput::make('discord_server_id')->placeholder('Discord Server Id')->disableLabel()->numeric()->maxLength(50),
            TextInput::make('discord_webHook')->placeholder('Discord Web Hook')->disableLabel()->url()->maxLength(255),

        ];

        foreach ($formFields as $field) {
            $field->extraInputAttributes(['class' => 'input']);
        }

        return $formFields;

    }


    public function create()
    {
        $values = $this->form->getState();
        $values['confirmation_code'] = uniqid();
        $clan = Clan::create($values);
        $this->redirectRoute('clanlanding-page', [$clan->name, true]);

    }


    public function render()
    {
        return view('livewire.register-form');
    }
}
