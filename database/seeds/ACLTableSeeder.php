<?php

use Illuminate\Database\Seeder;
use Martin\ACL\Role;
use Martin\ACL\User;
use Martin\Customers\Pet;

class ACLTableSeeder extends Seeder
{
    use CanSeedFromCSV;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();

        echo "loading Roles..\n\r";
        $this->seedFromCSV('roles','/seeds/csv/roles.csv', Role::class);

        echo "loading Permissions..\n\r";
        $this->seedFromCSV('permissions', '/seeds/csv/permissions.csv', \Martin\ACL\Permission::class);

        echo "loading permission_role..\n\r";
        $this->seedFromCSV('permission_role', '/seeds/csv/permission_role.csv');

        echo "loading role_user..\n\r";
        $this->seedFromCSV('role_user', '/seeds/csv/role_user.csv');

    }
}
