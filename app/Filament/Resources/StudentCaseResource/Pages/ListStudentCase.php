<?php

namespace App\Filament\Resources\StudentCaseResource\Pages;

use App\Filament\Resources\StudentCaseResource;
use App\Models\StudentCase;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStudentCase extends ListRecords
{
    protected static string $resource = StudentCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return StudentCaseResource::getWidgets();
    }
}
