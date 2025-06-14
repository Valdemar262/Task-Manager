<?php

namespace App\Models;

use App\Enums\TaskState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'state',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'state' => TaskState::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
