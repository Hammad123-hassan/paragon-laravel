<?php

namespace App\Filament\Resources\StudentCaseResource\Pages;

use App\Filament\Resources\StudentCaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentCase extends ViewRecord
{
    protected static string $resource = StudentCaseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // dd($this->record->universities->where('uol', 1)->pluck('university_id')->first());
        $data['uol_option'] = $this->record->universities->where('uol', 1)->pluck('university_id')->first();
        $data['col_option'] = $this->record->universities->where('col', 1)->pluck('university_id');
        $data['app_option'] = $this->record->universities->where('applied_uni', 1)->pluck('university_id');
        return $data;
    }
}
