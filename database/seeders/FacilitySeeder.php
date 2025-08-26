<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Material;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        // Create materials first (extract unique from samples)
        $materialNames = [
            'Computers', 'Smartphones', 'Lithium-ion Batteries', 'AA Batteries', 'Paper', 'Glass', 'Aluminium',
            'Laptops', 'Printers', 'Toner Cartridges', 'Cellphones', 'Chargers', 'Small Electronics',
            'Cardboard', 'Glass Bottles', 'Plastic Bottles', 'Monitors', 'Power Cables', 'Electronics',
            'Tablets', 'Steel', 'LED Bulbs', 'Small Appliances', 'Batteries'
        ];

        foreach (array_unique($materialNames) as $name) {
            Material::create(['name' => $name]);
        }

        // Facilities with attachments
        $facilities = [
            [
                'business_name' => 'Green Earth Recyclers',
                'last_update_date' => '2023-11-04',
                'street_address' => '123 5th Ave',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'materials' => ['Computers', 'Smartphones', 'Batteries']
            ],
            [
                'business_name' => 'EcoNYC Recycling',
                'last_update_date' => '2024-02-10',
                'street_address' => '45 Main St',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'postal_code' => '11201',
                'materials' => ['Paper', 'Glass', 'Aluminium']
            ],
            [
                'business_name' => 'Hudson Valley E-Waste',
                'last_update_date' => '2023-12-18',
                'street_address' => '250 Market St',
                'city' => 'Poughkeepsie',
                'state' => 'NY',
                'postal_code' => '12601',
                'materials' => ['Laptops', 'Printers', 'Toner Cartridges']
            ],
            [
                'business_name' => 'Manhattan Green Disposal',
                'last_update_date' => '2024-01-15',
                'street_address' => '78 Broadway',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10007',
                'materials' => ['Cellphones', 'Chargers', 'Small Electronics']
            ],
            [
                'business_name' => 'Upstate Reuse Center',
                'last_update_date' => '2023-09-22',
                'street_address' => '14 Elm St',
                'city' => 'Albany',
                'state' => 'NY',
                'postal_code' => '12207',
                'materials' => ['Cardboard', 'Glass Bottles', 'Plastic Bottles']
            ],
            [
                'business_name' => 'Bronx Eco Center',
                'last_update_date' => '2024-03-02',
                'street_address' => '856 E 136th St',
                'city' => 'Bronx',
                'state' => 'NY',
                'postal_code' => '10454',
                'materials' => ['Computers', 'Monitors', 'Power Cables']
            ],
            [
                'business_name' => 'Staten Island Renew',
                'last_update_date' => '2023-11-27',
                'street_address' => '201 Bay St',
                'city' => 'Staten Island',
                'state' => 'NY',
                'postal_code' => '10301',
                'materials' => ['Paper', 'Cardboard', 'Electronics']
            ],
            [
                'business_name' => 'Queens Recycling Hub',
                'last_update_date' => '2024-02-25',
                'street_address' => '95-12 150th St',
                'city' => 'Jamaica',
                'state' => 'NY',
                'postal_code' => '11435',
                'materials' => ['Smartphones', 'Tablets', 'Lithium-ion Batteries']
            ],
            [
                'business_name' => 'Brooklyn Materials Recovery',
                'last_update_date' => '2024-01-09',
                'street_address' => '600 Atlantic Ave',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'postal_code' => '11217',
                'materials' => ['Glass', 'Aluminium', 'Steel']
            ],
            [
                'business_name' => 'NY Sustainable Solutions',
                'last_update_date' => '2023-10-30',
                'street_address' => '400 Madison Ave',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10017',
                'materials' => ['Computers', 'LED Bulbs', 'Small Appliances']
            ],
        ];

        foreach ($facilities as $data) {
            $materials = $data['materials'];
            unset($data['materials']); // Remove materials from data to avoid mass assignment error
            $facility = Facility::create($data);
            $materialIds = Material::whereIn('name', $materials)->pluck('id');
            $facility->materials()->attach($materialIds);
        }
    }
}