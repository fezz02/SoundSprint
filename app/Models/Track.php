<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'href',
        'duration_ms',
        'popularity',
        'preview_url',
        'explicit'
    ];
    
    protected $hidden = [];
    
    protected $guarded = [];
    
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function artists(): MorphMany
    {
        return $this->morphMany(Artist::class, 'artable');
    }
}
