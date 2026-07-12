<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduledJob extends Model
{
    use HasFactory;

    protected $table = 'scheduled_jobs';

    protected $fillable = [
        'name',
        'description',
        'command',
        'expression',
        'is_active',
        'last_run_at',
        'last_run_status',
        'runs_count',
        'fails_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(JobLog::class, 'scheduled_job_id');
    }

    public function getLastRunTimeAttribute()
    {
        return $this->last_run_at ? $this->last_run_at->diffForHumans() : 'Never';
    }

    public function getSuccessRateAttribute()
    {
        if ($this->runs_count === 0) {
            return 0;
        }
        return round((($this->runs_count - $this->fails_count) / $this->runs_count) * 100, 2);
    }
}
