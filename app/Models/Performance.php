<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'duration',
        'comment',
        'env',
    ];

    // Polymorphic
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->MorphMany(Comment::class, 'commentable');
    }
}
