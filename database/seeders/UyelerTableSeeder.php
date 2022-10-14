<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use App\Models\Uyeler;

class UyelerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Uyeler::updateOrCreate(
            [
                'email' => 'asdasdasdasd@xyz.com',
            ],
            [
                'isim' => 'denemasdasd',
                'soyisim' => 'test',
                'password' => '1234',
                'tc' => '12345678901',
            ]
        );
    }
}
