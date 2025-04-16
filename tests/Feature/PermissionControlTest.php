<?php

use App\Models\{Permission, User};
use Database\Seeders\{PermissionSeeder, UserSeeder};

use function Pest\Laravel\{assertDatabaseHas, seed};

it('should be able to give an user a permission to do something', function () {
    /** @var User $user */
    $user = User::factory()->create();
    $user->givePermissionTo('be an admin');

    expect($user)->hasPermissionTo('be an admin')->toBeTrue();

    \Pest\Laravel\assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => $user->id,
        'permission_id' => Permission::where('key', 'be an admin')->first()->id,
    ]);
});

it('should be have a seed for permissions', function () {

    $this->seed(PermissionSeeder::class);

    assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);
});

it('should seed with an admin', function () {
    seed([PermissionSeeder::class, UserSeeder::class]);

    assertDatabaseHas('permissions', [
        'key' => 'be an admin',
    ]);

    assertDatabaseHas('permission_user', [
        'user_id'       => 1,
        'permission_id' => Permission::where('key', 'be an admin')->first()->id,
    ]);

});
