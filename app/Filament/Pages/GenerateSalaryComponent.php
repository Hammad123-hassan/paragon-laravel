<?php

namespace App\Filament\Pages;

use App\Events\MessageSentEvent;
use App\Models\Chat;
use App\Models\Lead;
use App\Models\Message;
use App\Models\VoucherDetail;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;



class GenerateSalaryComponent extends Page
{

    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 3;
    // protected static bool $shouldRegisterNavigation = false;
    // protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    // protected static ?string $navigationGroup = 'Account';
    // protected static ?int $navigationSort = 8;
    protected static string $view = 'filament.pages.generate-salary-component';
    protected ?string $heading = '';
    protected static ?string $navigationLabel = 'Generate Salary';
}
