<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UsersTableEnhanced extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('users');
        $this->setDefaultSort('created_at', 'desc');
    }

    // public function delete($id)
    // {
    //     $user = User::where('id', $id)->first();
    //     $user->delete();
    //     // $this->refresh();
    // }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Robux', 'robux')
                ->sortable(),
            Column::make('Reg. Type', 'oauth_provider')
                ->sortable(),
            Column::make('Created', 'created_at')
                ->sortable(),
            // Column::make('Action')
            //     ->label(
            //         fn ($row, Column $column) => view('livewire.utilities.user-actions')->with(
            //             [
            //                 // 'viewLink' => route('users.view', $row),
            //                 // 'editLink' => route('users.edit', $row),
            //                 'rowData' => $row,
            //             ]
            //         )
            //     )->html(),

        ];
    }
}
