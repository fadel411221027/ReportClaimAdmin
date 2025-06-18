<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    protected $fillable = ['meeting_date'];
    protected $casts = ['meeting_date' => 'date'];

    public function topics(): HasMany
    {
        return $this->hasMany(MeetingTopic::class);
    }
}
