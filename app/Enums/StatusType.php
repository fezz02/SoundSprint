<?php
namespace App\Enums;

enum StatusType: string {
    case QUEUE = 'queue';
    case STARTING = 'starting';
    case PLAYING = 'playing';
    case FINISHED = 'finished';
    case ERROR = 'error';
    case CANCELLED = 'cancelled';
    case TIMEOUT = 'timeout';
}