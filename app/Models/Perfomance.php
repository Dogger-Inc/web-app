<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfomance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'duration',
        'comment'
    ];

    // One to Many
    public function project():  \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Polymorphic
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->MorphMany(Comment::class, 'commentable');
    }
}
