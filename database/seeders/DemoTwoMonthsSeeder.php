<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Expense;
use App\Models\Payroll;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * One-week demo seeder (fast, no slot-search loops).
 * All inserted rows carry note tag 'DEMO_1W …' so they can be wiped cleanly.
 */
class DemoTwoMonthsSeeder extends Seeder
{
    private const NOTE_BOOKING  = 'DEMO_1W booking sample';
    private const NOTE_EXPENSE  = 'DEMO_1W finance sample';
    private const NOTE_PAYROLL  = 'DEMO_1W payroll sample';

    /** Fixed time slots used for bookings — avoids any loop-based slot search. */
    private const SLOTS = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];


    public function run(): void
    {
        // Clear any previous demo data (both old 2-month tag and current 1-week tag)
        Booking::query()->whereIn('notes', ['DEMO_2M booking sample', self::NOTE_BOOKING])->delete();
        Expense::query()->whereIn('notes', ['DEMO_2M finance sample', self::NOTE_EXPENSE])->delete();
        Payroll::query()->whereIn('notes', ['DEMO_2M payroll sample', self::NOTE_PAYROLL])->delete();

        $services     = Service::query()->where('is_active', true)->get();
        $staffMembers = Staff::query()->where('is_active', true)->get();

        if ($services->isEmpty() || $staffMembers->isEmpty()) {
            $this->command->warn('No services or staff found — skipping demo seed.');
            return;
        }

        $names = [
            'Aisha Kamau','Brian Otieno','Clara Mwangi','Daniel Njoroge','Eunice Wanjiku',
            'Faith Achieng','George Kiptoo','Hellen Atieno','Irene Wambui','James Maina',
            'Karen Nyambura','Lydia Naliaka','Mercy Njeri','Naomi Cherotich','Peter Kibet',
        ];

        // Past 6 days (yesterday back to 6 days ago) — all completed/confirmed/cancelled
        for ($daysAgo = 6; $daysAgo >= 1; $daysAgo--) {
            $date = now()->subDays($daysAgo)->toDateString();
            $slots = self::SLOTS;
            shuffle($slots);
            $count = random_int(3, 5);

            for ($i = 0; $i < $count && isset($slots[$i]); $i++) {
                $staff   = $staffMembers->random();
                $service = $services->firstWhere('category_id', $staff->service_category_id) ?? $services->first();
                $status  = collect(['completed','completed','confirmed','cancelled'])->random();
                $name    = $names[array_rand($names)];

                Booking::query()->create([
                    'user_id'            => null,
                    'service_id'         => $service->id,
                    'preferred_staff_id' => rand(0, 1) ? $staff->id : null,
                    'staff_id'           => $staff->id,
                    'booking_date'       => $date,
                    'booking_time'       => $slots[$i],
                    'status'             => $status,
                    'customer_name'      => $name,
                    'customer_email'     => strtolower(str_replace(' ', '.', $name)).'@example.com',
                    'customer_phone'     => '+2547'.random_int(10000000, 99999999),
                    'notes'              => self::NOTE_BOOKING,
                    'created_at'         => $date.' '.sprintf('%02d:00', random_int(8, 18)),
                    'updated_at'         => $date.' '.sprintf('%02d:00', random_int(8, 20)),
                ]);
            }
        }

        // Today — mix of pending (needs approval), confirmed, and one cancellation
        $today = now()->toDateString();
        $todaySlots = self::SLOTS;
        shuffle($todaySlots);
        $todayStatuses = ['pending','pending','pending','confirmed','pending','cancelled'];

        foreach ($todayStatuses as $idx => $status) {
            if (! isset($todaySlots[$idx])) {
                break;
            }
            $staff   = $staffMembers->values()->get($idx % $staffMembers->count());
            $service = $services->firstWhere('category_id', $staff->service_category_id) ?? $services->first();
            $name    = $names[array_rand($names)];

            Booking::query()->create([
                'user_id'            => null,
                'service_id'         => $service->id,
                'preferred_staff_id' => $staff->id,
                'staff_id'           => $staff->id,
                'booking_date'       => $today,
                'booking_time'       => $todaySlots[$idx],
                'status'             => $status,
                'customer_name'      => $name,
                'customer_email'     => strtolower(str_replace(' ', '.', $name)).'@example.com',
                'customer_phone'     => '+2557'.random_int(10000000, 99999999),
                'notes'              => self::NOTE_BOOKING,
                'created_at'         => now()->subMinutes(60 - ($idx * 8)),
                'updated_at'         => now()->subMinutes(5),
            ]);
        }

        // Expenses — 3-4 entries spread across the week
        $expenseTypes = [
            ['title' => 'Electricity Bill',      'category' => 'Utilities'],
            ['title' => 'Spa Supplies Restock',   'category' => 'Supplies'],
            ['title' => 'Internet Service',        'category' => 'Utilities'],
            ['title' => 'Cleaning Services',       'category' => 'Operations'],
        ];
        foreach ($expenseTypes as $idx => $item) {
            $date = now()->subDays($idx * 2)->toDateString();
            Expense::query()->create([
                'title'        => $item['title'],
                'category'     => $item['category'],
                'amount'       => random_int(45000, 420000),
                'expense_date' => $date,
                'notes'        => self::NOTE_EXPENSE,
                'created_at'   => $date.' 10:00:00',
                'updated_at'   => $date.' 10:00:00',
            ]);
        }

        // Payroll — one entry per active staff member for this month
        $payDate = now()->endOfMonth()->toDateString();
        foreach ($staffMembers as $staff) {
            Payroll::query()->create([
                'staff_id'   => $staff->id,
                'amount'     => random_int(420000, 1200000),
                'pay_date'   => $payDate,
                'notes'      => self::NOTE_PAYROLL,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]);
        }
    }
}
