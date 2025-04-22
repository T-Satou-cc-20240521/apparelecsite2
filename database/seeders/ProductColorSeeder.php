<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_colors')->insert([
            ['name' => 'ホワイト', 'code' => '#FFFFFF'],
            ['name' => 'ブラック', 'code' => '#000000'],
            ['name' => 'グレー', 'code' => '#808080'],
            ['name' => 'レッド', 'code' => '#FF0000'],
            ['name' => 'ブルー', 'code' => '#0000FF'],
            ['name' => 'ネイビー', 'code' => '#000080'],
            ['name' => 'グリーン', 'code' => '#008000'],
            ['name' => 'イエロー', 'code' => '#FFFF00'],
            ['name' => 'ピンク', 'code' => '#FFC0CB'],
            ['name' => 'ベージュ', 'code' => '#F5F5DC'],
            ['name' => 'ブラウン', 'code' => '#8B4513'],
            ['name' => 'パープル', 'code' => '#800080'],
            ['name' => 'オレンジ', 'code' => '#FFA500'],
            ['name' => 'カーキ', 'code' => '#F0E68C'],
            ['name' => 'ライトグレー', 'code' => '#D3D3D3'],
        ]);
    }
}

