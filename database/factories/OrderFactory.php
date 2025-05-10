<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $wilayas = [
            'Adrar',
            'Chlef',
            'Laghouat',
            'Oum El Bouaghi',
            'Batna',
            'Béjaïa',
            'Biskra',
            'Béchar',
            'Blida',
            'Bouira',
            'Tamanrasset',
            'Tébessa',
            'Tlemcen',
            'Tiaret',
            'Tizi Ouzou',
            'Algiers',
            'Djelfa',
            'Jijel',
            'Sétif',
            'Saïda',
            'Skikda',
            'Sidi Bel Abbès',
            'Annaba',
            'Guelma',
            'Constantine',
            'Médéa',
            'Mostaganem',
            'M’Sila',
            'Mascara',
            'Ouargla',
            'Oran',
            'El Bayadh',
            'Illizi',
            'Bordj Bou Arréridj',
            'Boumerdès',
            'El Tarf',
            'Tindouf',
            'Tissemsilt',
            'El Oued',
            'Khenchela',
            'Souk Ahras',
            'Tipaza',
            'Mila',
            'Aïn Defla',
            'Naâma',
            'Aïn Témouchent',
            'Ghardaïa',
            'Relizane',
            'Timimoun',
            'Bordj Badji Mokhtar',
            'Ouled Djellal',
            'Béni Abbès',
            'In Salah',
            'In Guezzam',
            'Touggourt',
            'Djanet',
            'El M’Ghair',
            'El Meniaa'
        ];
        $communes = [
            'Bab Ezzouar',
            'El Biar',
            'Sidi Mhamed',
            'Hussein Dey',
            'Kouba',
            'Bir Mourad Raïs',
            'Dar El Beïda',
            'Chéraga',
            'Aïn Benian',
            'Staoueli',
            'Bordj El Kiffan',
            'Mohammadia',
            'Oran Ville',
            'Es Senia',
            'Arzew',
            'Gdyel',
            'Bethioua',
            'Constantine Ville',
            'El Khroub',
            'Aïn Abid',
            'Hamma Bouziane',
            'Annaba Ville',
            'El Bouni',
            'Seraïdi',
            'Blida Ville',
            'Boufarik',
            'Ouled Yaïch',
            'Chréa'
        ];

        return [
            'id' => Str::uuid()->toString(),
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => '0' . $this->faker->numberBetween(5, 7) . $this->faker->numerify('#######'),
            'wilaya' => $this->faker->randomElement($wilayas),
            'commune' => $this->faker->randomElement($communes),
            'address' => $this->faker->streetAddress(),
            'total' => 0, // Updated by FakePopulateCommand
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'completed']),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
