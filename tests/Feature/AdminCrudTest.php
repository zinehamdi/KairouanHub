<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_denied_access_to_admin_routes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('admin.categories.index'))->assertForbidden();
        $this->get(route('admin.services.index'))->assertForbidden();
    }

    public function test_admin_can_crud_category_and_service(): void
    {
        Role::findOrCreate('admin');
        $admin = User::factory()->create();
        $admin->syncRoles(['admin']);
        $this->actingAs($admin);

        // Create Category
        $categoryData = ['name' => 'Test Cat', 'slug' => 'test-cat', 'is_active' => 1];
        $this->post(route('admin.categories.store'), $categoryData)->assertRedirect();
        $category = Category::where('slug', 'test-cat')->firstOrFail();

        // Update Category
        $this->put(route('admin.categories.update', $category), ['name' => 'Test Cat 2', 'slug' => 'test-cat', 'is_active' => 1])
            ->assertRedirect();

        // Create Service
        $serviceData = ['category_id' => $category->id, 'name' => 'Test Svc', 'slug' => 'test-svc', 'is_active' => 1];
        $this->post(route('admin.services.store'), $serviceData)->assertRedirect();
        $service = Service::where('slug', 'test-svc')->firstOrFail();

        // Update Service
        $this->put(route('admin.services.update', $service), ['category_id' => $category->id, 'name' => 'Test Svc 2', 'slug' => 'test-svc', 'is_active' => 1])
            ->assertRedirect();

        // Delete Service
        $this->delete(route('admin.services.destroy', $service))->assertRedirect();

        // Delete Category
        $this->delete(route('admin.categories.destroy', $category))->assertRedirect();
    }
}
