<?php

use Illuminate\Database\Seeder;
use App\Models\Website;
class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Website::create(['name' => 'Tech Blog', 'url' => 'https://techblog.com']);
        Website::create(['name' => 'News Hub', 'url' => 'https://newshub.com']);
    }
}
