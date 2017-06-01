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
        $this->call(UsersTableSeeder::class);
        $this->call(ACLTableSeeder::class);

        /**
         * Pets
         */
        $this->call(PetsTableSeeder::class);    // Must be after Users

        /**
         * Products
         */
        $this->call(ProductsTableSeeder::class);

        /**
         * Subscription Models (Plans, Activity, Frequency, and Package)
         */
        $this->call(PackagesSeeder::class);
        $this->call(ActivityLevelsSeeder::class);
        $this->call(FrequenciesSeeder::class);
        $this->call(PlansTableSeeder::class);       // Must be after Sub Data

        /**
         * Meats
         */
        $this->call(MeatsTableSeeder::class);

        /**
         * Pickup Locations and Appointment Times
         */
        $this->call(PickupLocationsAndAppointmentsSeeder::class);

        /**
         * Current Subscriptions
         */
        $this->call(SubscriptionsSeeder::class);    // Must be after Plans and Users and Pets
        $this->call(DeliveriesTableSeeder::class);
    }
}
