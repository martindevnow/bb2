<?php

namespace Tests\Unit\Vendor;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\ACL\User;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

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
