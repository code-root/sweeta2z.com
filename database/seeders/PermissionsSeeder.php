<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run() : void
        {
            $permissions = [
                'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
                'view_blog', 'create_blog', 'edit_blog', 'delete_blog',
                'view_ourClient', 'create_ourClient', 'edit_ourClient', 'delete_ourClient',
                'view_ourTeam', 'create_ourTeam', 'edit_ourTeam', 'delete_ourTeam',
                'view_country', 'create_country', 'edit_country', 'delete_country',
            ];
            foreach ($permissions as $permissionName) {
                Permission::create(['name' => $permissionName]);
            }
    }
}
