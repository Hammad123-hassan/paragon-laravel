<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\StudentCase;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class BranchChart extends ApexChartWidget
{

    use HasWidgetShield;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'branchChart';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Branch';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    public function getBranches()
    {
        $branchs = Branch::with('lead')
            ->where('active', 1)
            ->get();
        $leadName = [];
        foreach ($branchs as $branch) {
            $leadName[] = $branch->name;
            $totalLead[] = StudentCase::where('branch_id', $branch->id)->count();
            $matureLead[] = StudentCase::where('branch_id', $branch->id)->whereNot('status', 'NEW')->count();
        }

        return [
            'LeadName' => $leadName,
            'totalLead' => $totalLead,
            'matureLead' => $matureLead,
        ];
    }
    protected function getOptions(): array
    {
        $GetData = $this->getBranches();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
            ],
            'plotOptions' => [
                'bar' => ['horizontal' => true]
            ],
            'dataLabels' => [
                'enabled' => false,
            ],

            'series' => [
                [
                    'name' => 'Total Case',
                    'data' => $GetData['totalLead'],
                    // 'type' => 'column',
                ],
                [
                    'name' => 'Mature Case',
                    'data' => $GetData['matureLead'],
                    // 'type' => 'line',
                ],
            ],
            'stroke' => [
                'width' => [0, 4],
            ],
            'xaxis' => [
                'categories' => $GetData['LeadName'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
