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
        /**
         * User / ACL / Permissions and Roles
         */
//        $this->call(EventItemsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ACLTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(CouriersTableSeeder::class);

        $this->call(FaqsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);

        /**
         * Pets
         */
        $this->call(PetsTableSeeder::class);    // Must be after Users

        /**
         * Products
         */
        $this->call(ProductsTableSeeder::class);

        /**
         * Meats
         */
        $this->call(MeatsTableSeeder::class);
        $this->call(ToppingsTableSeeder::class);
        $this->call(MealsTableSeeder::class);

        /**
         * Subscription Models (Plans, Activity, Frequency, and Package)
         */
        $this->call(PackagesSeeder::class);
        $this->call(PlansTableSeeder::class);

        /**
         * Pickup Locations and Appointment Times
         */
//        $this->call(PickupLocationsAndAppointmentsSeeder::class);

        /**
         * Current Subscriptions
         */
//        $this->call(DeliveriesTableSeeder::class);
    }
}
