<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_album_id',
        'name',
        'href',
        'type',
        'released_at'
    ];
    
    protected $hidden = [];
    
    protected $guarded = [];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function artists(): MorphMany
    {
        return $this->morphMany(Artist::class, 'artable');
    }
}
