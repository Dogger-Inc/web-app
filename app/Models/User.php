<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'fullname'
    ];

    public function getRoleInCompany(int $companyId): ?string
    {
        $company = $this->companies()->where('company_id', $companyId)->first();

        if (!$company) {
            return null;
        }

        return $company->pivot->role;
    }

    public function checkCompanyAccess(int $companyId): void
    {
        $this->companies()->where('company_id', $companyId)->exists() || abort(403);
    }


    // One to Many
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Many to Many
    public function companies():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user')
            ->withPivot('role', 'is_active')->withTimestamps();
    }

    public function projects():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    public function assignedIssues():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'issue_user');
    }

    // Attributes
    public function getFullNameAttribute(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    // }
}
