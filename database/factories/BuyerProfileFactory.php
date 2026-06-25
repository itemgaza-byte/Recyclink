<?php

namespace Database\Factories;

use App\Models\BuyerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BuyerProfile>
 */
class BuyerProfileFactory extends Factory
{
    protected $model = BuyerProfile::class;

    private static array $cities = [
        'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
        'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi',
    ];

    private static array $provinces = [
        'DKI Jakarta', 'Jawa Timur', 'Jawa Barat', 'Sumatera Utara',
        'Jawa Tengah', 'Sulawesi Selatan', 'Sumatera Selatan', 'Banten',
    ];

    private static array $industryTypes = [
        'Manufaktur', 'Daur Ulang', 'Konstruksi', 'Pertambangan',
        'Pertanian', 'Pengolahan Makanan', 'Tekstil', 'Elektronik',
    ];

    public function definition(): array
    {
        $cityIndex = fake()->numberBetween(0, count(self::$cities) - 1);
        $provinceIndex = min($cityIndex, count(self::$provinces) - 1);

        return [
            'user_id'       => User::factory(),
            'company_name'  => fake()->optional(0.6)->company(),
            'address'       => fake()->streetAddress(),
            'city'          => self::$cities[$cityIndex],
            'province'      => self::$provinces[$provinceIndex],
            'postal_code'   => fake()->numerify('#####'),
            'latitude'      => fake()->latitude(-8.5, -6.0),
            'longitude'     => fake()->longitude(106.0, 112.0),
            'industry_type' => fake()->randomElement(self::$industryTypes),
        ];
    }
}
