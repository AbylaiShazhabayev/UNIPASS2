<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

class InsertPermissionValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create users permissions
        Permission::create(['name' => 'user-view']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);

        // create groups permissions
        Permission::create(['name' => 'group-view']);
        Permission::create(['name' => 'group-create']);
        Permission::create(['name' => 'group-edit']);
        Permission::create(['name' => 'group-delete']);
    }
}
