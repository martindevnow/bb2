<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ACLTableSeeder::class);
        $this->call(SubscriptionDetailsSeeder::class);
        $this->call(PetsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(MeatsTableSeeder::class);
        $this->call(PickupLocationsAndAppointmentsSeeder::class);
        $this->call(SubscriptionsSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
    }
}
