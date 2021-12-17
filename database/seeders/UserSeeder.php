<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasterUnit;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create user super admin
        $unit = MasterUnit::where('unit','JMTC')->first();

        $cekUser = User::where('email','admin@gmail.com')->first();
        if($cekUser){
            $cekUser->delete();
        }
        $user = User::create([
            'username'      => 'admin',
            'email'         => 'admin@gmail.com',
            'status_id'     => '1', // status active
            'kd_comp'       => '0', // status active
            'npp'           => '0', // status active
            'is_ldap'       => '0', // status active
            'password'      => bcrypt('password'),
            'unit_id'      => $unit->id
        ]);

        // sync user Farhan Riuzaki to role super admin
        $user->syncRoles(['Superadmin']);
        
    }
}
