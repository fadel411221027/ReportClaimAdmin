<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'report_date',     'is_approved',
    'approved_at',
    'approved_by'];

    protected $casts = [
        'report_date' => 'date'
    ];

    public function tasks()
    {
        return $this->hasMany(ReportTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report_tasks()
{
    return $this->hasMany(ReportTask::class);
}

}
