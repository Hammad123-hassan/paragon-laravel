<?php

namespace App\Filament\Resources\UserResource\Pages;

use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use App\Models\Branch;

use App\Models\User;
use App\Models\UserBranch;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::find($data['id']);

        $data['roles'] = $user->roles[0]->id;
        $data['branches'] = $user->branches[0]->id;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {




        if (isset($data['branches'])) {

            $record->branches()->sync($data['branches']);
        }
        $record->update($data);
        return $record;
    }
}
