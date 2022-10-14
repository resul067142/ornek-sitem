<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kitaplar>
 */
class KitaplarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'kitap_adi' => $this->faker->sentence(3),
            'cinsiyet' => $this->faker->randomElement([ 'Erkek', 'Kadın', 'Bilinmiyor' ]),
            'dogum_tarihi' => $this->faker->dateTimeBetween('-200 years', '-1 years'),
            'lat' => $this->faker->latitude($min = 40, $max = 42),
            'lon' => $this->faker->latitude($min = 27, $max = 29)
        ];
    }
}
