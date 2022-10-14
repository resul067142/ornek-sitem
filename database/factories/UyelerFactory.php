<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Uyeler>
 */
class UyelerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cinsiyet = $this->faker->randomElement([ 'male', 'female' ]);

        return [
            'isim' => $this->faker->firstName($cinsiyet),
            'soyisim' => $this->faker->lastName(),
            'email' => rand(1000, 9999).$this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'tc' => rand(10000000000, 99999999999),
            'cinsiyet' => $cinsiyet
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(\App\Models\Uyeler $uye) {
            $kitap = new \App\Models\Kitaplar;
            $kitap->kitap_adi = $this->faker->sentence(3);
            $kitap->cinsiyet = $this->faker->randomElement([ 'Erkek', 'Kadın', 'Bilinmiyor' ]);
            $kitap->dogum_tarihi = $this->faker->dateTimeBetween('-200 years', '-1 years');
            $kitap->lat = $this->faker->latitude($min = 40, $max = 42);
            $kitap->lon = $this->faker->latitude($min = 27, $max = 29);
            $kitap->uyeler_id = $uye->id;
            $kitap->save();
        });
    }
}
