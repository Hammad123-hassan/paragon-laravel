<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\StudentCase;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LeadChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * 
     * @var string
     */
    protected static ?string $pollingInterval = null;
    protected static string $chartId = 'lead';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Case';

    /**
     * Chart options (series, labels, types, size, animations...)
     *
     * @return array
     */
    function getMonthNames()
    {
        return [
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '10', '11', '12',
        ];
    }
    public function getLead()
    {
        $user = auth()->user();

        $months = $this->getMonthNames();

        $query = StudentCase::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
            ->groupBy('month', 'status');

        if ($user->roles[0]->id == 3) {
            $query->where('created_by', $user->id);
        }

        if ($user->roles[0]->id == 2) {
            $branchesId = $user->branches->pluck('id')->toArray();
            $query->whereIn('branch_id', $branchesId);
        }

        $results = $query->get();

        // Initialize arrays for 'Lead' and 'Not Lead'
        $data = [
            'NEW' => array_fill(0, 12, 0),
            'Mature' => array_fill(0, 12, 0),
        ];

        // Fill the data arrays with counts
        foreach ($results as $result) {
            $monthIndex = $result->month - 1; // Adjust for 0-based indexing
            $status = $result->status;
            if ($status === 'NEW') {
                $data['NEW'][$monthIndex] += $result->count;
            } else {
                $data['Mature'][$monthIndex] += $result->count;
            }
        }

        return $data;
    }
    protected function getOptions(): array
    {
        $getData = $this->getLead();

        return [

            'chart' => [
                'type' => 'bar',
                'height' => 300,

            ],

            'plotOptions' => [
                'bar' => ['barWidth' => '100px']
            ],

            'series' => [
                [
                    'name' => 'CASE',
                    'data' => array_values($getData['NEW']),
                    'color' => '#9561e2',
                ],
                [
                    'name' => 'Mature',
                    'data' => array_values($getData['Mature']),
                    'color' => '#005974',
                ],
                // [
                //     'name' => 'Application Processing',
                //     'data' => array_values($getData['Application Processing'] ?? []),
                //     'color' => '#f6993f',
                // ],
                // [
                //     'name' => 'Applied',
                //     'data' => array_values($getData['Applied']),
                //     'color' => '#ffed4a',
                // ],
                // [
                //     'name' => 'Offer',
                //     'data' => array_values($getData['Offer']),
                //     'color' => '#38c172',
                // ],
                // [
                //     'name' => 'Unconditional Offer',
                //     'data' => array_values($getData['Unconditional Offer']),
                //     'color' => '#4dc0b5',
                // ],
                // [
                //     'name' => 'CAS',
                //     'data' => array_values($getData['CAS']),
                //     'color' => '#3490dc',
                // ],
                // [
                //     'name' => 'Fee Submission',
                //     'data' => array_values($getData['Fee Submission']),
                //     'color' => '#6574cd',
                // ],
                // [
                //     'name' => 'Visa',
                //     'data' => array_values($getData['Visa']),
                //     'color' => '#9561e2',
                // ],




            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#6366f1'],
        ];
    }
}