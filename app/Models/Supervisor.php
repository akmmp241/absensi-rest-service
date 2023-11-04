<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'supervisors';

    protected $fillable = [
        'user_id',
        'name',
        'nip'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'supervisor_id', 'id');
    }

    public function taskConfirmed(): HasMany
    {
        return $this->hasMany(Task::class, 'confirmed_by', 'id');
    }
}
