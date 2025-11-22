<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FinalFeaturesTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(\Database\Seeders\RolesSeeder::class);
	}

	public function test_can_get_localization()
	{
		$response = $this->getJson('/api/v1/locales/en');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'locale',
					'translations',
				],
			]);
	}

	public function test_can_upload_media()
	{
		Storage::fake('public');
		$user = User::factory()->create();

		$file = UploadedFile::fake()->image('test.jpg');

		$response = $this->actingAs($user)
			->postJson('/api/v1/media/upload', [
				'file' => $file,
				'type' => 'image',
			]);

		$response->assertStatus(201)
			->assertJsonStructure([
				'status',
				'data' => [
					'path',
					'url',
					'filename',
				],
			]);
	}

	public function test_can_get_homepage_data()
	{
		$response = $this->getJson('/api/v1/home');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'featured_services',
					'top_providers',
					'statistics',
				],
			]);
	}

	public function test_can_list_notifications()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)
			->getJson('/api/v1/notifications');

		$response->assertStatus(200)
			->assertJsonStructure([
				'status',
				'data' => [
					'data',
					'unread_count',
					'pagination',
				],
			]);
	}
}
