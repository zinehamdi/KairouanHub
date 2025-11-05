<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/** Seed base roles — إنشاء الأدوار الأساسية */
class RolesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'client', 'provider'] as $role) {
            Role::findOrCreate($role);
        }
    }
}
