<?php

namespace Database\Seeders;

use App\Models\WasteCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WasteCategorySeeder extends Seeder
{
    // ponytail: data array — no abstraction needed
    private array $categories = [
        ['category_name' => 'Logam & Metal',           'icon' => 'icon-metal',      'color' => '#6B7280', 'children' => [
            ['category_name' => 'Besi & Baja',          'icon' => 'icon-iron',       'color' => '#4B5563'],
            ['category_name' => 'Aluminium',            'icon' => 'icon-aluminium',  'color' => '#9CA3AF'],
            ['category_name' => 'Tembaga',              'icon' => 'icon-copper',     'color' => '#B45309'],
            ['category_name' => 'Kuningan',             'icon' => 'icon-brass',      'color' => '#D97706'],
            ['category_name' => 'Logam Campuran',       'icon' => 'icon-mixed-metal','color' => '#6B7280'],
        ]],
        ['category_name' => 'Plastik',                 'icon' => 'icon-plastic',    'color' => '#3B82F6', 'children' => [
            ['category_name' => 'Plastik PET (Botol)', 'icon' => 'icon-pet',        'color' => '#60A5FA'],
            ['category_name' => 'Plastik HDPE',        'icon' => 'icon-hdpe',       'color' => '#2563EB'],
            ['category_name' => 'Plastik PVC',         'icon' => 'icon-pvc',        'color' => '#1D4ED8'],
            ['category_name' => 'Plastik PP',          'icon' => 'icon-pp',         'color' => '#3B82F6'],
            ['category_name' => 'Styrofoam / EPS',     'icon' => 'icon-styrofoam',  'color' => '#BFDBFE'],
        ]],
        ['category_name' => 'Kertas & Karton',         'icon' => 'icon-paper',      'color' => '#F59E0B', 'children' => [
            ['category_name' => 'Kertas HVS & Koran',  'icon' => 'icon-paper-hvs',  'color' => '#FCD34D'],
            ['category_name' => 'Kardus & Karton',     'icon' => 'icon-cardboard',  'color' => '#D97706'],
            ['category_name' => 'Kertas Campuran',     'icon' => 'icon-paper-mix',  'color' => '#F59E0B'],
        ]],
        ['category_name' => 'Kaca & Keramik',          'icon' => 'icon-glass',      'color' => '#06B6D4', 'children' => [
            ['category_name' => 'Kaca Bening',         'icon' => 'icon-glass-clear','color' => '#67E8F9'],
            ['category_name' => 'Kaca Berwarna',       'icon' => 'icon-glass-color','color' => '#0891B2'],
            ['category_name' => 'Keramik & Porselen',  'icon' => 'icon-ceramic',    'color' => '#06B6D4'],
        ]],
        ['category_name' => 'Elektronik (E-Waste)',    'icon' => 'icon-electronic', 'color' => '#8B5CF6', 'children' => [
            ['category_name' => 'Komputer & Laptop',   'icon' => 'icon-computer',   'color' => '#7C3AED'],
            ['category_name' => 'Ponsel & Tablet',     'icon' => 'icon-phone',      'color' => '#8B5CF6'],
            ['category_name' => 'Printer & Scanner',   'icon' => 'icon-printer',    'color' => '#A78BFA'],
            ['category_name' => 'Kabel & PCB',         'icon' => 'icon-cable',      'color' => '#6D28D9'],
            ['category_name' => 'Baterai & Aki',       'icon' => 'icon-battery',    'color' => '#4C1D95'],
        ]],
        ['category_name' => 'Kayu & Biomassa',         'icon' => 'icon-wood',       'color' => '#92400E', 'children' => [
            ['category_name' => 'Serbuk & Serutan Kayu','icon' => 'icon-sawdust',   'color' => '#B45309'],
            ['category_name' => 'Kayu Bekas & Palet',  'icon' => 'icon-pallet',     'color' => '#92400E'],
            ['category_name' => 'Sekam & Jerami',      'icon' => 'icon-straw',      'color' => '#D97706'],
            ['category_name' => 'Ampas Tebu',          'icon' => 'icon-bagasse',    'color' => '#78350F'],
        ]],
        ['category_name' => 'Tekstil & Kain',          'icon' => 'icon-textile',    'color' => '#EC4899', 'children' => [
            ['category_name' => 'Kain Perca & Sisa Jahitan','icon' => 'icon-fabric','color' => '#F472B6'],
            ['category_name' => 'Pakaian Bekas Industri','icon' => 'icon-clothes',  'color' => '#DB2777'],
            ['category_name' => 'Benang & Serat',      'icon' => 'icon-thread',     'color' => '#EC4899'],
        ]],
        ['category_name' => 'Karet & Ban',             'icon' => 'icon-rubber',     'color' => '#1F2937', 'children' => [
            ['category_name' => 'Ban Bekas',           'icon' => 'icon-tire',       'color' => '#374151'],
            ['category_name' => 'Karet Campuran',      'icon' => 'icon-rubber-mix', 'color' => '#4B5563'],
        ]],
        ['category_name' => 'Minyak & Cairan Industri','icon' => 'icon-oil',        'color' => '#D97706', 'children' => [
            ['category_name' => 'Minyak Jelantah',     'icon' => 'icon-cooking-oil','color' => '#F59E0B'],
            ['category_name' => 'Pelumas Bekas',       'icon' => 'icon-lubricant',  'color' => '#92400E'],
            ['category_name' => 'Solvent & Thinner',   'icon' => 'icon-solvent',    'color' => '#B45309'],
        ]],
        ['category_name' => 'Limbah Organik',          'icon' => 'icon-organic',    'color' => '#16A34A', 'children' => [
            ['category_name' => 'Sisa Makanan & FOGO', 'icon' => 'icon-food-waste', 'color' => '#22C55E'],
            ['category_name' => 'Kompos & Pupuk Organik','icon' => 'icon-compost',  'color' => '#15803D'],
            ['category_name' => 'Limbah Pertanian',    'icon' => 'icon-agriculture','color' => '#16A34A'],
        ]],
    ];

    public function run(): void
    {
        $sortOrder = 1;
        foreach ($this->categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parent = WasteCategory::updateOrCreate(
                ['slug' => Str::slug($categoryData['category_name'])],
                array_merge($categoryData, ['parent_id' => null, 'is_active' => true, 'sort_order' => $sortOrder++])
            );

            $childOrder = 1;
            foreach ($children as $child) {
                WasteCategory::updateOrCreate(
                    ['slug' => Str::slug($child['category_name'])],
                    array_merge($child, ['parent_id' => $parent->id, 'is_active' => true, 'sort_order' => $childOrder++])
                );
            }

            $this->command->info("✓ {$parent->category_name} (" . count($children) . ' sub)');
        }
    }
}
