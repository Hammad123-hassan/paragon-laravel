<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Lead;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

namespace App\Filament\Widgets;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

use App\Filament\Resources\BranchResource;
use App\Filament\Resources\Shop\OrderResource;
use App\Filament\Resources\StudentCaseResource;
use App\Models\Shop\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Squire\Models\Currency;
use Illuminate\Database\Eloquent\Builder;

class CaseRegister extends BaseWidget
{

    // protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Cases';

    // protected static ?int $sort = 10;


    public function table(Table $table): Table
    {
        $user = auth()->user();
        if ($user->roles[0]->id == 1) {
            return $table
                ->query(StudentCaseResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->defaultSort('id', 'desc')
                ->columns([
                    Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Name'),                    
                    Tables\Columns\BadgeColumn::make('status')->sortable()->searchable()->label('Status'), 
                    Tables\Columns\TextColumn::make('phone')->sortable()->searchable()->label('Phone'),
                    Tables\Columns\TextColumn::make('email')->sortable()->searchable()->label('Email'),                   
                    
                ])->bulkActions([
                    ExportBulkAction::make()
                    //     Tables\Actions\BulkActionGroup::make([
                    //         Tables\Actions\DeleteBulkAction::make(),
                    //     ]),
                ]);
        }
        if ($user->roles[0]->id == 3) {
            return $table
                ->query(StudentCaseResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->columns([

                    Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Name'),                    
                    Tables\Columns\BadgeColumn::make('status')->sortable()->searchable()->label('Status'), 
                    Tables\Columns\TextColumn::make('phone')->sortable()->searchable()->label('Phone'),
                    Tables\Columns\TextColumn::make('email')->sortable()->searchable()->label('Email'), 


                ]);
        } else {

            $branchesId = $user->branches->pluck('id')->toArray();

            return $table
                ->query(StudentCaseResource::getEloquentQuery())
                ->defaultPaginationPageOption(5)
                ->columns([

                    Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Name'),                    
                    Tables\Columns\BadgeColumn::make('status')->sortable()->searchable()->label('Status'), 
                    Tables\Columns\TextColumn::make('phone')->sortable()->searchable()->label('Phone'),
                    Tables\Columns\TextColumn::make('email')->sortable()->searchable()->label('Email'), 


                ]);
        }
    }
}