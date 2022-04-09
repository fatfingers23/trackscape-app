<?php

namespace App\Http\Livewire;

use App\Models\Clan;
use App\Models\RunescapeUser;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MemberList extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public Clan $clan;

    public function render()
    {
        return view('livewire.member-list');
    }

    protected function getTableQuery(): Builder
    {
        return RunescapeUser::query()->where('clan_id', $this->clan->id);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('username')->sortable(),
            Tables\Columns\TextColumn::make('rank')->sortable(),
            Tables\Columns\TextColumn::make('last_active')
                ->sortable()->date('m/d/Y'),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }


    protected function getTableFilters(): array
    {
        return [


            // ...
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }

}
