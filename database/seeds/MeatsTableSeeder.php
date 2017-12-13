<?php

use Illuminate\Database\Seeder;

class MeatsTableSeeder extends Seeder
{
    use CanSeedFromCSV;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Loading \"Meats\"...\r\n";
        DB::table('meats')->truncate();
        $this->seedFromGoogle('meats', \Martin\Products\Meat::class);
    }
}
