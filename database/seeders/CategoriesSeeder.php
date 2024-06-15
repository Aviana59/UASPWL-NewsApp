<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Sport',
                'seotitle' => 'sport',
                'active' => 'yes',
            ],
            [
                'title' => 'Bussiness',
                'seotitle' => 'bussines',
                'active' => 'yes',
            ],
            [
                'title' => 'Health',
                'seotitle' => 'health',
                'active' => 'yes',
            ],
            [
                'title' => 'Politic',
                'seotitle' => 'Politic',
                'active' => 'yes',
            ],

        ];

        foreach ($categories as $key => $category) {
            Categories::create($category);
        }
    }
}
