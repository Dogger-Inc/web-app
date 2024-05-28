<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'key'
    ];

    // One to Many
    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function issues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function performances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Performance::class);
    }

    // Many to Many
    public function users():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    // Scopes
    public function scopeRetrieveRelevantProjects($query, int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereHas('company.users', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereIn('role', ['admin', 'owner'])
                ->where('is_active', true);
        })->orWhereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
}
