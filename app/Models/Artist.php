<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'artable_id',
        'artable_type',
        'spotify_artist_id',
        'name',
        'href',
        'spotify_href'
    ];
    
    protected $hidden = [];
    
    protected $guarded = [];

    public function artable(): MorphTo
    {
        return $this->morphTo();
    }
}
