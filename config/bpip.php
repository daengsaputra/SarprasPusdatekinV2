<?php

return [
    'units' => [
        'Sekretariat Utama',
        'Deputi Bidang Hubungan Antar Lembaga, Sosialisasi, Komunikasi, dan Jaringan',
        'Deputi Bidang Hukum, Advokasi, dan Pengawasan Regulasi',
        'Deputi Bidang Pengkajian dan Materi',
        'Deputi Bidang Pendidikan dan Pelatihan',
        'Deputi Bidang Pengendalian dan Evaluasi',
    ],

    // Upload settings for user photos
    'user_photo_max_kb' => env('USER_PHOTO_MAX_KB', 2048), // in KB
    'user_photo_mimes' => explode(',', env('USER_PHOTO_MIMES', 'jpg,jpeg,png,webp')),

    // Upload settings for asset photos
    'asset_photo_max_kb' => env('ASSET_PHOTO_MAX_KB', 4096), // in KB
    'asset_photo_mimes' => explode(',', env('ASSET_PHOTO_MIMES', 'jpg,jpeg,png,webp')),

    // Loan attachment settings (ND pengajuan, bukti pinjam/kembali)
    'loan_attachment_max_kb' => env('LOAN_ATTACHMENT_MAX_KB', 4096),
    'loan_attachment_mimes' => explode(',', env('LOAN_ATTACHMENT_MIMES', 'jpg,jpeg,png,webp')),

    // Upload settings for landing hero video
    'landing_video_max_kb' => env('LANDING_VIDEO_MAX_KB', 71680), // in KB (approx. 70 MB)
    'landing_video_mimes' => explode(',', env('LANDING_VIDEO_MIMES', 'mp4,webm,ogg')),

    // Landing page themes
    'landing_themes' => [
        'aurora' => [
            'label' => 'Aurora Blue',
            'tagline' => 'Nuansa malam biru elegan',
            'swatch' => ['#1d4ed8', '#38bdf8'],
            'surfaces' => [
                'surface1' => 'linear-gradient(160deg, #050b1d 0%, #0f1c3a 45%, #0b1124 100%)',
                'surface2' => 'rgba(12,19,33,0.92)',
                'surface3' => 'rgba(18, 35, 64, 0.65)',
                'accent' => '#38bdf8',
                'accentSoft' => '#dbeafe',
                'text_primary' => '#e2e8f0',
                'text_secondary' => 'rgba(226, 232, 240, 0.8)',
            ],
        ],
        'sunrise' => [
            'label' => 'Sunrise Glow',
            'tagline' => 'Gradien jingga hangat',
            'swatch' => ['#f97316', '#facc15'],
            'surfaces' => [
                'surface1' => 'linear-gradient(150deg, #fff7ed 0%, #ffe4d2 45%, #ffd6a5 100%)',
                'surface2' => 'rgba(255, 247, 236, 0.95)',
                'surface3' => 'rgba(255, 232, 210, 0.78)',
                'accent' => '#ea580c',
                'accentSoft' => '#fed7aa',
                'text_primary' => '#7c2d12',
                'text_secondary' => 'rgba(120, 53, 15, 0.7)',
            ],
        ],
        'forest' => [
            'label' => 'Forest Emerald',
            'tagline' => 'Hijau natural modern',
            'swatch' => ['#0f766e', '#22c55e'],
            'surfaces' => [
                'surface1' => 'linear-gradient(160deg, #022c22 0%, #064e3b 45%, #064e3b 100%)',
                'surface2' => 'rgba(5, 46, 36, 0.92)',
                'surface3' => 'rgba(16, 94, 70, 0.72)',
                'accent' => '#22c55e',
                'accentSoft' => '#bbf7d0',
                'text_primary' => '#ecfdf5',
                'text_secondary' => 'rgba(236, 253, 245, 0.75)',
            ],
        ],
    ],
];
