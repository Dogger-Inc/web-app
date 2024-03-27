<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'http_code',
        'message',
        'stacktrace',
        'type',
        'status',
        'env',
        'triggered_at'
    ];

    // One to Many
    public function project():  \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Many to Many
    public function users():  \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'issue_user');
    }

    // Polymorphic
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->MorphMany(Comment::class, 'commentable');
    }
}
