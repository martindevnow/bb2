<?php

use Illuminate\Database\Seeder;

class PickupLocationsAndAppointmentsSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pickup_locations')->truncate();
        DB::table('pickup_appointments')->truncate();

        $this->seedFromCSV('pickup_locations',
            '/seeds/csv/pickup_locations.csv',
            \Martin\Delivery\PickupLocation::class);

        $this->seedFromCSV('pickup_appointments',
            '/seeds/csv/pickup_appointments.csv',
            \Martin\Delivery\PickupAppointment::class);
    }
}
