<?php
namespace App\Enums;

enum PrivacyType: string {
    case PRIVATE = 'private';
    case PUBLIC = 'public';
    case FRIENDS_ONLY = 'friends_only';
    case INVITE_ONLY = 'invite_only';
}