<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list categoryproducts']);
        Permission::create(['name' => 'view categoryproducts']);
        Permission::create(['name' => 'create categoryproducts']);
        Permission::create(['name' => 'update categoryproducts']);
        Permission::create(['name' => 'delete categoryproducts']);

        Permission::create(['name' => 'list channels']);
        Permission::create(['name' => 'view channels']);
        Permission::create(['name' => 'create channels']);
        Permission::create(['name' => 'update channels']);
        Permission::create(['name' => 'delete channels']);

        Permission::create(['name' => 'list comments']);
        Permission::create(['name' => 'view comments']);
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'update comments']);
        Permission::create(['name' => 'delete comments']);

        Permission::create(['name' => 'list contacts']);
        Permission::create(['name' => 'view contacts']);
        Permission::create(['name' => 'create contacts']);
        Permission::create(['name' => 'update contacts']);
        Permission::create(['name' => 'delete contacts']);

        Permission::create(['name' => 'list formiptvs']);
        Permission::create(['name' => 'view formiptvs']);
        Permission::create(['name' => 'create formiptvs']);
        Permission::create(['name' => 'update formiptvs']);
        Permission::create(['name' => 'delete formiptvs']);

        Permission::create(['name' => 'list formrenouvellements']);
        Permission::create(['name' => 'view formrenouvellements']);
        Permission::create(['name' => 'create formrenouvellements']);
        Permission::create(['name' => 'update formrenouvellements']);
        Permission::create(['name' => 'delete formrenouvellements']);

        Permission::create(['name' => 'list formrevendeurs']);
        Permission::create(['name' => 'view formrevendeurs']);
        Permission::create(['name' => 'create formrevendeurs']);
        Permission::create(['name' => 'update formrevendeurs']);
        Permission::create(['name' => 'delete formrevendeurs']);

        Permission::create(['name' => 'list invoices']);
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'update invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list posts']);
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'update posts']);
        Permission::create(['name' => 'delete posts']);

        Permission::create(['name' => 'list postcategories']);
        Permission::create(['name' => 'view postcategories']);
        Permission::create(['name' => 'create postcategories']);
        Permission::create(['name' => 'update postcategories']);
        Permission::create(['name' => 'delete postcategories']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list reviews']);
        Permission::create(['name' => 'view reviews']);
        Permission::create(['name' => 'create reviews']);
        Permission::create(['name' => 'update reviews']);
        Permission::create(['name' => 'delete reviews']);

        Permission::create(['name' => 'list subscriptions']);
        Permission::create(['name' => 'view subscriptions']);
        Permission::create(['name' => 'create subscriptions']);
        Permission::create(['name' => 'update subscriptions']);
        Permission::create(['name' => 'delete subscriptions']);

        Permission::create(['name' => 'list supporttickets']);
        Permission::create(['name' => 'view supporttickets']);
        Permission::create(['name' => 'create supporttickets']);
        Permission::create(['name' => 'update supporttickets']);
        Permission::create(['name' => 'delete supporttickets']);

        Permission::create(['name' => 'list ticketreplies']);
        Permission::create(['name' => 'view ticketreplies']);
        Permission::create(['name' => 'create ticketreplies']);
        Permission::create(['name' => 'update ticketreplies']);
        Permission::create(['name' => 'delete ticketreplies']);

        Permission::create(['name' => 'list vods']);
        Permission::create(['name' => 'view vods']);
        Permission::create(['name' => 'create vods']);
        Permission::create(['name' => 'update vods']);
        Permission::create(['name' => 'delete vods']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
