<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'project_id',
        'env',
    ];

    // One to Many
    public function project():  \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function performances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Performance::class, 'group_id', 'id')->orderBy('created_at', 'asc');
    }

    // Polymorphic
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->MorphMany(Comment::class, 'commentable');
    }

     // Many to Many
     public function users():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
     {
         return $this->belongsToMany(User::class, 'performance_groups_user');
     }
}
