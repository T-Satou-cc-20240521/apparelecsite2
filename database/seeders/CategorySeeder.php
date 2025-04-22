<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'メンズ']);
        Category::create(['name' => 'キッズ']);
        Category::create(['name' => 'レディース']);
    }
}
