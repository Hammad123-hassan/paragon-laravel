<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Branch;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Awcodes\FilamentGravatar\GravatarProvider;
use Filament\Forms\Get;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 19;

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        if ($user->hasRole('Branch Manager')) {
            $branchId = $user->branches()->first()->id;
            $branchManagerCount = User::whereHas('roles', function ($query) {
                $query->where('id', 3); 
            })->whereHas('branches', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->count();
            return $branchManagerCount;
        } else {
            return static::getModel()::count();
        }
    }

    public static function getFilteredRoles()
    {
        

        if (auth()->user()->hasRole('Branch Manager')) {
            // If the user has the 'Branch Manager' role, return only the specific role(s) you want to show (e.g., role with ID 33).
            return Role::whereIn('id', [3])->pluck('name', 'id');
        } else {
            // For other roles, you can return all roles or any other logic you require.
            return Role::all()->pluck('name', 'id');
        }
    }

    public static function branch()
    {
        $user = auth()->user();
        if ($user->roles[0]->id == 1) {
            return Branch::where('active', 1)->pluck('name', 'id')->toArray();
        }
        //  dd($user->branches);
        return $user->branches->pluck('name', 'id')->toArray();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()

                    ->schema([
                        Forms\Components\Section::make('Personal Information')
                            ->schema([

                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('email')->email()
                                    ->required()
                                    ->disabledOn('edit')
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create'),
                                Forms\Components\TextInput::make('phone')->tel(),
                                Forms\Components\Select::make('roles')
                                    ->relationship('roles', 'name')
                                    ->options(self::getFilteredRoles())
                                    ->default(1)
                                    ->required()
                                    ->columnSpan('full')
                                    ->live(),
                                // Forms\Components\Select::make('position')->options(['Super Admin', 'Admission Manager', 'Counsellor'])->live(),

                                Forms\Components\Select::make('branches')
                                     ->options(self::branch())->columnSpan('full')->label('Branch')
                                    ->visible(fn (Get $get): bool => $get('roles') == 2 || $get('roles') == 3)->required()  ->live(),
                                Forms\Components\RichEditor::make('description')->columnSpan('full'),
                            ])

                            ->collapsible()
                            ->compact()
                            ->columns(2),


                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([

                        Forms\Components\Section::make('Profile Picture')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('photo')

                                    ->collection('profile-images')
                                    ->disableLabel()
                                    ->downloadable()
                                    ->image(),
                            ])
                            ->compact()
                            ->collapsible(),
                            Forms\Components\Section::make('Salary')
                            ->schema([
                                Forms\Components\TextInput::make('salary') ->numeric()->label('Salary'),
                                Forms\Components\TextInput::make('bank')->label('Bank'),
                                Forms\Components\TextInput::make('account_no')->label('Account Number'),
                            ])
                            ->compact()
                            ->collapsible(),
                        Forms\Components\Section::make('Visible')
                            ->schema([
                                Forms\Components\Toggle::make('active')
                                    ->label('Visible')
                                    // ->helperText('This student will be hidden from all admission channels.')
                                    ->default(true),

                                // Forms\Components\DatePicker::make('published_at')
                                //     ->label('Availability')
                                //     ->default(now())
                                //     ->required(),
                            ])
                            ->compact()
                            ->collapsible(),
                           

                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100])
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('photo')->collection('profile-images'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('branches.name')->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {

                        'Super Admin' => 'warning',
                        'Branch Manager' => 'success',
                        'Counsellor' => 'danger',
                    })
                    ->sortable()
                    ->label('Role')
                    ->toggleable(),
               
                Tables\Columns\TextColumn::make('email')->searchable()->sortable()->toggleable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->sortable()->toggleable(),
                Tables\Columns\IconColumn::make('active')->boolean()->toggleable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('branches')->relationship('branches', 'name')->preload()->label('Branch'),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Impersonate::make(),
                    Tables\Actions\EditAction::make()->label(''),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
