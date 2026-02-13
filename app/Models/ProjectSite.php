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
        'notes'
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
        });
    }

    public function requirements()
    {
        return $this->hasMany(RebarRequirement::class, 'site_id');
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
