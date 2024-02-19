<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntakeResource\Pages;
use App\Filament\Resources\IntakeResource\RelationManagers;
use App\Models\Intake;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntakeResource extends Resource
{
    protected static ?string $model = Intake::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 17;
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpan('full'),
                DatePicker::make('date')
                    ->required()
                    ->columnSpan('full')
                    ->native(true),
                Forms\Components\Toggle::make('active')
                    ->label('Visible')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100])
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make()->label('')->slideOver()->modalWidth('md'),
                // Tables\Actions\DeleteAction::make(),
                // ]),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->slideOver()->modalWidth('md'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageIntakes::route('/'),
        ];
    }
}
