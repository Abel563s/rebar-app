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

            // Auto-calculate remaining length
            if (isset($model->original_length) && isset($model->cut_length)) {
                $model->remaining_length = $model->original_length - $model->cut_length;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(ProjectSite::class, 'site_id');
    }
}

