<?php

namespace App\Filament\Pages;

use App\Events\MessageSentEvent;
use App\Models\Chat;
use App\Models\Lead;
use App\Models\Message;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;


class CheckbookComponent extends Page
{
    use HasPageShield;
    // protected static bool $shouldRegisterNavigation = false;
    // protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Account';
    protected static ?int $navigationSort = 9;

    protected static string $view = 'filament.pages.checkbook-component';

    protected ?string $heading = '';

    protected static ?string $navigationLabel = 'Chequebook';
}
