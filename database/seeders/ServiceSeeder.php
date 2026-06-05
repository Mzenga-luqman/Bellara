<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ServiceCategory::query()->pluck('id', 'name');

        $services = [
            [
                'category' => 'Nail Care',
                'name' => 'Signature Manicure',
                'description' => 'Luxury manicure with nail shaping, cuticle care, hydration ritual, and premium polish finish.',
                'price' => 45.00,
                'duration' => 60,
                'benefits' => ['Neat nail shape', 'Soft nourished hands', 'Long-lasting finish'],
                'features' => ['Cuticle treatment', 'Warm towel ritual', 'Premium polish'],
            ],
            [
                'category' => 'Nail Care',
                'name' => 'Classic Pedicure',
                'description' => 'Refreshing pedicure including soak, exfoliation, callus care, massage, and elegant polish.',
                'price' => 55.00,
                'duration' => 75,
                'benefits' => ['Smoother feet', 'Improved comfort', 'Polished finish'],
                'features' => ['Foot soak', 'Callus softening', 'Relaxing foot massage'],
            ],
            [
                'category' => 'Nail Care',
                'name' => 'Gel Manicure',
                'description' => 'Chip-resistant gel manicure with high-shine premium color and precise cuticle detailing.',
                'price' => 60.00,
                'duration' => 70,
                'benefits' => ['Long wear', 'Mirror shine', 'Strengthened nails'],
                'features' => ['UV set gel', 'Detailed shaping', 'Cuticle care'],
            ],
            [
                'category' => 'Massage & Relaxation',
                'name' => 'Swedish Massage',
                'description' => 'Gentle full-body massage designed to release stress, improve circulation, and promote deep calm.',
                'price' => 95.00,
                'duration' => 60,
                'benefits' => ['Stress relief', 'Better circulation', 'Whole-body relaxation'],
                'features' => ['Custom pressure', 'Aromatherapy option', 'Warm linens'],
            ],
            [
                'category' => 'Massage & Relaxation',
                'name' => 'Deep Tissue Massage',
                'description' => 'Targeted deep-pressure massage for chronic tension, muscle knots, and postural tightness.',
                'price' => 120.00,
                'duration' => 75,
                'benefits' => ['Muscle recovery', 'Reduced stiffness', 'Pain relief support'],
                'features' => ['Focused trigger points', 'Therapist consultation', 'Aftercare guidance'],
            ],
            [
                'category' => 'Massage & Relaxation',
                'name' => 'Hot Stone Massage',
                'description' => 'Heated stone therapy paired with massage strokes to melt deep tension and soothe the nervous system.',
                'price' => 135.00,
                'duration' => 90,
                'benefits' => ['Deep relaxation', 'Reduced muscle tension', 'Improved sleep quality'],
                'features' => ['Basalt stones', 'Aromatic oils', 'Slow restorative rhythm'],
            ],
            [
                'category' => 'Facial Care',
                'name' => 'Hydrating Facial',
                'description' => 'Moisture-replenishing facial treatment for dry or dehydrated skin using barrier-supportive products.',
                'price' => 85.00,
                'duration' => 60,
                'benefits' => ['Soft plump skin', 'Healthy glow', 'Improved moisture balance'],
                'features' => ['Deep cleanse', 'Hydration mask', 'Serum infusion'],
            ],
            [
                'category' => 'Facial Care',
                'name' => 'Brightening Facial',
                'description' => 'Radiance-focused facial to improve uneven tone and restore luminous complexion.',
                'price' => 95.00,
                'duration' => 70,
                'benefits' => ['Even tone support', 'Brighter complexion', 'Smoother texture'],
                'features' => ['Enzyme exfoliation', 'Vitamin-rich mask', 'Glow finish'],
            ],
            [
                'category' => 'Facial Care',
                'name' => 'Anti-Aging Facial',
                'description' => 'Advanced facial targeting fine lines with lifting massage and collagen-supportive formulas.',
                'price' => 130.00,
                'duration' => 90,
                'benefits' => ['Firming effect', 'Softened lines', 'Refreshed appearance'],
                'features' => ['Firming massage', 'Peptide treatment', 'Neck and decollete care'],
            ],
            [
                'category' => 'Hair Removal',
                'name' => 'Bikini Wax',
                'description' => 'Professional bikini wax service focused on comfort, precision, and hygiene.',
                'price' => 45.00,
                'duration' => 30,
                'benefits' => ['Smooth skin', 'Longer-lasting results', 'Clean finish'],
                'features' => ['Sensitive skin wax', 'Pre and post care', 'Expert technique'],
            ],
            [
                'category' => 'Hair Removal',
                'name' => 'Full Leg Wax',
                'description' => 'Complete leg waxing for silky-smooth results with minimal irritation.',
                'price' => 70.00,
                'duration' => 45,
                'benefits' => ['Smooth finish', 'Slower regrowth', 'Even hair removal'],
                'features' => ['Premium wax', 'Calming gel', 'Detailed cleanup'],
            ],
            [
                'category' => 'Hair Removal',
                'name' => 'Underarm Wax',
                'description' => 'Quick and effective underarm waxing treatment for a clean, polished look.',
                'price' => 30.00,
                'duration' => 20,
                'benefits' => ['Neat underarms', 'Reduced stubble', 'Soft skin feel'],
                'features' => ['Fast treatment', 'Low-residue wax', 'Post-wax soothing'],
            ],
            [
                'category' => 'Body Treatment',
                'name' => 'Detox Body Scrub',
                'description' => 'Exfoliating body polish that removes dull skin and leaves the body smooth and radiant.',
                'price' => 90.00,
                'duration' => 60,
                'benefits' => ['Smoother texture', 'Renewed glow', 'Improved product absorption'],
                'features' => ['Mineral scrub', 'Hydrating finish', 'Aromatic steam towels'],
            ],
            [
                'category' => 'Body Treatment',
                'name' => 'Body Sculpting Session',
                'description' => 'Contour-focused body treatment to support toned appearance and skin tightening goals.',
                'price' => 160.00,
                'duration' => 75,
                'benefits' => ['Refined contours', 'Skin toning support', 'Confidence boost'],
                'features' => ['Targeted zones', 'Firming cream', 'Progress tracking advice'],
            ],
            [
                'category' => 'Body Treatment',
                'name' => 'Mineral Mud Wrap',
                'description' => 'Warm mineral-rich wrap therapy that nourishes skin and promotes full-body relaxation.',
                'price' => 140.00,
                'duration' => 90,
                'benefits' => ['Soft nourished skin', 'Detox support', 'Relaxation'],
                'features' => ['Mineral infusion', 'Warm cocoon', 'Hydration application'],
            ],
            [
                'category' => 'Wellness',
                'name' => 'Infrared Sauna Session',
                'description' => 'Private infrared sauna session to promote detoxification, circulation, and deep calm.',
                'price' => 50.00,
                'duration' => 40,
                'benefits' => ['Sweat detox support', 'Improved circulation', 'Mental reset'],
                'features' => ['Private cabin', 'Hydration guidance', 'Towel service'],
            ],
            [
                'category' => 'Wellness',
                'name' => 'Steam Sauna Session',
                'description' => 'Traditional steam sauna ritual to open pores, ease breathing, and relax the body.',
                'price' => 45.00,
                'duration' => 35,
                'benefits' => ['Pore cleansing', 'Relaxed muscles', 'Respiratory comfort'],
                'features' => ['Aromatic steam', 'Temperature control', 'Cool-down protocol'],
            ],
            [
                'category' => 'Wellness',
                'name' => 'Recovery Wellness Package',
                'description' => 'Combined sauna and massage recovery package for complete rejuvenation.',
                'price' => 180.00,
                'duration' => 120,
                'benefits' => ['Deep recovery', 'Stress reset', 'Enhanced wellbeing'],
                'features' => ['Sauna + massage', 'Tailored pacing', 'Refreshments included'],
            ],
        ];

        foreach ($services as $service) {
            $categoryId = $categories[$service['category']] ?? null;

            if (! $categoryId) {
                continue;
            }

            Service::query()->updateOrCreate(
                ['name' => $service['name']],
                [
                    'category_id' => $categoryId,
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'duration' => $service['duration'],
                    'benefits' => $service['benefits'],
                    'features' => $service['features'],
                    'is_active' => true,
                ]
            );
        }
    }
}
