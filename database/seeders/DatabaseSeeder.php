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
        $admin = User::create([
            'name' => 'ADMIN',
            'email' => "admin@admin.com",
            "password" => '$2y$10$inFxzApQY2pRigxj3HnX6uZmTf1CJhcyDoE5WEFZS9Z6jTbVRFXca'
        ]);
        $users = User::factory()->count(10)->create();
        $offers = Offer::factory()->count(25)->make();
        foreach ($offers as $offer) {
            $offer->user_id = rand(1, 11);
            $offer->save();
        }
    }
}
