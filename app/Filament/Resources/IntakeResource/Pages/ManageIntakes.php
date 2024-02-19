<?php

namespace App\Filament\Resources\IntakeResource\Pages;

use App\Filament\Resources\IntakeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIntakes extends ManageRecords
{
    protected static string $resource = IntakeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth('md'),
        ];
    }
}
