<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            RegionalSeeder::class,
            RoSeeder::class,
            RuasSeeder::class,
            BidangKeluhanSeeder::class,
            GolonganKendaraanSeeder::class,
            SumberSeeder::class,
            UnitSeeder::class,
            StatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            JenisClaimSeeder::class,
            AppVarSeeder::class
        ]);
    }
}
