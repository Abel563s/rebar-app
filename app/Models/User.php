<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
        'department_id',
        'employee_id',
        'date_of_joining',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }


    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager.
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isSiteEngineer(): bool
    {
        return $this->role === 'site_engineer';
    }

    public function isApprovalOfficer(): bool
    {
        return $this->role === 'approval_officer';
    }

    public function isCostControl(): bool
    {
        return $this->role === 'cost_control';
    }

    public function isQuantitySurveyor(): bool
    {
        return $this->role === 'quantity_surveyor';
    }

    public function isStoreKeeper(): bool
    {
        return $this->role === 'store_keeper';
    }

    public function isDepartmentAttendanceUser(): bool
    {
        return $this->role === 'department_attendance_user';
    }

    public function hasRebarAccess(): bool
    {
        return in_array($this->role, [
            'admin',
            'manager',
            'site_engineer',
            'approval_officer',
            'cost_control',
            'quantity_surveyor',
            'store_keeper',
        ]);
    }

}
