<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {

        $user = Auth::user();
        $tabs = [];
       
    
        if ($user->hasRole('Super Admin')) {
            $tabs['all'] = Tab::make('All Users')->badge(User::query()->count());
            $tabs['Super Admin'] = Tab::make('Super Admin')
                ->badge(User::query()->whereHas('roles', fn (Builder $query) => $query->where('id', 1))->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn (Builder $query) => $query->where('id', 1)));
                $tabs['Branch Manager'] = Tab::make('Branch Manager')
                ->badge(User::query()->whereHas('roles', fn (Builder $query) => $query->where('id', 2))->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn (Builder $query) => $query->where('id', 2)));
                $tabs['Counsellor'] = Tab::make('Counsellor')
                ->badge(User::query()->whereHas('roles', fn (Builder $query) => $query->where('id', 3))->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn (Builder $query) => $query->where('id', 3)));
        }
        if ($user->hasRole('Branch Manager')) {
            $branchId = $user->branches()->first()->id;
            $tabs['Counsellor'] = Tab::make('Counsellor')
                ->badge(User::query()
                    ->whereHas('roles', fn (Builder $query) => $query->where('id', 3))
                    ->whereHas('branches', fn (Builder $query) => $query->where('branch_id', $branchId))
                    ->count())
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereHas('roles', fn (Builder $query) => $query->where('id', 3))
                        ->whereHas('branches', fn (Builder $query) => $query->where('branch_id', $branchId))
                );
        }
        

        return $tabs;
        // return [
        //     'all' => Tab::make('All Users')->badge(User::query()->count()),
        //     'Super Admin' => Tab::make('Super Admin')
        //         ->badge(User::query()->whereHas('roles', function ($query) {
        //             $query->where('id', 1);
        //         })->count())
        //         ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) {
        //             $query->where('id', 1);
        //         })),
        //     'Admission Manager' => Tab::make('Branch Manager')
        //         ->badge(User::query()->whereHas('roles', function ($query) {
        //             $query->where('id', 2);
        //         })->count())
        //         ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) {
        //             $query->where('id', 2);
        //         })),
        //     'Counsellor' => Tab::make('Counsellor')
        //         ->badge(User::query()->whereHas('roles', function ($query) {
        //             $query->where('id', 3);
        //         })->count())
        //         ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) {
        //             $query->where('id', 3);
        //         })),
        // ];
    }
}
