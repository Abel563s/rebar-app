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
}

