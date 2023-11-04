<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dudi extends Model
{
    use HasFactory;

    protected $table = 'dudis';

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'dudi_id', 'id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'dudi_id', 'id');
    }
}
