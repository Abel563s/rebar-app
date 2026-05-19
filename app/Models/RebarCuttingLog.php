<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RebarCuttingLog extends Model
{
    /** @use HasFactory<\Database\Factories\RebarCuttingLogFactory> */
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }

            // Auto-calculate remaining length and weight
            if (isset($model->original_length) && isset($model->cut_length)) {
                $model->remaining_length = $model->original_length - $model->cut_length;
                
                $service = app(\App\Services\RebarService::class);
                $model->weight_kg = $service->calculateWeight($model->bar_diameter, $model->cut_length, $model->quantity_cut ?? 1);
            }
        });

        static::updating(function ($model) {
            if (isset($model->original_length) && isset($model->cut_length)) {
                $model->remaining_length = $model->original_length - $model->cut_length;
                
                $service = app(\App\Services\RebarService::class);
                $model->weight_kg = $service->calculateWeight($model->bar_diameter, $model->cut_length, $model->quantity_cut ?? 1);
            }
        });
    }

    public function requirement()
    {
        return $this->belongsTo(RebarRequirement::class, 'rebar_requirement_id');
    }

    public function offcut()
    {
        return $this->belongsTo(Offcut::class);
    }

    public function reusedOffcut()
    {
        return $this->belongsTo(Offcut::class, 'reused_offcut_id');
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

