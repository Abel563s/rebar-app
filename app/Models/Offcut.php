<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offcut extends Model
{
    /** @use HasFactory<\Database\Factories\OffcutFactory> */
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->offcut_code)) {
                $service = app(\App\Services\RebarService::class);
                $model->offcut_code = $service->generateOffcutId();
            }
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function cuttingLogs()
    {
        return $this->hasMany(RebarCuttingLog::class, 'offcut_id');
    }

    public function site()
    {
        return $this->belongsTo(ProjectSite::class, 'site_id');
    }

    public function getWeightKgAttribute()
    {
        // Weight (kg) = (d^2 / 162) * length(m)
        return (($this->bar_diameter * $this->bar_diameter) / 162) * ($this->length * $this->quantity);
    }
}

