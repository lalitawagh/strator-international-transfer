<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kanexy\Cms\Enums\Role as EnumsRole;
use Kanexy\InternationalTransfer\Enums\Permission as EnumsPermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InternationalTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $TRANSFER_TYPE_FEE_VIEW = Permission::create(['name' => EnumsPermission::TRANSFER_TYPE_FEE_VIEW]);
        $TRANSFER_TYPE_FEE_CREATE = Permission::create(['name' => EnumsPermission::TRANSFER_TYPE_FEE_CREATE]);
        $TRANSFER_TYPE_FEE_EDIT = Permission::create(['name' => EnumsPermission::TRANSFER_TYPE_FEE_EDIT]);
        $TRANSFER_TYPE_FEE_DELETE = Permission::create(['name' => EnumsPermission::TRANSFER_TYPE_FEE_DELETE]);

        $SUPER_ADMIN = Role::where(['name' => EnumsRole::SUPER_ADMIN])->first();
        $SUPER_ADMIN->givePermissionTo(Permission::all());
    }
}
