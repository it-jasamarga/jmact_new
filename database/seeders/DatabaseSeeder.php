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
            UnitSeeder::class,
            GolonganKendaraanSeeder::class,
            SumberSeeder::class,
            StatusSeeder::class,
            TypeSeeder::class,
            BidangKeluhanSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            JenisClaimSeeder::class,
            AppVarSeeder::class,
            FeedbackUnsatisfactionSeeder::class,
        ]);
    }
}
