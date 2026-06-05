<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'Amina M.', 'role_title' => 'Nail Technician', 'category' => 'Nail Care'],
            ['name' => 'Lilian K.', 'role_title' => 'Massage Therapist', 'category' => 'Massage & Relaxation'],
            ['name' => 'Grace N.', 'role_title' => 'Facial Specialist', 'category' => 'Facial Care'],
            ['name' => 'Mercy T.', 'role_title' => 'Waxing Specialist', 'category' => 'Hair Removal'],
            ['name' => 'Diana R.', 'role_title' => 'Body Therapist', 'category' => 'Body Treatment'],
            ['name' => 'Ruth P.', 'role_title' => 'Wellness Specialist', 'category' => 'Wellness'],
        ];

        foreach ($defaults as $index => $staff) {
            $category = ServiceCategory::query()->where('name', $staff['category'])->first();

            if (! $category) {
                continue;
            }

            Staff::query()->firstOrCreate(
                ['name' => $staff['name']],
                [
                    'email' => 'staff'.($index + 1).'@bellara.ngome.tech',
                    'phone' => null,
                    'role_title' => $staff['role_title'],
                    'service_category_id' => $category->id,
                    'is_active' => true,
                    'hired_at' => now()->toDateString(),
                ]
            );
        }
    }
}
