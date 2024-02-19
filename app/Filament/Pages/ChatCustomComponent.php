<?php

namespace App\Filament\Pages;

use App\Events\MessageSentEvent;
use App\Models\Chat;
use App\Models\Lead;
use App\Models\Message;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;


class ChatCustomComponent extends Page
{
    use HasPageShield;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static string $view = 'filament.pages.chat-custom-component';

    protected ?string $heading = '';

    protected static ?string $navigationLabel = 'Student Chat';
}
