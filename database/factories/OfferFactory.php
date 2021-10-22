<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory ;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('fr_BE');
        $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
        return [

            'title' => rand()==0?$faker->fruitName():$faker->vegetableName(),
            'price'=>$faker->randomFloat(2,0.5,20),
            'quantity'=>$faker->numberBetween(1,20),
            'expirationDate'=>$faker->dateTimeBetween('-1 month','+1 month')->format('Y-m-d H:i:s'),
            'address'=>$faker->address(),
        ];
    }

}

