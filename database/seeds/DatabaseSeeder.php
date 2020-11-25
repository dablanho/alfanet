<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Epigra\TrGeoZones\Database\Seeders\GeozoneCountriesTableSeeder::class);
        $this->call(Epigra\TrGeoZones\Database\Seeders\GeozoneCitiesTableSeeder::class);
        $this->call(Epigra\TrGeoZones\Database\Seeders\GeozoneCityDistrictsTableSeeder::class);
        /*$this->call(StarterKit::class);
        $this->call(ParaBirimleriSeeder::class);*/
    }
}
