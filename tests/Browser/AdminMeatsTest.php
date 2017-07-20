<?php

namespace Tests\Browser;

use Martin\ACL\Role;
use Martin\ACL\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminMeatsTest extends DuskTestCase
{

    /** @test */
    public function it_can_add_a_new_meat()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $role = factory(Role::class)->create(['code' => 'admin']);
            $user->assignRole($role);

            $browser->loginAs($user->id)
                ->visit('/admin/meats')
                ->assertSee('Meats');

            $browser->visit('/admin/meats/create')
                ->type('type', 'FAT Chicken')
                ->type('variety', 'Breast')
                ->type('code', 'F-CH')
                ->type('cost_per_lb', '1.69')
                ->click('Add');
        });
    }
}
