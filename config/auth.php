<?php

    return [
        'defaults' => [
            'guard' => 'web',
            'passwords' => 'users',
        ],
    
        'guards' => [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
            ],

            'pelanggan' => [
                'driver' => 'session',
                'provider' => 'pelanggans',
            ],
        ],

        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => App\Models\User::class,
            ],
            
            'pelanggans' => [
                'driver' => 'eloquent',
                'model' => App\Models\Pelanggan::class,
            ],
        ],
    
        'passwords' => [
            'users' => [
                'provider' => 'users',
                'table' => 'password_reset_tokens',
                'expire' => 60,
                'throttle' => 60,
            ],
            
            'pelanggans' => [ // Tambahkan konfigurasi reset password untuk pelanggan
                'provider' => 'pelanggans',
                'table' => 'password_reset_tokens_pelanggan', // Buat tabel terpisah jika perlu
                'expire' => 60,
                'throttle' => 60,
            ],
        ],
    
        'password_timeout' => 10800,
    ];