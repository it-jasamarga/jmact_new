<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Facades\Str;
use App\Models\Role;
use App\Models\Permission;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        $array = [
            [
                'name' => 'Superadmin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'User',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Guest',
                'guard_name' => 'web'
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Role::insert($array);

        $roles = Role::get();

        foreach($roles as $k => $role){
            $data = file_get_contents('resources/json/menuJson.json');
            $json = json_decode($data,true);
            $arrayPermission = [];
            foreach ($json['menu'] as $value) {
            if(!is_array($value['perms'])){
                if(isset($value['action'])){

                foreach ($value['action'] as $k => $action) {
                    $Permission = Permission::where('name', $value['perms'].'.'.$action)->first();
                    if(!$Permission){
                    $notExist = [
                        'name' => $value['perms'].'.'.$action
                    ];
                    $Permission = Permission::create($notExist);
                    }
                    array_push($arrayPermission,$value['perms'].'.'.$action);
                }
                }
            }else{
                if(isset($value['action'])){

                foreach ($value['submenu'] as $k2 => $value2) {
                    foreach ($value2['action'] as $k => $action) {

                    $Permission = Permission::where('name', $value2['perms'].'.'.$action)->first();
                    if(!$Permission){
                        $notExist = [
                        'name' => $value2['perms'].'.'.$action
                        ];
                        $Permission = Permission::create($notExist);
                    }
                    array_push($arrayPermission,$value2['perms'].'.'.$action);
                    }
                }
                }
            }
            }
            $Permission = Permission::whereIn('name',$arrayPermission)->pluck('id');
            
            $role->permissions()->sync($Permission);
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
}
