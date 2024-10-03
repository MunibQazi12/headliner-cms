<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleTableSeederForEditor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleTypes = ['EDITOR'];
        foreach ($roleTypes as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
