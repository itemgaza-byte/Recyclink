<?php

namespace Database\Factories;

use App\Models\WasteCategory;
use App\Models\WasteListing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WasteListing>
 */
class WasteListingFactory extends Factory
{
    protected $model = WasteListing::class;

    private static array $wasteItems = [
        'Limbah Kertas Kardus', 'Limbah Plastik PET', 'Limbah Aluminium Bekas',
        'Limbah Besi Tua', 'Limbah Tembaga', 'Limbah Minyak Jelantah',
        'Limbah Karet Ban', 'Limbah Kaca Pecah', 'Limbah Elektronik (E-Waste)',
        'Serbuk Kayu', 'Sekam Padi', 'Ampas Tebu',
        'Limbah Tekstil Pabrik', 'Logam Campuran', 'Styrofoam Bekas',
        'Limbah Baterai', 'Plastik HDPE', 'Kaleng Aluminium',
    ];

    private static array $units = ['kg', 'ton', 'liter', 'pcs', 'karung', 'drum'];

    private static array $conditions = ['used', 'scrap', 'used', 'scrap', 'used'];

    private static array $cities = [
        'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
        'Makassar', 'Tangerang', 'Depok', 'Bekasi', 'Bogor',
    ];

    private static array $provinces = [
        'Jakarta'   => 'DKI Jakarta',
        'Surabaya'  => 'Jawa Timur',
        'Bandung'   => 'Jawa Barat',
        'Medan'     => 'Sumatera Utara',
        'Semarang'  => 'Jawa Tengah',
        'Makassar'  => 'Sulawesi Selatan',
        'Tangerang' => 'Banten',
        'Depok'     => 'Jawa Barat',
        'Bekasi'    => 'Jawa Barat',
        'Bogor'     => 'Jawa Barat',
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(self::$wasteItems) . ' ' . fake()->randomElement(['Grade A', 'Grade B', 'Kualitas Terjamin', 'Ready Stock']);
        $city  = fake()->randomElement(self::$cities);

        return [
            'seller_id'           => User::factory()->asSeller(),
            'category_id'         => WasteCategory::inRandomOrder()->first()?->id ?? WasteCategory::factory(),
            'title'               => $title,
            'slug'                => Str::slug($title) . '-' . fake()->unique()->numerify('####'),
            'description'         => fake()->paragraphs(3, true),
            'price_per_unit'      => fake()->randomFloat(2, 500, 50000),
            'unit'                => fake()->randomElement(self::$units),
            'min_order'           => fake()->randomFloat(2, 1, 50),
            'quantity'            => fake()->randomFloat(2, 100, 10000),
            'waste_condition'     => fake()->randomElement(self::$conditions),
            'address'             => fake()->streetAddress(),
            'city'                => $city,
            'province'            => self::$provinces[$city],
            'availability_status' => WasteListing::AVAILABILITY_AVAILABLE,
            'verification_status' => WasteListing::VERIFICATION_APPROVED,
            'view_count'          => fake()->numberBetween(0, 500),
            'published_at'        => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability_status' => WasteListing::AVAILABILITY_INACTIVE,
            'verification_status' => WasteListing::VERIFICATION_PENDING,
            'published_at'        => null,
        ]);
    }

    public function soldOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability_status' => WasteListing::AVAILABILITY_SOLD_OUT,
            'quantity'            => 0,
        ]);
    }
}
