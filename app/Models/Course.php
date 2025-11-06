<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'season_id',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

    public function getNameAttribute(): string
    {
        return "{$this->attributes['name']}";
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim(strtolower(ucfirst($value)));
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
