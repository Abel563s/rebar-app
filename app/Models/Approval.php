<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'site_id', 'target_site_id', 'offcut_id', 'requested_by', 'approver_id', 'status', 'note'
    ];

    public function site()
    {
        return $this->belongsTo(ProjectSite::class, 'site_id');
    }

    public function offcut()
    {
        return $this->belongsTo(Offcut::class, 'offcut_id');
    }

    public function targetSite()
    {
        return $this->belongsTo(ProjectSite::class, 'target_site_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
