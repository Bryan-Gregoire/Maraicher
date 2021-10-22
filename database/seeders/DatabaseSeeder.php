<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            //adminpassword
            'password' => '$2y$10$inFxzApQY2pRigxj3HnX6uZmTf1CJhcyDoE5WEFZS9Z6jTbVRFXca',
        ]);
        $users = User::factory()->count(12)->create();
        $offers = Offer::factory()->count(50)->make();
        foreach ($offers as $offer) {
            $offer->user_id = rand(1, 13);
            $offer->save();
        }

    }
}
