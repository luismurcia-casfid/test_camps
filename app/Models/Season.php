<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'seasons';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getNameAttribute(): string
    {
        return "{$this->attributes['name']}";
    }

}
