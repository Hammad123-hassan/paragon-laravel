<?php

namespace App\Filament\Resources\StudentCaseResource\Pages;

use Filament\Notifications\Notification;
use App\Filament\Resources\StudentCaseResource;
use App\Models\LeadUniversity;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditStudentCase extends EditRecord
{
    protected static string $resource = StudentCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),

            // Actions\Action::make('chat')
            //     ->button()
            //     ->icon('heroicon-m-chat-bubble-bottom-center')
            //     ->label('Chat')
            //     ->url('/admin/chat-custom-component?')

        ];
    }
    // protected function getRedirectUrl(): string
    // {
    //     $record = $this->getRecord();
    //     if ($record) {
    //         return $this->getResource()::getUrl('edit', ['record' => $record]);
    //     }
    //     return $this->getResource()::getUrl('index');
    // }
    

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    // }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // dd($this->record->universities->where('uol', 1)->pluck('university_id')->first());
        $data['uol_option'] = $this->record->universities->where('uol', 1)->pluck('university_id')->first();
        $data['col_option'] = $this->record->universities->where('col', 1)->pluck('university_id');
        $data['app_option'] = $this->record->universities->where('applied_uni', 1)->pluck('university_id');
        return $data;
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        // $record->universities = $record->universities->whereNotNull('degree_id');

        // $record['universities'] = [];
        // $record['universities'] = collect($getUniqueUni)->whereNotNull('degree_id')->unique(function ($item) {

        //     return $item['degree_id'] . $item['country_id'] . $item['university_id'];
        // })->values()->all();

        // dd($data['uol_option']);
        // $uol = $record->universities->where('uol', 1)->toArray();
        // if (count($uol) > 1) {
        //     Notification::make()
        //         ->title('Attention')
        //         ->body('You can select only one Unconditional offer letter')
        //         ->danger()
        //         ->send();
        //     $this->halt();
        // }
        // dd($record->universities);
        // dd($data['app_option']);
        $getApp = collect($data['app_option']);
        if (count($getApp) > 0) {
            $record['status'] = "ADM APP";
        }
        $col_option = collect($data['col_option']);
        if (count($col_option) > 0) {
            $record['status'] = "COL";
        }
        $uol_option = collect($data['uol_option']);
        if (count($uol_option) > 0) {
            $record['status'] = "UOL";
        }
        // foreach ($record->universities as $item) {
        //     if ($item->applied_uni) {
        //         $record['status'] = "ADM APP";
        //     }
        //     if ($item->col) {
        //         $record['status'] = "COL";
        //     }
        //     if ($item->uol) {
        //         $record['status'] = "UOL";
        //     }
        // }
        if ($data['date_of_deposit'] && $data['maturity_date']) {
            $record['status'] = "BANK STATEMENT";
        }
        if ($record->interview->schedule_date && $record->interview->mock_interview_date && $record->interview->official_interview_date && $record->interview->result_date) {

            $record['status'] = "INTERVIEW";
        }
        if ($record->cas->cas_request && $record->cas->cas_receive) {
            $record['status'] = "CAS";
        }
        if ($record->visaApplpication->applied) {
            $record['status'] = "VISA APP";
        }
        if ($record->visaDecision->status) {
            $record['status'] = "VISA DECISION";
        }
        LeadUniversity::where('student_case_id', $record->id)->update([
            'uol' => 0
        ]);

        LeadUniversity::where('student_case_id', $record->id)->whereIn('university_id', $data['col_option'])->update([
            'col' => 1
        ]);
        LeadUniversity::where('student_case_id', $record->id)->whereNotIn('university_id', $data['col_option'])->update([
            'col' => 0
        ]);
        LeadUniversity::where('student_case_id', $record->id)->whereIn('university_id', $data['app_option'])->update([
            'applied_uni' => 1
        ]);
        LeadUniversity::where('student_case_id', $record->id)->whereNotIn('university_id', $data['app_option'])->update([
            'applied_uni' => 0
        ]);
        $leadUni  = LeadUniversity::where('student_case_id', $record->id)->where('university_id', $data['uol_option'])->first();
        if ($leadUni) {
            $leadUni['uol'] = 1;
            $leadUni->update();
        }
        
        $record->updated_by = auth()->user()->id;
        $record->update($data);

        if ($record->visaDecision->status) {

            // $newStatus = $record->visaDecision->status;
            // $studentName = $record->name; // Assuming a student relationship

            // $targetRoles = ['super admin', 'branch manager', 'Counsellor'];
            // $usersWithRoles = User::whereHas('roles', function ($query) use ($targetRoles) {
            //     $query->whereIn('name', $targetRoles);
            // })->get();
            // // Notify each user with the specified roles
            // foreach ($usersWithRoles as $user) {
            //     Notification::make()
            //         ->title("Visa Decision Updated - Student: $studentName")
            //         ->icon('heroicon-o-clipboard-document-check')
            //         ->iconColor('success')
            //         ->body("The visa decision for student $studentName is now $newStatus.")
            //         ->actions([
            //             Action::make('Edit')
            //                 ->button()
            //                 ->url("/admin/student-cases/{$record->visaDecision->id}"),
            //         ])
            //         ->sendToDatabase($user);
            //     event(new DatabaseNotificationsSent($user));
            // }
            /////super admin
            $currentUser = auth()->user();
            $role = $currentUser->roles()->pluck('name')->first();
            $id = $record->id;
            $branchName = $record->branch->name;
            $superAdmins = User::whereHas('roles', function ($query) {
                $query->where('name', 'super admin');
            })->get();
            $status = $record->visaDecision->status;
            foreach ($superAdmins as $superAdmin) {
                if ($status === 'Approved' || $status === 'Refused'){
                    Notification::make()
                    ->icon('heroicon-o-document-text')
                    ->iconColor('success')
                    ->title("Visa Decision")
                    ->body("The visa decision is now $status By $currentUser->name ($role)")
                    ->actions([
                        Action::make('edit')
                            ->button()
                            ->url("/admin/student-cases/$id/edit"),
                    ])
                    ->sendToDatabase($superAdmin);
                event(new DatabaseNotificationsSent($superAdmin));
                }
               
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
                        ->title("Visa Decision")
                        ->body("The visa decision is now $status By $currentUser->name ($role)")
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
                ->title("Visa Decision")
                ->body("The visa decision is now $status By $currentUser->name ($role)")
                ->actions([
                    Action::make('edit')
                        ->button()
                        ->url("/admin/student-cases/$id/edit"),
                ])
                ->sendToDatabase($recipient);
            event(new DatabaseNotificationsSent($recipient));
        }
        
        return $record;
    }
}