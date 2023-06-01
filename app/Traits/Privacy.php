<?php

namespace App\Traits;

use App\Enums\PrivacyType;
use Illuminate\Database\Eloquent\Builder;

trait Privacy {

    public function scopePrivate(Builder $query)
    {
        return $query->where('privacy', PrivacyType::PRIVATE);
    }

    public function scopePublic(Builder $query)
    {
        return $query->where('privacy', PrivacyType::PUBLIC);
    }

    public function scopeFriendsOnly(Builder $query)
    {
        return $query->where('privacy', PrivacyType::FRIENDS_ONLY);
    }

    public function scopeInviteOnly(Builder $query)
    {
        return $query->where('privacy', PrivacyType::INVITE_ONLY);
    }
}