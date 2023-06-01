<?php
namespace App\Enums;

enum StatusType: int {
    case QUEUE = 0;
    case STARTING = 1;
    case PLAYING = 2;
    case FINISHED = 3;
    case ERROR = 4;
    case CANCELLED = 5;
    case TIMEOUT = 6;

    public static function getStringFromValue(int $value): string
    {
        return match ($value) {
            self::QUEUE => 'Queue',
            self::STARTING => 'Starting',
            self::PLAYING => 'Playing',
            self::FINISHED => 'Finished',
            self::ERROR => 'Error',
            self::CANCELLED => 'Cancelled',
            self::TIMEOUT => 'Timeout',
            default => '',
        };
    }
}