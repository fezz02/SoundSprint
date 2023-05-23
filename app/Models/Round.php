<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Round extends Model
{
    use HasFactory;

    protected $primaryKey = [
        'id',
        'lobby_id'
    ];

    protected $fillable = [
        'lobby_id',
        'track_id'
    ];

    protected $hidden = [];
    
    protected $guarded = [];

    public function lobby(): BelongsTo
    {
        return $this->belongsTo(Lobby::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class)->withDefault();
    }
}
