<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class InsertFoldersPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create users permissions
        Permission::create(['name' => 'folder-view']);
        Permission::create(['name' => 'folder-create']);
        Permission::create(['name' => 'folder-edit']);
        Permission::create(['name' => 'folder-delete']);
    }
}
