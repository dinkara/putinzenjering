<?php

use Illuminate\Database\Seeder;

use App\Repositories\SocialNetwork\ISocialNetworkRepo;
use App\Support\Enum\SocialNetworks;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ISocialNetworkRepo $socialRepo)
    {
        $socialNetworks = SocialNetworks::all();
        
        foreach ($socialNetworks as $network) {
            $socialRepo->firstOrCreate(["name" => $network]);
        }
    }
}
