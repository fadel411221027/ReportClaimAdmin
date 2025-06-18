<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTask extends Model
{

    use HasFactory;
    protected $fillable = [
        'daily_report_id',
        'task_category_id',
        'task_date',
        'batch_count',
        'claim_count',
        'start_time',
        'end_time',
        'sheet_count',
        'email',
        'form'
    ];

    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    public function daily_report()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function taskCategory()
    {
        return $this->belongsTo(TaskCategory::class);
    }
}
