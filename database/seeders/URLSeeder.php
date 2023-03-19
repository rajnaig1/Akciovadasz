<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class URLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('URLS')->insert([
            '_id' => 1,
            'Shop' => 'penny',
            'URL' => 'https://www.penny.hu/api/products?page=%u&pageSize=%u&sortBy=relevance',
        ]);
        DB::table('URLS')->insert([
            '_id' => 2,
            'Shop' => 'tesco',
            'URL' => 'https://tesco.hu/Ajax?apage=1&limit=10000&type=load-more-products&path=/akciok/akcios-termekek/&get={}&page_url=/akciok/akcios-termekek',
        ]);
    }
}
