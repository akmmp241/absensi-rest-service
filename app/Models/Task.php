<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'report_id',
        'confirmed_by',
        'confirmed_at',
        'title',
        'detail',
        'image',
        'status',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'confirmed_by', 'id');
    }
}
