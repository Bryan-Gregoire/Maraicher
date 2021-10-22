<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title'=>$this->faker->text,
            'price'=>$this->faker->randomFloat(2,1,20),
            'quantity'=>$this->faker->numberBetween(1,100),
            'expirationDate'=>$this->faker->dateTime,
            'address'=>$this->faker->address
        ];
    }
}
