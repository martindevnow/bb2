<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Martin\ACL\Role;
use Martin\ACL\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use SupportsSoftDeletes;

    public $user;

    public function createAdminUser() {
        $role = factory(Role::class)->create(['code' => 'admin']);
        $this->user = factory(User::class)->create();
        $this->user->assignRole($role);
        $this->user = $this->user->fresh(['roles']);
    }

    public function loginAsAdmin() {
        $this->createAdminUser();
        $this->be($this->user);
    }

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }
}
