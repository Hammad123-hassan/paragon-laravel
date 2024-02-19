<?php

namespace App\Observers;

use App\Models\StudentCase;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;

class StudentCaseObserver
{
    /**
     * Handle the StudentCase "created" event.
     */
    public function created(StudentCase $studentCase)
    {

        // if ($studentCase->branch_id) {
        //     $id = $studentCase->id;
        //     $currentUser = auth()->user();
        //     $role = $currentUser->roles()->pluck('name')->first();
        //     $branchName = $studentCase->branch->name;
        //     $superAdmins = User::whereHas('roles', function ($query) {
        //         $query->where('name', 'super admin');
        //     })->get();
        //     foreach ($superAdmins as $superAdmin) {
        //         Notification::make()
        //             ->icon('heroicon-o-document-text')
        //             ->iconColor('success')
        //             ->title("Student Case generated By $currentUser->name ($role)")
        //             ->body(" New student case has been registered by $branchName")
        //             ->actions([
        //                 Action::make('edit')
        //                     ->button()
        //                     ->url("/admin/student-cases/$id/edit"),
        //             ])
        //             ->sendToDatabase($superAdmin);
        //         event(new DatabaseNotificationsSent($superAdmin));
        //     }
        // }
    }
    /**
     * Handle the StudentCase "updated" event.
     */
    public function updated(StudentCase $studentCase): void
    {
        //
    }

    /**
     * Handle the StudentCase "deleted" event.
     */
    public function deleted(StudentCase $studentCase): void
    {
        //
    }

    /**
     * Handle the StudentCase "restored" event.
     */
    public function restored(StudentCase $studentCase): void
    {
        //
    }

    /**
     * Handle the StudentCase "force deleted" event.
     */
    public function forceDeleted(StudentCase $studentCase): void
    {
        //
    }
}