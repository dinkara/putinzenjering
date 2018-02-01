<?php

use Illuminate\Database\Seeder;
use App\Repositories\User\IUserRepo;
use App\Repositories\Role\IRoleRepo;
use App\Support\Enum\RoleTypes;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IUserRepo $userRepo, IRoleRepo $roleRepo)
    {
        $admins = [
            [
                "email" => "ndzakovic@yahoo.com",
                "password" => "prasence123"
            ]
        ];
        for($i=0; $i < count($admins); $i++){
            $userRepo->create($admins[$i])->attachRole($roleRepo->findByName(RoleTypes::ADMIN)->getModel());
        }
    }
}