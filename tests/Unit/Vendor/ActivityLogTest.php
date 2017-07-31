<?php

namespace Tests\Unit\Vendor;

use Martin\ACL\User;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityLogTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function activity_log_package_is_enabled() {
        $user = User::create([
            'name'  => 'test222',
            'email'  => 'test222',
            'password'  => 'test222',
        ]);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertCount(1, Activity::all());
    }
}
