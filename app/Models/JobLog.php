<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobLog extends Model
{
    use HasFactory;

    protected $table = 'job_logs';

    protected $fillable = [
        'scheduled_job_id',
        'status',
        'output',
        'error_message',
        'duration',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(ScheduledJob::class, 'scheduled_job_id');
    }

    public function getDurationInSecondsAttribute()
    {
        if ($this->duration) {
            return $this->duration;
        }
        
        if ($this->started_at && $this->finished_at) {
            return $this->finished_at->diffInSeconds($this->started_at);
        }
        
        return 0;
    }
}
