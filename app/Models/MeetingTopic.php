<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingTopic extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'is_continued',
        'continued_from_id',
        'user_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(MeetingFile::class);
    }

    public function continuedFrom(): BelongsTo
    {
        return $this->belongsTo(MeetingTopic::class, 'continued_from_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
