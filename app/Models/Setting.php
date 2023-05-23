<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'default'
    ];
    
    protected $hidden = [];
    
    protected $guarded = [];
    
    // Definisci le relazioni qui
}