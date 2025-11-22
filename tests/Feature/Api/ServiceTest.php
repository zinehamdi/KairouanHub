<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
	use RefreshDatabase;

	public function test_can_list_categories()
	{
		Category::factory()->count(3)->create(['is_active' => true]);

		$response = $this->getJson('/api/v1/categories');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'*' => ['id', 'name', 'slug', 'services_count']
				]
			]);
	}

	public function test_can_list_services()
	{
		$category = Category::factory()->create(['is_active' => true]);
		Service::factory()->count(5)->create([
			'category_id' => $category->id,
			'is_active' => true
		]);

		$response = $this->getJson('/api/v1/services');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'data' => [
						'*' => ['id', 'name', 'category', 'providers_count']
					],
					'meta' => ['current_page', 'total']
				]
			]);
	}

	public function test_can_search_services()
	{
		Service::factory()->create(['name' => 'Plumbing Service', 'is_active' => true]);
		Service::factory()->create(['name' => 'Electrical Service', 'is_active' => true]);

		$response = $this->getJson('/api/v1/services?search=Plumbing');

		$response->assertStatus(200)
			->assertJsonCount(1, 'data.data')
			->assertJsonFragment(['name' => 'Plumbing Service']);
	}

	public function test_can_filter_services_by_category()
	{
		$cat1 = Category::factory()->create(['is_active' => true]);
		$cat2 = Category::factory()->create(['is_active' => true]);

		Service::factory()->create(['category_id' => $cat1->id, 'is_active' => true]);
		Service::factory()->create(['category_id' => $cat2->id, 'is_active' => true]);

		$response = $this->getJson("/api/v1/services?category_id={$cat1->id}");

		$response->assertStatus(200)
			->assertJsonCount(1, 'data.data');
	}
}
