<?php

namespace App\Livewire;

use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class WithdrawalsAdminTableEnhanced extends DataTableComponent
{
    protected $model = Withdrawal::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPageName('withdrawals')
            ->setDefaultSort('created_at', 'desc')
            ->setAdditionalSelects(['withdrawals.user_id as user_id']);
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
            Column::make('UserID, Name')
                ->label(function ($row, Column $column) {
                    $user = User::find($row->user_id);
                    $user_data = "<div>$user->id: $user->name<br>$user->email";
                    return $user_data;
                })->html(),
            Column::make('R$', 'amount')
                ->sortable()
                ->searchable(),
            Column::make('Pass Value', 'amount_final')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')
                ->sortable(),
            Column::make('Comment', 'comment')
                ->sortable(),
            Column::make('Created', 'created_at')
                ->searchable()
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
