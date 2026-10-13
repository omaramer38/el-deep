<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Module permissions
        $permissions = [
            // Elevators
            'elevators.view',
            'elevators.create',
            'elevators.edit',
            'elevators.delete',
            'elevators.publish',

            // Services
            'services.view',
            'services.create',
            'services.edit',
            'services.delete',
            'services.publish',

            // Projects
            'projects.view',
            'projects.create',
            'projects.edit',
            'projects.delete',
            'projects.publish',

            // Blog
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
            'blog.publish',

            // Pages & Sections
            'pages.view',
            'pages.edit',
            'pages.publish',

            // Testimonials
            'testimonials.view',
            'testimonials.manage',

            // Partners
            'partners.view',
            'partners.manage',

            // FAQs
            'faqs.view',
            'faqs.manage',

            // Media
            'media.view',
            'media.manage',

            // Messages
            'messages.view',
            'messages.manage',
            'messages.export',

            // SEO
            'seo.view',
            'seo.manage',

            // Settings
            'settings.view',
            'settings.manage',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Roles
            'roles.view',
            'roles.manage',

            // Activity Log
            'activity.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        // Super Admin gets all permissions via Gate::before or direct sync
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'elevators.view', 'elevators.create', 'elevators.edit', 'elevators.delete', 'elevators.publish',
            'services.view', 'services.create', 'services.edit', 'services.delete', 'services.publish',
            'projects.view', 'projects.create', 'projects.edit', 'projects.delete', 'projects.publish',
            'blog.view', 'blog.create', 'blog.edit', 'blog.delete', 'blog.publish',
            'pages.view', 'pages.edit', 'pages.publish',
            'testimonials.view', 'testimonials.manage',
            'partners.view', 'partners.manage',
            'faqs.view', 'faqs.manage',
            'media.view', 'media.manage',
            'messages.view', 'messages.manage',
            'seo.view', 'seo.manage',
            'activity.view',
        ]);

        $contentManager = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManager->syncPermissions([
            'elevators.view', 'elevators.create', 'elevators.edit', 'elevators.publish',
            'services.view', 'services.create', 'services.edit', 'services.publish',
            'projects.view', 'projects.create', 'projects.edit', 'projects.publish',
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish',
            'pages.view', 'pages.edit',
            'testimonials.view', 'testimonials.manage',
            'partners.view', 'partners.manage',
            'faqs.view', 'faqs.manage',
            'media.view', 'media.manage',
            'messages.view',
        ]);

        $editor = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $editor->syncPermissions([
            'elevators.view', 'elevators.create', 'elevators.edit',
            'services.view', 'services.create', 'services.edit',
            'projects.view', 'projects.create', 'projects.edit',
            'blog.view', 'blog.create', 'blog.edit',
            'media.view',
        ]);
    }
}
