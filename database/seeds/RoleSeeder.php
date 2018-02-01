<?php

use Illuminate\Database\Seeder;
use App\Repositories\Role\IRoleRepo;
use App\Support\Enum\RoleTypes;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IRoleRepo $roleRepo) {
        $roles = RoleTypes::all();

        foreach ($roles as $role) {
            $roleRepo->firstOrCreate(["name" => $role]);
        }
    }

}

