<?php

namespace Tests\Feature;

use App\Models\Oil;
use App\Models\Service;
use App\Models\Sparepart;
use App\Models\Tire;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeders_populate_catalogs_and_are_repeatable(): void
    {
        $this->seed(DatabaseSeeder::class);

        $counts = [
            Service::count(),
            Tire::count(),
            Oil::count(),
            Sparepart::count(),
        ];

        foreach ($counts as $count) {
            $this->assertGreaterThan(0, $count);
        }

        $this->seed(DatabaseSeeder::class);

        $this->assertSame($counts, [
            Service::count(),
            Tire::count(),
            Oil::count(),
            Sparepart::count(),
        ]);
    }
}
