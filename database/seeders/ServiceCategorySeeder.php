<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Nail Care',
                'description' => 'Professional nail care services including manicure and pedicure',
                'icon' => '💅',
                'order' => 1,
            ],
            [
                'name' => 'Massage & Relaxation',
                'description' => 'Therapeutic massage treatments for complete relaxation',
                'icon' => '🧘‍♀️',
                'order' => 2,
            ],
            [
                'name' => 'Facial Care',
                'description' => 'Rejuvenating facial treatments and skincare services',
                'icon' => '✨',
                'order' => 3,
            ],
            [
                'name' => 'Hair Removal',
                'description' => 'Professional waxing and hair removal services',
                'icon' => '🪮',
                'order' => 4,
            ],
            [
                'name' => 'Body Treatment',
                'description' => 'Full body treatments including scrubs and sculpting',
                'icon' => '💆‍♀️',
                'order' => 5,
            ],
            [
                'name' => 'Wellness',
                'description' => 'Sauna and wellness services for ultimate relaxation',
                'icon' => '🛀',
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            ServiceCategory::firstOrCreate(
                ['name' => $category['name']],
                array_merge($category, ['slug' => $slug])
            );
        }
    }
}
