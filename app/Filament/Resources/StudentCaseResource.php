<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\StudentCaseResource\Pages\CreateStudentCase;
use App\Filament\Resources\StudentCaseResource\Pages\EditStudentCase;
use App\Filament\Resources\StudentCaseResource\Pages\ViewStudentCase;
use App\Filament\Resources\StudentCaseResource\Pages\ListStudentCase;
use App\Filament\Resources\StudentCaseStat\Widgets\StudentCaseStat;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Intake;
use App\Models\Interview;
use App\Models\VisaApplication;
use App\Models\VisaDecision;
use App\Models\Cas;
use App\Models\StudentCase;
use App\Models\LeadUniversity;
use App\Models\University;
use App\Models\User;
use App\Tables\Columns\ProgressBar;
use App\Tables\Columns\CaseStatus;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

use Ysfkaya\FilamentPhoneInput\Tables\PhoneInputColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Illuminate\Support\HtmlString;

class StudentCaseResource extends Resource
{

    protected $listeners = ['refresh' => 'refreshForm'];
    protected static ?string $model = StudentCase::class;
    // protected static ?int $navigationSort = 7;
    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 2;



    public static function getLock($uni)
    {
        $applied = LeadUniversity::where('student_case_id', $uni)->where('applied_uni', 1)->first();
        if ($applied) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getEvidence($uni)
    {
        $case = StudentCase::where('id', $uni)->first();
        if ($case?->date_of_deposit && $case->maturity_date) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getInterview($uni)
    {

        $case = Interview::where('student_case_id', $uni)->first();


        if ($case?->schedule_date && $case->mock_interview_date && $case->official_interview_date && $case->result_date) {
            // dd('asd');
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getCas($uni)
    {
        $case = Cas::where('student_case_id', $uni)->first();

        if ($case?->request_date && $case->receive_date) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }
    public static function getVisaApp($uni)
    {
        $case = VisaApplication::where('student_case_id', $uni)->first();
        if ($case?->date_of_application && $case->date_of_apppointment) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getVisaDesc($uni)
    {
        $case = VisaDecision::where('student_case_id', $uni)->first();

        if ($case?->date_of_decision && $case?->status) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getcolLock($uni)
    {
        $applied = LeadUniversity::where('student_case_id', $uni)->where('col', 1)->first();
        if ($applied) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }

    public static function getuol($uni)
    {
        $applied = LeadUniversity::where('student_case_id', $uni)->where('uol', 1)->first();
        if ($applied) {
            return 'heroicon-m-check-badge';
        } else {
            return 'heroicon-m-x-circle';
        }
    }



    public static function branch()
    {
        $user = auth()->user();
        if ($user->roles[0]->id == 1) {
            return Branch::where('active', 1)->pluck('name', 'id')->toArray();
        }
        // dd($user->branches);
        return $user->branches->pluck('name', 'id')->toArray();
    }


    public static function field()
    {
    }


    protected static ?string $navigationIcon = 'heroicon-o-folder-plus';

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();
        if ($user->roles[0]->id == 3) {

            return static::getModel()::where('created_by', $user->id)->count();
        }

        if ($user->roles[0]->id == 2) {
            $branchesId = $user->branches->pluck('id')->toArray();
            return static::getModel()::whereIn('branch_id', $branchesId)->count();
        }
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Group::make()

                    ->schema([
                        Forms\Components\Section::make('Personal Information')
                            ->schema([
                                Forms\Components\Select::make('branch_id')
                                    ->required()
                                    ->live()
                                    ->options(self::branch())->label('Branch')->hidden(auth()->user()->roles[0]['id'] == 3),
                                Forms\Components\Select::make('created_by')
                                    ->required()
                                    ->options(function (Get $get) {

                                        $branch = Branch::find($get('branch_id'));
                                        if ($branch) {

                                            $users = $branch->users->pluck('id');
                                            return User::whereIn('id', $users)->whereHas('roles', function ($query) {
                                                $query->where('id', 3);
                                            })->pluck('name', 'id');
                                        }
                                    })->label('Counsellor')->hidden(auth()->user()->roles[0]['id'] == 3),
                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('email')->unique(ignoreRecord: true)
                                    ->required(),
                                Forms\Components\TextInput::make('phone')->tel(),
                                Forms\Components\Select::make('intake_id')
                                    ->required()
                                    // ->searchable()
                                    ->options(Intake::where('active', 1)->pluck('name', 'id')->toArray())->label('Intake'),
                                Forms\Components\TextInput::make('adventus_id')->label('Adventus ID')->hiddenOn('create'),
                                Forms\Components\TextInput::make('group_agent')->label('Group Agent')->hiddenOn('create'),
                                Forms\Components\TextInput::make('consultancy_fee')->label('Consultancy_fee')->numeric()->label('Consultancy Fee'),
                                // Forms\Components\Group::make(),
                                Forms\Components\TextInput::make('full_fee')->label('Full Fee')->live('blur')
                                    ->hidden(function (Get $get) {
                                        $dataCollection = collect($get('universities'));
                                        $uol = $dataCollection->where('uol', 1)->first();
                                        if (!$uol) {
                                            return true;
                                        }
                                    })->afterStateUpdated(function (Get $get, Set $set) {
                                        $fullFee = intval($get('full_fee'));
                                        $scholarshipDiscount = intval($get('scholarship_discount'));
                                        if ($get('full_fee') == '') {
                                            $scholarshipDiscount = null;
                                            $set('scholarship_discount', $scholarshipDiscount);
                                        }
                                        $scholarshipDiscount = $get('scholarship_discount');
                                        $feeAfterDiscount = $fullFee - $scholarshipDiscount;
                                        $feeAfterDiscount = max(0, $feeAfterDiscount);
                                        $set('scholarship_discount', $scholarshipDiscount);
                                        $set('after_scholarship', $feeAfterDiscount);
                                    }),
                                Forms\Components\TextInput::make('scholarship_discount')->label('Scholarship Discount')->live('blur')->hidden(function (Get $get) {
                                    $dataCollection = collect($get('universities'));
                                    $uol = $dataCollection->where('uol', 1)->first();
                                    if (!$uol) {
                                        return true;
                                    }
                                })->afterStateUpdated(function (Get $get, Set $set) {
                                    $fullFee = intval($get('full_fee'));
                                    $scholarshipDiscount = intval($get('scholarship_discount'));
                                    if ($get('full_fee') == '') {
                                        $scholarshipDiscount = null;
                                        $set('scholarship_discount', $scholarshipDiscount);
                                    }
                                    $scholarshipDiscount = $get('scholarship_discount');
                                    $feeAfterDiscount = $fullFee - (int)$scholarshipDiscount;
                                    $feeAfterDiscount = max(0, $feeAfterDiscount);
                                    $set('scholarship_discount', $scholarshipDiscount);
                                    $set('after_scholarship', $feeAfterDiscount);
                                }),
                                Forms\Components\TextInput::make('after_scholarship')->label('After Scholarship')->hidden(function (Get $get) {
                                    $dataCollection = collect($get('universities'));
                                    $uol = $dataCollection->where('uol', 1)->first();
                                    if (!$uol) {
                                        return true;
                                    }
                                })->readonly(),
                                Forms\Components\RichEditor::make('description')->columnSpan('full'),
                            ])
                            // ->collapsed()
                            ->compact()
                            ->columns(3),
                        ///
                        Forms\Components\Section::make('Preferred universities')
                            ->schema([
                                TableRepeater::make('universities')
                                    ->relationship()
                                    ->collapsible()
                                    ->withoutHeader()

                                    ->label('')

                                    ->hideLabels()
                                    ->schema([
                                        Forms\Components\Select::make('country_id')->options(Country::where('active', 1)->pluck('name', 'id')->toArray())->placeholder('Select country')->live(),
                                        Forms\Components\TextInput::make('university_student_id')->placeholder('Student ID'),
                                        // Forms\Components\Select::make('degrees')->options(Degree::where('active', 1)->pluck('name', 'id')->toArray())->multiple()->label('Apply For Degree')->columnSpan('full'),
                                        Forms\Components\Select::make('university_id')->options(University::where('active', 1)->pluck('name', 'id')->toArray())->placeholder('Select university')
                                            ->options(function (Get $get) {
                                                return University::where('country_id', $get('country_id'))->where('active', 1)->pluck('name', 'id');
                                            })->required(),
                                        // Forms\Components\TextInput::make('applied_url'),
                                        // Forms\Components\Select::make('admitted')->options(['Admitted', 'Not Admitted']),
                                        Forms\Components\Select::make('degree_id')->options(Degree::where('active', 1)->pluck('name', 'id')->toArray())->placeholder('Select degree')->required(),
                                    ])->columns(3)->addActionLabel('Add more university'),
                            ])

                            // ->collapsed()
                            ->compact()
                            ->columns(1),
                        ////
                    ])
                    ->columnSpan(['lg' => 3]),
                // Forms\Components\Group::make()
                //     ->schema([
                //         // waqar
                //     ])
                //     ->columnSpan(['lg' => 1]),
                ////
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('ADM APP')
                            ->icon(function (Get $get) {
                                return self::getLock($get('id'));
                            })
                            ->schema([
                                Forms\Components\DatePicker::make('applied_date')->label('Applied Date')->columnSpan('full'),
                                Forms\Components\CheckboxList::make('app_option')
                                    ->options(function (Get $get) {
                                        $uni = collect($get('universities'))->pluck('university_id')->toArray();
                                        $getUni = University::whereIn('id', $uni)->pluck('name', 'id');

                                        return $getUni;
                                    })->label('')
                                    ->descriptions(function (Get $get) {
                                        $degreeId = collect($get('universities'))->toArray();

                                        foreach ($degreeId as $key => $item) {

                                            $getDegree = Degree::find($item['degree_id']);
                                            $getCountry = Country::find($item['country_id']);
                                            if ($getDegree) {
                                                $degree[$item['university_id']] = new HtmlString($getDegree->name . '<br>' . "<p>$getCountry->name</p>");
                                            }
                                        }

                                        return $degree;
                                    })->columns(2),
                            ]),
                        Tabs\Tab::make('COL')
                            ->icon(function (Get $get) {
                                return self::getcolLock($get('id'));
                            })
                            ->schema([
                                Forms\Components\DatePicker::make('col_date')->label('COL Date')->columnSpan('full'),
                                Forms\Components\CheckboxList::make('col_option')
                                    ->options(function (Get $get) {
                                        $uni = collect($get('universities'))->pluck('university_id')->toArray();
                                        $getUni = University::whereIn('id', $uni)->pluck('name', 'id');

                                        return $getUni;
                                    })->label('')
                                    ->descriptions(function (Get $get) {
                                        $degreeId = collect($get('universities'))->toArray();

                                        foreach ($degreeId as $key => $item) {

                                            $getDegree = Degree::find($item['degree_id']);
                                            $getCountry = Country::find($item['country_id']);
                                            if ($getDegree) {
                                                $degree[$item['university_id']] = new HtmlString($getDegree->name . '<br>' . "<p>$getCountry->name</p>");
                                            }
                                        }

                                        return $degree;
                                    })->columns(2),
                                Forms\Components\RichEditor::make('offer_letter_condition')->columnSpan('full'),
                            ])->disabled(function (Get $get) {
                                $dataCollection = collect($get('app_option'));
                                // dd($dataCollection);
                                // $getData = $dataCollection->where('col_option', 1)->first();

                                if (count($dataCollection) == 0) {
                                    return true;
                                }
                            }),

                        Tabs\Tab::make('UOL')
                            ->icon(function (Get $get) {
                                return self::getuol($get('id'));
                            })
                            ->schema([
                                Forms\Components\DatePicker::make('uol_date')->label('Received Date')->columnSpan('full'),
                                Forms\Components\Radio::make('uol_option')
                                    ->options(function (Get $get) {
                                        $uni = collect($get('universities'))->where('col', 1)->pluck('university_id')->toArray();
                                        $getUni = University::whereIn('id', $uni)->pluck('name', 'id');

                                        return $getUni;
                                    })->label('')
                                    ->descriptions(function (Get $get) {
                                        $degreeId = collect($get('universities'))->toArray();

                                        foreach ($degreeId as $key => $item) {

                                            $getDegree = Degree::find($item['degree_id']);
                                            $getCountry = Country::find($item['country_id']);
                                            if ($getDegree) {
                                                $degree[$item['university_id']] = new HtmlString($getDegree->name . '<br>' . "<p>$getCountry->name</p>");
                                            }
                                        }

                                        return $degree;
                                    })->columns(2)

                                // TableRepeater::make('universities')
                                //     ->relationship()
                                //     ->addable(false)
                                //     ->deletable(false)
                                //     ->collapsible()
                                //     ->label('')
                                //     ->hideLabels()
                                //     ->schema([
                                //         // Forms\Components\Checkbox::make('applied_uni')->inline()->label('Applied')->hidden(),
                                //         Forms\Components\Checkbox::make('col')->inline()->label('COL')->hidden(),
                                //         Forms\Components\Checkbox::make('uol')->inline()->label('UOL'),
                                //         // ->afterStateUpdated(function ($state, $set) {
                                //         //     if ($state) {
                                //         //         $set('uol', false);
                                //         //     }
                                //         // }),
                                //         Forms\Components\Select::make('university_id')->options(University::where('active', 1)->pluck('name', 'id')->toArray())->disabled()->label('University'),
                                //         Forms\Components\Select::make('degree_id')->label('Degree')->options(Degree::where('active', 1)->pluck('name', 'id')->toArray())->placeholder('Select degree')->disabled(),
                                //     ])
                                //     ->columns(3),
                            ])->disabled(function (Get $get) {
                                $dataCollection = collect($get('col_option'));
                                // $getData = $dataCollection->where('applied_uni', 1)->first();
                                // $col = $dataCollection->where('col', 1)->first();
                                if (count($dataCollection) == 0) {
                                    return true;
                                }
                            }),
                        Tabs\Tab::make('BANK STATEMENT')
                            ->icon(function (Get $get) {
                                return self::getEvidence($get('id'));
                            })
                            ->schema([
                                Forms\Components\DatePicker::make('date_of_deposit'),
                                Forms\Components\DatePicker::make('maturity_date'),
                                SpatieMediaLibraryFileUpload::make('evidence')
                                    ->collection('evidence')
                                    ->openable()
                                    ->downloadable()
                                    ->placeholder('Evidence')
                                    ->image(),
                            ])->columns(3)
                        // ->disabled(function (Get $get) {
                        //     $dataCollection = collect($get('uol_option'));
                        //     // $getData = $dataCollection->where('applied_uni', 1)->first();
                        //     // $col = $dataCollection->where('col', 1)->first();
                        //     if (count($dataCollection) == 0) {
                        //         return true;
                        //     }
                        // })
                        ,

                        Tabs\Tab::make('INTERVIEW')
                            ->icon(function (Get $get) {
                                return self::getInterview($get('id'));
                            })
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('interview')
                                    ->schema([
                                        Forms\Components\Checkbox::make('status')->inline()->label('Passed')->columnSpan('full')->disabled(function (Get $get, Set $set) {


                                            $resultDate = $get('result_date');
                                            if (!$resultDate) {
                                                $set('status', null);
                                                return true;
                                            }
                                        }),
                                        Forms\Components\DatePicker::make('schedule_date')->label('Schedule Date'),
                                        Forms\Components\DatePicker::make('mock_interview_date')->label('Mock Interview Date'),
                                        Forms\Components\DatePicker::make('official_interview_date')->label('Official Interview Date'),
                                        Forms\Components\DatePicker::make('result_date')->label('Result Date')->live(),

                                    ])->columns(4),
                            ])->disabled(function (Get $get) {
                                $bankStateDateOfDeposit  = $get('date_of_deposit');
                                $bankStateMaturityDate  = $get('maturity_date');
                                if ((!$bankStateDateOfDeposit  || !$bankStateMaturityDate)) {
                                    return true;
                                }
                            }),
                        Tabs\Tab::make('CAS')
                            ->icon(function (Get $get) {
                                return self::getCas($get('id'));
                            })
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('cas')
                                    ->schema([
                                        Forms\Components\Checkbox::make('cas_request')->inline()->label('CAS Request'),
                                        Forms\Components\Checkbox::make('cas_receive')->inline()->label('CAS Received'),
                                        Forms\Components\DatePicker::make('request_date')->label('Request Date'),
                                        Forms\Components\DatePicker::make('receive_date')->label('Receive Date'),
                                        SpatieMediaLibraryFileUpload::make('cas')
                                            ->collection('cas')
                                            ->openable()
                                            ->downloadable()
                                            ->label('')
                                            ->columnSpan('full')
                                            ->placeholder('Upload CAS Document')
                                            ->required(function (Get $get) {

                                                $receive_date  = $get('receive_date');
                                                if ($receive_date) {
                                                    return true;
                                                }
                                            }),

                                    ])->columns(2),
                            ])
                        // ->disabled(function (Get $get) {
                        //     $interview = $get('interview');
                        //     if ((!$interview['schedule_date']  || !$interview['mock_interview_date']
                        //         || !$interview['official_interview_date'] || !$interview['result_date'])) {

                        //         return true;
                        //     }
                        // })
                        ,
                        Tabs\Tab::make('VISA APP')
                            ->icon(function (Get $get) {
                                return self::getVisaApp($get('id'));
                            })
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('visaApplpication')
                                    ->schema([
                                        Forms\Components\Checkbox::make('applied')->inline()->label('Applied')->columnSpan('full'),
                                        Forms\Components\DatePicker::make('date_of_application')->label('Application Date'),
                                        Forms\Components\DatePicker::make('date_of_apppointment')->label('Appointment Date'),

                                    ])->columns(2),
                            ])->disabled(function (Get $get) {
                                $cas = $get('cas');
                                if ((!$cas['request_date']  || !$cas['receive_date'])) {

                                    return true;
                                }
                            }),
                        Tabs\Tab::make('VISA DECISION')

