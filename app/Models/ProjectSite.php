<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSite extends Model
{
    protected $fillable = [
        'site_code',
        'project_name',
        'site_name',
        'location',
        'sector',
        'status',
        'steel_grade',
        'manager_id',
        'notes',
        'amount_needed_08',
        'amount_needed_10',
        'amount_needed_12',
        'amount_needed_14',
        'amount_needed_16',
        'amount_needed_20',
        'amount_needed_24',
        'amount_needed_32',
        'price_08',
        'price_10',
        'price_12',
        'price_14',
        'price_16',
        'price_20',
        'price_24',
        'price_32',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->site_code) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) str_replace('PS-', '', $latest->site_code)) + 1 : 1;
                $model->site_code = 'PS-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function requirements()
    {
        return $this->hasMany(RebarRequirement::class, 'site_id');
    }

    public function manager()
    {
        return $this->belongsTo(\App\Models\User::class, 'manager_id');
    }

    public function offcuts()
    {
        return $this->hasMany(Offcut::class, 'site_id');
    }

    public function cuttingLogs()
    {
        return $this->hasMany(RebarCuttingLog::class, 'site_id');
    }
}
