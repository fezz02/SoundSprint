<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'url',
        'height',
        'width'
    ];
    
    protected $hidden = [
        'imageable_type',
        'imageable_id',
        'created_at',
        'updated_at',
    ];
    
    protected $guarded = [];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}

