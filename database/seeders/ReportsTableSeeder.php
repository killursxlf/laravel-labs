<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportsTableSeeder extends Seeder
{
    public function run(): void
    {
        Report::truncate();

        $reports = [
            ['period_start' => '2025-01-01', 'period_end' => '2025-01-31', 'payload' => 'Monthly performance report for January.', 'path' => '/reports/january.pdf'],
            ['period_start' => '2025-02-01', 'period_end' => '2025-02-28', 'payload' => 'Monthly performance report for February.', 'path' => '/reports/february.pdf'],
        ];

        foreach ($reports as $report) {
            Report::create($report);
        }
    }
}
