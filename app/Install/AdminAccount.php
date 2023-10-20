<?php

namespace App\Install;

use Modules\User\Entities\User;
use Modules\Authorization\Entities\Role;
use Modules\Authorization\Entities\Permission;

class AdminAccount
{
    public function setup($data)
    {
        $permissions = $this->generatePermissions();

        $role = $this->generateRoles($permissions);

        $admin = User::create([
            'name'          => $data['admin']['name'],
            'mobile'        => $data['admin']['mobile'],
            'email'         => $data['admin']['email'],
            'image'         => '/uploads/users/user.png',
            'password'      => bcrypt($data['admin']['password']),
        ]);

        $admin->roles()->attach($role);
    }

    private function generateRoles($permissions)
    {
        $role = Role::create([
          'name'                => 'super-admin',
        ]);

        foreach ($permissions as $key => $value) {
            $role->attachPermission($value);
        }

        $role->translateOrNew('en')->display_name = 'Super Admin';
        $role->translateOrNew('en')->description  = 'This Role for super admin , Can manage all application settings [ add , edit , delete , show ]';

        $role->save();

        return $role;
    }

    private function generatePermissions()
    {
        // Dashboard Access Permission
        $permissions[] = [
            'access' => [
                'name'          => 'dashboard_access',
                'display_name'  => 'access',
                'description'   => 'Access Dashboard',
            ],
        ];

        // Roles Permissions
        $permissions[] = [
            'show' => [
              'name'          => 'show_roles',
              'display_name'  => 'roles',
              'description'   => 'show',
            ],
            'add'  => [
              'name'          => 'add_roles',
              'display_name'  => 'roles',
              'description'   => 'add',
            ],
            'edit'  => [
              'name'          => 'edit_roles',
              'display_name'  => 'roles',
              'description'   => 'edit',
            ],
            'delete'  => [
              'name'          => 'delete_roles',
              'display_name'  => 'roles',
              'description'   => 'delete',
            ],
        ];

        // Users Permissions
        $permissions[] = [
            'show' => [
              'name'          => 'show_users',
              'display_name'  => 'users',
              'description'   => 'show',
            ],
            'add'  => [
              'name'          => 'add_users',
              'display_name'  => 'users',
              'description'   => 'add',
            ],
            'edit'  => [
              'name'          => 'edit_users',
              'display_name'  => 'users',
              'description'   => 'edit',
            ],
            'delete'  => [
              'name'          => 'delete_users',
              'display_name'  => 'users',
              'description'   => 'delete',
            ],
        ];

        // Admins Permissions
        $permissions[] = [
            'show' => [
              'name'          => 'show_admins',
              'display_name'  => 'admins',
              'description'   => 'show',
            ],
            'add'  => [
              'name'          => 'add_admins',
              'display_name'  => 'admins',
              'description'   => 'add',
            ],
            'edit'  => [
              'name'          => 'edit_admins',
              'display_name'  => 'admins',
              'description'   => 'edit',
            ],
            'delete'  => [
              'name'          => 'delete_admins',
              'display_name'  => 'admins',
              'description'   => 'delete',
            ],
        ];

        // Pages Permissions
        $permissions[] = [
            'show' => [
              'name'          => 'show_pages',
              'display_name'  => 'pages',
              'description'   => 'show',
            ],
            'add'  => [
              'name'          => 'add_pages',
              'display_name'  => 'pages',
              'description'   => 'add',
            ],
            'edit'  => [
              'name'          => 'edit_pages',
              'display_name'  => 'pages',
              'description'   => 'edit',
            ],
            'delete'  => [
              'name'          => 'delete_pages',
              'display_name'  => 'pages',
              'description'   => 'delete',
            ],
        ];

        // Settings Permissions
        $permissions[] = [
            'edit'  => [
              'name'          => 'edit_settings',
              'display_name'  => 'settings',
              'description'   => 'edit',
            ],
            'show'  => [
              'name'          => 'show_settings',
              'display_name'  => 'settings',
              'description'   => 'show',
            ],
        ];

        // FCM Permissions
        $permissions[] = [
            'show'  => [
              'name'          => 'show_notifications',
              'display_name'  => 'notifications',
              'description'   => 'edit',
            ],
            'send'  => [
              'name'          => 'send_notifications',
              'display_name'  => 'notifications',
              'description'   => 'show',
            ],
        ];

        foreach ($permissions as $permission) {

            foreach ($permission as $key => $data) {

                $perm = Permission::create([
                  'name'                => $data['name'],
                  'display_name'        => $data['display_name'],
                ]);

                $perm->translateOrNew('en')->description = $data['description'];

                $perm->save();

                $ids[] = $perm['id'];
            }

        }

        return $ids;
    }
}
