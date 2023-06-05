<?php

namespace App\Traits;

use App\Enums\PrivacyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait RespectsPrivacy {

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

    public function containsFriends(User $user){
        return false;
    }

    public function isUserInvited(User $user){
        return false;
    }

    public function isPrivate(){
        return ($this->privacy === PrivacyType::PRIVATE);
    }

    public function isPublic(){
        return ($this->privacy === PrivacyType::PUBLIC);
    }
}