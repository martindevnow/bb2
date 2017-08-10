<?php

namespace Tests\Unit\ACL;

use Martin\ACL\Permission;
use Martin\ACL\Role;
use Martin\ACL\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermissionsUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function permissions_have_a_model_factory() {
        $permission = factory(Permission::class)->create();

        $this->assertTrue($permission instanceof Permission);
    }

    /** @test */
    public function permissions_have_all_fields_mass_assignable() {
        $permission = factory(Permission::class)->make();
        Permission::create($permission->toArray());

        $this->assertDatabaseHas('permissions', $permission->toArray());
    }

    /** @test */
    public function permissions_can_be_assigned_to_a_role() {
        $permission = factory(Permission::class)->create();
        $role = factory(Role::class)->create();

        $permission->assignToRole($role);
        $permission = $permission->fresh(['roles']);

        $this->assertCount(1, $permission->roles);
        $this->assertDatabaseHas('permission_role', [
            'role_id'   => $role->id,
            'permission_id' => $permission->id,
        ]);
    }

    /** @test */
    public function permissions_can_be_removed_from_roles() {
        /** @var Permission $permission */
        $permission = factory(Permission::class)->create();
        $role = factory(Role::class)->create();
        $permission->assignToRole($role);

        $role = $role->fresh(['permissions']);
        $permission = $permission->fresh(['roles']);

        $this->assertDatabaseHas('permission_role', [
            'role_id'   => $role->id,
            'permission_id' => $permission->id,
        ]);

        $permission->removeFromRole($role);

        $permission = $permission->fresh(['roles']);

        $this->assertCount(0, $permission->roles);
        $this->assertDatabaseMissing('permission_role', [
            'role_id'   => $role->id,
            'permission_id' => $permission->id,
        ]);
    }

    /** @test */
    public function permissions_can_be_queried_on_a_user_by_model_and_code() {
        $permission[] = factory(Permission::class)->create(['code'=> 'post']);
        $permission[] = factory(Permission::class)->create(['code'=> 'delete']);

        /** @var Role $role */
        $role = factory(Role::class)->create();

        $role->givePermissionTo($permission[0]);
        $role->givePermissionTo($permission[1]);

        /** @var User $user */
        $user = factory(User::class)->create();

        $user->assignRole($role);

        $user = $user->fresh(['roles']);
        $this->assertTrue($user->hasPermission($permission[0]));
        $this->assertTrue($user->hasPermission('delete'));
        $this->assertTrue($user->hasPermission(Permission::all()));
        $this->assertFalse($user->hasPermission(true));

        $this->assertCount(2, $user->permissions());
    }
}
