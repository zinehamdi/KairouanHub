<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PoliciesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_allowed_mutations(): void
    {
        // Ensure roles exist for the "web" guard in the test database
        Role::findOrCreate('admin');

        $admin = User::factory()->create();
        $admin->syncRoles(['admin']);
        $category = Category::factory()->create();
        $service = Service::factory()->for($category)->create();

        $this->actingAs($admin);
        $this->assertTrue($admin->can('create', Category::class));
        $this->assertTrue($admin->can('update', $category));
        $this->assertTrue($admin->can('delete', $category));
        $this->assertTrue($admin->can('create', Service::class));
        $this->assertTrue($admin->can('update', $service));
        $this->assertTrue($admin->can('delete', $service));
    }

    public function test_non_admin_denied_mutations(): void
    {
        // Ensure baseline roles exist
        Role::findOrCreate('client');
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $service = Service::factory()->for($category)->create();

        $this->actingAs($user);
        $this->assertFalse($user->can('create', Category::class));
        $this->assertFalse($user->can('update', $category));
        $this->assertFalse($user->can('delete', $category));
        $this->assertFalse($user->can('create', Service::class));
        $this->assertFalse($user->can('update', $service));
        $this->assertFalse($user->can('delete', $service));
    }
}
