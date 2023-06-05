<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\Game;
use App\Enums\PrivacyType;
use App\Enums\StatusType;
use App\Traits\HasGameStatus;
use App\Traits\RespectsPrivacy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lobby extends Model
{
    use HasFactory;
    use RespectsPrivacy;
    use HasGameStatus;

    protected $fillable = [
        'code',
        'playlist_id',
        'playable_id',
        'playable_type',
        'current_players',
        'max_players',
        'status',
        'game',
        'privacy',
        'password',
        'next_round_at',
        'timeout_at',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'status' => StatusType::class,
        'game' => Game::class,
        'privacy' => PrivacyType::class,
        'timeout_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    protected $hidden = [
        'playlist_id',
        'playable_type',
        'playable_id',
        'password'
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function($lobby){
            $lobby->code = self::generateUniqueCode();
        });
    }
    
    public static function generateUniqueCode()
    {
        $generateCode = function(){
            return strtoupper(substr(md5(uniqid()), 0, 6));
        };

        $code = $generateCode();
        while(Lobby::where('code', $code)->exists()){
            $code = $generateCode();
        }
        return $code;
    }


    public function playable(): MorphTo
    {
        return $this->morphTo();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class);
    }

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function round(): HasOne
    {
        return $this->hasOne(Round::class)->ofMany('round_no', 'max');
    }

    public function isFull(): bool
    {
        return ($this->current_players >= $this->max_players);
    }

    public function isUserAllowed(User $user): bool
    {
        return ($this->isPublic() || $this->isUserInvited($user) || $this->containsFriends($user));
    }

    public function authorize(User $user, string $password): bool
    {
        $authorized = ($this->isPrivate() && $this->password === $password);

        $this->users()->attach($user);
        return $authorized;
    }
}
