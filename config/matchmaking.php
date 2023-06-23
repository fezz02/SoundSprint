<?php
use App\Enums\StatusType;
use App\Enums\PrivacyType;

return [
    'game' => [
        'connection' => [
            'join' => [
                'status' => [
                    StatusType::QUEUE,
                    StatusType::STARTING
                ],
                'privacy' => [
                    PrivacyType::PUBLIC,
                    PrivacyType::FRIENDS_ONLY,
                    PrivacyType::INVITE_ONLY
                ]
            ],
            'rejoin' => [
                'status' => [
                    StatusType::QUEUE,
                    StatusType::STARTING,
                    StatusType::PLAYING
                ],
                'privacy' => [
                    PrivacyType::PRIVATE,
                    PrivacyType::PUBLIC,
                    PrivacyType::FRIENDS_ONLY,
                    PrivacyType::INVITE_ONLY
                ]
            ]
        ]
    ]
];