<?php

namespace Database\Factories;

use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellerProfile>
 */
class SellerProfileFactory extends Factory
{
    protected $model = SellerProfile::class;

    private static array $cities = [
        'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
        'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi',
    ];

    private static array $provinces = [
        'DKI Jakarta', 'Jawa Timur', 'Jawa Barat', 'Sumatera Utara',
        'Jawa Tengah', 'Sulawesi Selatan', 'Sumatera Selatan', 'Banten',
    ];

    private static array $businessTypes = ['Perorangan', 'CV', 'UD', 'PT', 'Koperasi'];

    public function definition(): array
    {
        $cityIndex = fake()->numberBetween(0, count(self::$cities) - 1);
        $provinceIndex = min($cityIndex, count(self::$provinces) - 1);

        return [
            'user_id'           => User::factory(),
            'business_name'     => fake()->company() . ' ' . fake()->randomElement(['Recycle', 'Jaya', 'Abadi', 'Mandiri']),
            'business_type'     => fake()->randomElement(self::$businessTypes),
            'npwp'              => null,
            'nib'               => null,
            'description'       => fake()->paragraphs(2, true),
            'address'           => fake()->streetAddress(),
            'city'              => self::$cities[$cityIndex],
            'province'          => self::$provinces[$provinceIndex],
            'postal_code'       => fake()->numerify('#####'),
            'latitude'          => fake()->latitude(-8.5, -6.0),
            'longitude'         => fake()->longitude(106.0, 112.0),
            'bank_name'         => fake()->randomElement(['BCA', 'BRI', 'BNI', 'Mandiri', 'CIMB']),
            'bank_account_number' => fake()->numerify('##########'),
            'bank_account_name' => fake()->name(),
            'verification_status' => fake()->randomElement([
                SellerProfile::VERIFICATION_PENDING,
                SellerProfile::VERIFICATION_VERIFIED,
                SellerProfile::VERIFICATION_VERIFIED,
                SellerProfile::VERIFICATION_VERIFIED
            ]),
            'rejection_reason'  => null,
            'verified_at'       => null,
        ];
    }

    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => SellerProfile::VERIFICATION_VERIFIED,
            'verified_at'         => now()->subDays(fake()->numberBetween(1, 90)),
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => SellerProfile::VERIFICATION_PENDING,
            'verified_at'         => null,
        ]);
    }
}
