<?php

namespace App\Http\Livewire;


use App\Models\Clan;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;


class ClanSearch extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Clan::query();
    }

    public function render()
    {
        return view('livewire.clan-search');
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),

        ];
    }
    
}