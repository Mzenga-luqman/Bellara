<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ServiceImageSeeder extends Seeder
{
    /**
     * Verified Unsplash photo IDs (HTTP 200 confirmed) per service.
     * Optional 'crop' param differentiates images that share the same base photo ID.
     *
     * @var array<string, array{id: string, crop?: string}>
     */
    private array $serviceImages = [
        'Signature Manicure' => ['id' => '1604654894610-df63bc536371'],
        'Classic Pedicure' => ['id' => '1519823551278-64ac92734fb1'],
        'Gel Manicure' => ['id' => '1604654894610-df63bc536371', 'crop' => 'entropy'],
        'Swedish Massage' => ['id' => '1544161515-4ab6ce6db874'],
        'Deep Tissue Massage' => ['id' => '1602452920335-6a132309c7c8'],
        'Hot Stone Massage' => ['id' => '1515377905703-c4788e51af15'],
        'Hydrating Facial' => ['id' => '1570172619644-dfd03ed5d881'],
        'Brightening Facial' => ['id' => '1616394584738-fc6e612e71b9'],
        'Anti-Aging Facial' => ['id' => '1512290923902-8a9f81dc236c'],
        'Bikini Wax' => ['id' => '1580407196238-dac33f57c410'],
        'Full Leg Wax' => ['id' => '1571019613454-1cb2f99b2d8b'],
        'Underarm Wax' => ['id' => '1589301760014-d929f3979dbc'],
        'Detox Body Scrub' => ['id' => '1540555700478-4be289fbecef'],
        'Body Sculpting Session' => ['id' => '1506629082955-511b1aa562c8'],
        'Mineral Mud Wrap' => ['id' => '1516975080664-ed2fc6a32937'],
        'Infrared Sauna Session' => ['id' => '1560180474-e8563fd75bab'],
        'Steam Sauna Session' => ['id' => '1576426863848-c21f53c60b19'],
        'Recovery Wellness Package' => ['id' => '1544161515-4ab6ce6db874', 'crop' => 'entropy'],
    ];

    public function run(): void
    {
        $destDir = public_path('images/services');

        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $placeholderMd5 = '2be570b7d4e02679bdae75e31c616e2f';

        foreach ($this->serviceImages as $serviceName => $config) {
            $service = Service::query()->where('name', $serviceName)->first();

            if (! $service) {
                $this->command?->warn("  ⚠  Not found in DB: {$serviceName}");

                continue;
            }

            $slug = Str::slug($serviceName);
            $filePath = "{$destDir}/{$slug}.jpg";
            $webPath = "/images/services/{$slug}.jpg";

            $fileExists = file_exists($filePath);
            $isPlaceholder = $fileExists && md5_file($filePath) === $placeholderMd5;
            $isTooSmall = $fileExists && filesize($filePath) < 50_000;

            if ($fileExists && ! $isPlaceholder && ! $isTooSmall) {
                $this->command?->line("  ✓ already real: {$slug}.jpg — updating DB path");
                $service->update(['image' => $webPath]);

                continue;
            }

            $this->command?->line("  ↓ Downloading: {$serviceName} …");

            $cropParam = isset($config['crop']) ? '&crop='.$config['crop'] : '';
            $url = "https://images.unsplash.com/photo-{$config['id']}?w=1200&h=900&fit=crop{$cropParam}&q=80";

            try {
                $response = Http::timeout(45)
                    ->withOptions(['allow_redirects' => true])
                    ->withHeaders([
                        'Accept' => 'image/jpeg,image/*',
                        'User-Agent' => 'Mozilla/5.0 BellaraSeeder/1.0',
                    ])
                    ->get($url);

                $body = $response->body();

                if (! $response->successful()) {
                    $this->command?->error("  ✗ HTTP {$response->status()} for: {$serviceName}");

                    continue;
                }

                if (strlen($body) < 20_000) {
                    $this->command?->error("  ✗ Response too small (likely not an image) for: {$serviceName}");

                    continue;
                }

                file_put_contents($filePath, $body);
                $service->update(['image' => $webPath]);

                $kb = round(strlen($body) / 1024);
                $this->command?->line("  ✓ Saved {$kb}KB → {$slug}.jpg");

            } catch (\Exception $e) {
                $this->command?->error("  ✗ Exception for {$serviceName}: ".$e->getMessage());
            }
        }

        $this->command?->info('  Service images seeding complete.');
    }
}
