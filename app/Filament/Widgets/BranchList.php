<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Lead;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

namespace App\Filament\Widgets;

use App\Filament\Resources\BranchResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Models\Shop\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Squire\Models\Currency;
use Illuminate\Database\Eloquent\Builder;

class BranchList extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Branches';

    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        $user = auth()->user();
        if ($user->hasRole('Super Admin')) {
            return $table
                ->query(BranchResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->columns([

                    Tables\Columns\TextColumn::make('name')->sortable()->label('Branch Name'),


                ]);
        } else {
            return $table
                ->query(BranchResource::getEloquentQuery()->whereIn('id', $user->branches->pluck('id')->toArray()))
                ->defaultPaginationPageOption(5)
                ->columns([

                    Tables\Columns\TextColumn::make('name')->sortable()->label('Branch Name'),


                ]);
        }
    }
}
