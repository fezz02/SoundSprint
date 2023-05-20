<?php
namespace App\Enums;

enum Status: int {
    case QUEUE = 0;
    case STARTING = 1;
    case PLAYING = 2;
    case FINISHED = 3;
    case ERROR = 4;
    case CANCELLED = 5;
    case TIMEOUT = 6;
}