                            ->icon(function (Get $get) {
                                return self::getVisaDesc($get('id'));
                            })
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('visaDecision')
                                    ->schema([
                                        Forms\Components\Radio::make('status')
                                            ->options([
                                                'Pending' => 'Pending',
                                                'Approved' => 'Approved',
                                                'Refused' => 'Refused',
                                            ])

                                            ->columns(3),
                                        // Forms\Components\Checkbox::make('pending')->inline()->label('Pending')->live(),
                                        // Forms\Components\Checkbox::make('successful')->inline()->label('Successful'),
                                        // Forms\Components\Checkbox::make('refused')->inline()->label('Refused')->live(),
                                        Forms\Components\DatePicker::make('date_of_decision')->label('Decision Date')->columnSpan('full'),
                                        SpatieMediaLibraryFileUpload::make('visa')
                                            ->collection('visa')
                                            ->openable()
                                            ->downloadable()
                                            ->label('')
                                            ->columnSpan('full')
                                            ->placeholder('Upload Visa Sticker')
                                            ->required(function (Get $get) {

                                                $status  = $get('status');
                                                if ($status == 'Approved') {
                                                    return true;
                                                }
                                            })
                                            ->image(),

                                    ])->columns(3)
                                // ->disabled(function (Get $get) {
                                //     $visaApplpication = $get('visaApplpication');
                                //     if ((!$visaApplpication['date_of_application']  || !$visaApplpication['date_of_apppointment'])) {

