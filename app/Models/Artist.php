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
    
    protected $hidden = [
        'artable_type',
        'artable_id',
        'created_at',
        'updated_at'
    ];
    
    protected $guarded = [];

    public function artable(): MorphTo
    {
        return $this->morphTo();
    }
}
