<?php

use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Usuario
      Permission::create([
        'name' => 'Navegar usuarios',
        'slug' => 'users.index',
        'description' => 'Lista y navega todos los usuarios del sistema',
      ]);

      Permission::create([
        'name' => 'Navegar usuarios',
        'slug' => 'users.index',
        'description' => 'Lista y navega todos los usuarios del sistema',
      ]);


    }
}
