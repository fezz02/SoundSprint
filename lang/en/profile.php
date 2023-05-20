<?php


return [
    'info' => [
        'title' => 'Profile Information',
        'description' => 'Update your profile information.',
        'form' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Type your name.',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Type your email.',
            ],
            'save' => 'Save'
        ]
    ],
    'pwd' => [
        'title' => 'Password',
        'description' => 'Ensure your account is using a long, random password to stay secure.',
        'form' => [
            'current' => [
                'label' => 'Current Password',
                'placeholder' => 'Type your current password.',
            ],
            'new' => [
                'label' => 'New Password',
                'placeholder' => 'Type your new password.',
            ],
            'confirm' => [
                'label' => 'Confirm Password',
                'placeholder' => 'Confirm your new password.',
            ],
            'save' => 'Save'
        ]
    ]
];