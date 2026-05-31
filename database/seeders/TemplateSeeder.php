<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove Layout 2 and Layout 3 from database as requested by the user
        \App\Models\Template::whereIn('slug', ['layout-2', 'layout-3'])->delete();

        \App\Models\Template::updateOrCreate(
            ['slug' => 'layout-1'],
            [
                'name' => 'Classic School Header (Layout 1)',
                'is_free' => true,
                'json_structure' => [
                    'layout' => 'left-2-right-1',
                    'slots' => [
                        'left' => ['logo'],
                        'center' => ['text'],
                        'right' => ['logo']
                    ],
                    'default_settings' => [
                        'headerLines' => [
                            'top' => ['bold' => false, 'italic' => false, 'fontSize' => 14, 'textTransform' => 'uppercase', 'color' => '#000000', 'text' => 'REPUBLIC OF THE PHILIPPINES'],
                            'middle' => ['bold' => true, 'italic' => false, 'fontSize' => 18, 'textTransform' => 'uppercase', 'color' => '#000000', 'text' => 'FIRST CLASSIC SCHOOL NAME'],
                            'bottom' => ['bold' => false, 'italic' => false, 'fontSize' => 14, 'textTransform' => 'uppercase', 'color' => '#000000', 'text' => 'MAIN CAMPUS']
                        ],
                        'fontFamily' => 'Inter',
                        'letterSpacing' => 1,
                        'divider' => ['enabled' => true, 'thickness' => 2, 'color' => '#000000', 'top' => 20, 'padding' => 4],
                        'margin' => 20,
                        'headerTop' => 0,
                        'lineHeight' => 1.2,
                        'logos' => ['left_0' => null, 'right_0' => null]
                    ]
                ]
            ]
        );

        \App\Models\Template::updateOrCreate(
            ['slug' => 'layout-4'],
            [
                'name' => 'Vertical & Horizontal Divider Header (Layout 2)',
                'is_free' => true,
                'json_structure' => [
                    'layout' => 'left-2-divider-right-1',
                    'vertical_dividers' => true,
                    'slots' => [
                        'left' => ['logo', 'logo'],
                        'center' => ['text'],
                        'right' => ['logo']
                    ],
                    'default_settings' => [
                        'headerLines' => [
                            'top' => ['bold' => false, 'italic' => false, 'fontSize' => 13, 'textTransform' => 'uppercase', 'color' => '#333333', 'text' => 'Edit text'],
                            'middle' => ['bold' => true, 'italic' => false, 'fontSize' => 24, 'textTransform' => 'uppercase', 'color' => '#111111', 'text' => 'Edit text'],
                            'bottom' => ['bold' => false, 'italic' => false, 'fontSize' => 13, 'textTransform' => 'uppercase', 'color' => '#333333', 'text' => 'Edit text']
                        ],
                        'fontFamily' => 'Inter',
                        'letterSpacing' => 1,
                        'divider' => ['enabled' => true, 'thickness' => 28, 'color' => '#4b5563', 'text' => 'Edit text', 'top' => 15, 'padding' => 4],
                        'margin' => 20,
                        'headerTop' => 0,
                        'lineHeight' => 1.2,
                        'logos' => ['left_0' => null, 'left_1' => null, 'right_0' => null]
                    ]
                ]
            ]
        );
    }
}
