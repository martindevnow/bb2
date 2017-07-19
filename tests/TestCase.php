<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Martin\ACL\Role;
use Martin\ACL\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

    public function loginAsAdmin() {
        $role = factory(Role::class)->create(['code' => 'admin']);

        $this->user = factory(User::class)->create();
        $this->user->assignRole($role);
        $this->user = $this->user->fresh(['roles']);
        $this->be($this->user);
    }
}
