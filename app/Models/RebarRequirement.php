<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RebarRequirement extends Model
{
    /** @use HasFactory<\Database\Factories\RebarRequirementFactory> */
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tracking_id)) {
                $service = app(\App\Services\RebarService::class);
                $model->tracking_id = $service->generateRequirementId();
            }
            if ($model->required_length && $model->quantity && $model->bar_diameter) {
                $service = app(\App\Services\RebarService::class);
                $model->total_length = ($model->required_length * $model->quantity);
                $model->weight_kg = $service->calculateWeight($model->bar_diameter, $model->required_length, $model->quantity);
            }
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });

        static::updating(function ($model) {
            if ($model->required_length && $model->quantity && $model->bar_diameter) {
                $service = app(\App\Services\RebarService::class);
                $model->total_length = ($model->required_length * $model->quantity);
                $model->weight_kg = $service->calculateWeight($model->bar_diameter, $model->required_length, $model->quantity);
            }
        });

        static::created(function ($model) {
            if ($model->site_id) {
                app(\App\Services\RebarService::class)->recalculateSiteAmounts($model->site_id);
            }
        });

        static::updated(function ($model) {
            if ($model->site_id) {
                app(\App\Services\RebarService::class)->recalculateSiteAmounts($model->site_id);
            }
        });

        static::deleted(function ($model) {
            if ($model->site_id) {
                app(\App\Services\RebarService::class)->recalculateSiteAmounts($model->site_id);
            }
        });
    }

    public function cuttingLogs()
    {
        return $this->hasMany(RebarCuttingLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(ProjectSite::class, 'site_id');
    }
}

