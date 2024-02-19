<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Branch;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Mail\NewUserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     // dd($data);
    //     return $data;
    // }

    protected function afterCreate(): void
    {
        $user = $this->record;
        $newPassword = Str::random(10); 
        $user->update([
            'password' => bcrypt($newPassword), 
        ]);
   
        $loginLink = url('/admin/login'); 
   
        Mail::to($user->email)->send(new NewUserNotification($user, $newPassword, $loginLink));
    }

    protected function handleRecordCreation(array $data): Model
    {

        $record =  static::getModel()::create($data);
        if (isset($data['region_id']) && count($data['region_id']) > 0) {

            $data['branches'] = Branch::whereIn('region_id', $data['region_id'])->pluck('id')->toArray();
        }


        if (isset($data['branches'])) {

            $record->branches()->sync($data['branches']);
        }
        return $record;
    }
}
