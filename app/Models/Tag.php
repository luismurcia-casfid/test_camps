<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->is_active = true;
        });

        static::updating(function ($tag) {
            $tag->is_active = true;
        });
    }

    public function getNameAttribute(): string
    {
        return ucfirst($this->attributes['name']);
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim(strtolower(ucfirst($value)));
    }

    // Relaciones polimórficas
    public function news(): MorphToMany
    {
        return $this->morphedByMany(News::class, 'taggable');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }
}