                                //         return true;
                                //     }
                                // }),
                            ]),
                    ])
                    // ->contained(false)
                    ->columnSpan('full')->hiddenOn('create')

            ])->columns(3);
    }
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();



        if ($user->roles[0]->id == 1) {
            return parent::getEloquentQuery();
        }
        if ($user->roles[0]->id == 3) {
            return parent::getEloquentQuery()->where('created_by', $user->id);
        } else {

            $branchesId = $user->branches->pluck('id')->toArray();

            return parent::getEloquentQuery()->whereIn('branch_id', $branchesId);
        }
    }
    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Case #')->searchable()->sortable()->toggleable()
                    ->size(TextColumn\TextColumnSize::ExtraSmall),

                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('branch.name')->label('Branch')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable()->toggleable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->limit(10)

                    ->copyable()
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('intake.name')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall),
                ProgressBar::make('created_by')->label('Progress'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'danger' => fn ($state) => in_array($state, ['NEW']),
                        'warning' => fn ($state) => in_array($state, ['ADM APP']),
                        'success' => fn ($state) => in_array($state, ['COL', 'UOL']),

                    ])->size(TextColumn\TextColumnSize::ExtraSmall),


                CaseStatus::make('case_status')->toggleable()->label('Case Status'),
                PhoneInputColumn::make('phone')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall)->copyable(),







                PhoneInputColumn::make('created_at')->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall)->dateTime('d-m-Y')->label('Created Date'),
                // \Filament\Tables\Columns\SelectColumn::make('case_status')
                // ->options([
                //     'aborted' => 'aborted',

                // ])
                Tables\Columns\TextColumn::make('updatedUser.name')->label('Updated By')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('updated_at')->searchable()->sortable()->toggleable()->size(TextColumn\TextColumnSize::ExtraSmall)->dateTime('d-m-Y')->label('Updated Date'),

               
                

            ])
            ->filters([

                SelectFilter::make('branch_id')->options(self::branch())->preload()->label('Branch')->visible(function () {
                    if (auth()->user()->hasRole('Super Admin')) {
                        return true;
                    }
                }),
                SelectFilter::make('created_by')->options(User::whereHas('roles', function ($query) {
                    $query->where('id', 3);
                })->pluck('name', 'id'))->label('Counsellor')->preload()->visible(function () {
                    if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Branch Manager')) {
                        return true;
                    }
                }),

                // SelectFilter::make('university_id')->options(University::where('active', 1)->pluck('name', 'id'))->label('University'),

                SelectFilter::make('university')
                    ->form([
                        Forms\Components\Select::make('university_id')->label('University')
                            ->options(University::where('active', 1)->pluck('name', 'id'))->multiple(),

                    ])

                    ->query(function (Builder $query, array $data): Builder {

                        $nesquery = $data['university_id'] ?? null;
                        if ($nesquery) {
                            return  $query->whereHas('universities', function ($subquery) use ($nesquery) {
                                $subquery->whereIn('university_id', $nesquery);
                            });
                        } else {
                            return $query;
                        }
                    }),


                SelectFilter::make('degree')
                    ->form([
                        Forms\Components\Select::make('degree_id')->label('Degree')
                            ->options(Degree::where('active', 1)->pluck('name', 'id'))->multiple(),

                    ])

                    ->query(function (Builder $query, array $data): Builder {

                        $nesquery = $data['degree_id'] ?? null;

                        if ($nesquery) {
                            return  $query->whereHas('universities', function ($subquery) use ($nesquery) {
                                $subquery->whereIn('degree_id', $nesquery);
                            });
                        } else {
                            return $query;
                        }
                    }),


                SelectFilter::make('country')
                    ->form([
                        Forms\Components\Select::make('country_id')->label('Country')
                            ->options(Country::where('active', 1)->pluck('name', 'id'))->multiple(),

                    ])

                    ->query(function (Builder $query, array $data): Builder {

                        $nesquery = $data['country_id'] ?? null;

                        if ($nesquery) {
                            return  $query->whereHas('universities', function ($subquery) use ($nesquery) {
                                $subquery->whereIn('country_id', $nesquery);
                            });
                        } else {
                            return $query;
                        }
                    }),



                SelectFilter::make('intake')->relationship('intake', 'name')->preload()->label('Intake'),
                SelectFilter::make('status')->options(config('status'))->label('Status'),
                SelectFilter::make('case_status')
                    ->options([
                        'Aborted' => 'Aborted',

                    ])
                    ->label('Case Status'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])

                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->columns(2)
                // SelectFilter::make('applyUniversity')->relationship('applyUniversity', 'name')->preload()->label('Apply University'),
            ])->filtersFormColumns(2)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('case_status')
                        ->icon(function (StudentCase $record) {
                            if ($record->visaDecision && ($record->visaDecision->status == 'Approved' || $record->visaDecision->status == 'Refused')) {
                                return ''; // Empty string to hide the icon for 'approved' or 'refused'
                            }

                            return 'heroicon-m-bell-alert'; // Icon class for other cases
                        })
                        ->label(function (StudentCase $record) {

                            if ($record->visaDecision && ($record->visaDecision->status == 'Approved' || $record->visaDecision->status == 'Refused')) {
                                return '';
                            }

                            return !$record['case_status'] ? 'Aborted' : 'Succeed';
                        })
                        ->hidden(function (StudentCase $record) {

                            if ($record->visaDecision && ($record->visaDecision->status == 'Approved' || $record->visaDecision->status == 'Refused')) {
                                return true;
                            }
                        })
                        ->action(function (StudentCase $record, array $data): void {
                            $currentUser = auth()->user();
                            $role = $currentUser->roles()->pluck('name')->first();
                            $branchName = $record->branch->name;
                            if (!$record['case_status']) {
                                if (!$record['case_status'] && !in_array($record->visaDecision->status, ['Approved', 'Refused'])) {
                                    $record['case_status'] = 'Aborted';
                                    $record->update();
                                    Notification::make()
                                        ->title('Case Aborted successfully')
                                        ->success()
                                        ->send();
                                }


                                /////super admin
                                $id = $record->id;


                                $superAdmins = User::whereHas('roles', function ($query) {
                                    $query->where('name', 'super admin');
                                })->get();
                                foreach ($superAdmins as $superAdmin) {
                                    Notification::make()
                                        ->icon('heroicon-o-document-text')
                                        ->iconColor('success')
                                        ->title("Student Case Aborted By $currentUser->name ($role)")
                                        ->body("Student Case aborted by $branchName")
                                        ->actions([
                                            Action::make('edit')
                                                ->button()
                                                ->url("/admin/student-cases/$id/edit"),
                                        ])
                                        ->sendToDatabase($superAdmin);
                                    event(new DatabaseNotificationsSent($superAdmin));
                                }
                                ///// branch manager
                                $recipient = User::find($record->created_by);
                                $users = DB::table('branch_user')
                                    ->where('branch_id', $recipient->branches[0]->id)
                                    ->get();
                                foreach ($users as $item) {
                                    $branch = $recipient->branches[0]->name;
                                    $user = User::whereHas('roles', function ($query) {
                                        $query->where('name', 'Branch Manager');
                                    })->find($item->user_id);
                                    $id = $record->id;
                                    if ($user) {
                                        Notification::make()
                                            ->icon('heroicon-o-document-text')
                                            ->iconColor('success')
                                            ->title("Student Case Aborted By $currentUser->name ($role)")
                                            ->body("Student Case aborted by $branchName")
                                            ->actions([
                                                Action::make('edit')
                                                    ->button()
                                                    ->url("/admin/student-cases/$id/edit"),
                                            ])
                                            ->sendToDatabase($user);
                                        event(new DatabaseNotificationsSent($user));
                                    }
                                }
                                ////conseller
                                $id = $record->id;
                                Notification::make()
                                    ->icon('heroicon-o-document-text')
                                    ->iconColor('success')
                                    ->title("Student Case Aborted By $currentUser->name ($role)")
                                    ->body("Student Case aborted by $branchName")
                                    ->actions([
                                        Action::make('edit')
                                            ->button()
                                            ->url("/admin/student-cases/$id/edit"),
                                    ])
                                    ->sendToDatabase($recipient);
                                event(new DatabaseNotificationsSent($recipient));
                            } else {
                                $record['case_status'] = '';
                                $record->update();
                                Notification::make()
                                    ->title('Case UnAborted successfully')
                                    ->success()
                                    ->send();
                            }
                        })
                        ->requiresConfirmation()


                ]),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                //     Tables\Actions\BulkActionGroup::make([
                //         Tables\Actions\DeleteBulkAction::make(),
                //     ]),
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
            'index' => ListStudentCase::route('/'),
            'create' => CreateStudentCase::route('/create'),
            'edit' => EditStudentCase::route('/{record}/edit'),
            'view' => ViewStudentCase::route('/{record}'),

        ];
    }
}
