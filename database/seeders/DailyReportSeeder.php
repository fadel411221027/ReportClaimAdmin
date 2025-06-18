<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyReport;
use App\Models\User;
use App\Models\TaskCategory;
use Carbon\Carbon;

class DailyReportSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $categories = TaskCategory::all();

        foreach ($users as $user) {
            // Create reports for last 30 days
            for ($i = 0; $i < 20; $i++) {
                $report = DailyReport::create([
                    'user_id' => $user->id,
                    'report_date' => Carbon::now()->subDays($i),
                    'is_approved' => 1,
                    'approved_at' => rand(0, 1) ? Carbon::now()->subDays(rand(0, 30)) : null,
                    'approved_by' => rand(0, 1) ? User::role('Leader')->get()->random()->id : null,                ]);

                // Create 2-4 tasks per report
                for ($j = 0; $j < rand(2, 4); $j++) {
                    $category = $categories->random();
                    $taskData = [
                        'task_category_id' => $category->id,
                        'task_date' => $category->has_dor_date ? Carbon::now()->subDays($i) : null,
                        'batch_count' => $category->has_batch ? rand(1, 100) : null,
                        'claim_count' => $category->has_claim ? rand(1, 50) : null,
                        'start_time' => $category->has_time_range ? '08:00' : null,
                        'end_time' => $category->has_time_range ? '17:00' : null,
                        'sheet_count' => $category->has_sheets ? rand(1, 200) : null,
                        'email' => $category->has_email ? rand(1, 20) : null,
                        'form' => $category->has_form ? rand(1, 15) : null,
                    ];

                    $report->tasks()->create($taskData);
                }
            }
        }
    }
}
