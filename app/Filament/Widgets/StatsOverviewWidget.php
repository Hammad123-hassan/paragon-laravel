<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\StudentCase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = auth()->user();

        // Create a base query without any conditions
        $query = StudentCase::query();

        if ($user->roles[0]->id == 3) {
            $query->where('created_by', $user->id);
        } elseif ($user->roles[0]->id == 2) {
            $branchesId = $user->branches->pluck('id')->toArray();
            $query->whereIn('branch_id', $branchesId);
        }

        // Clone the base query for different counts
        $totalLeadQuery = clone $query;
        $leadQuery = clone $query;
        $matureLeadQuery = clone $query;

        $totalLead = $totalLeadQuery->count();
        $lead = $leadQuery->where('status', 'NEW')->count();
        $matureLead = $matureLeadQuery->whereNotIn('status', ['NEW'])->count();

        return [
            Stat::make('Total Case', $totalLead)
                ->icon('heroicon-o-folder-plus')
                // ->description('32k increase')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                // ->chart([7, 2, 10, 3, 15, 4, 1])
                ->color('success'),
            Stat::make('Case', $lead)
                // ->description('3% decrease')
                ->icon('heroicon-o-folder-plus'),
            // ->descriptionIcon('heroicon-m-arrow-trending-down')
            // ->chart([17, 16, 14, 15, 14, 13, 12])
            // ->color('danger'),
            Stat::make('Mature Case', $matureLead)
                ->icon('heroicon-o-folder-plus')
                // ->description('7% increase')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                // ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),
        ];
    }
}
