<?php

use Illuminate\Database\Seeder;
use App\Repositories\User\IUserRepo;
use App\Repositories\Role\IRoleRepo;
use App\Repositories\Profile\IProfileRepo;
use App\Support\Enum\RoleTypes;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(IUserRepo $userRepo, IRoleRepo $roleRepo, IProfileRepo $profileRepo)
    {
        $admins = [
            [
                "email" => "putin@yahoo.com",
                "password" => "putin123"
            ]
        ];
        
        $users = [
            [
                "email" => "putinuser@yahoo.com",
                "password" => "putin123"
            ]
        ];
        
        $profileData["name"] = "Putin";
        
        for($i=0; $i < count($admins); $i++){
            $userRepo->create($admins[$i])->attachRole($roleRepo->findByName(RoleTypes::ADMIN)->getModel());
            $profileData["user_id"] = $userRepo->getModel()->id;  
            
            $profileRepo->create($profileData);
        }
        
        for($i=0; $i < count($users); $i++){
            $userRepo->create($users[$i])->attachRole($roleRepo->findByName(RoleTypes::USER)->getModel());
            $profileData["user_id"] = $userRepo->getModel()->id;    
            $profileRepo->create($profileData);
        }
    }
}