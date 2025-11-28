<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\JobRequest;
use App\Models\ProviderProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RequestsUITest extends TestCase
{
    use RefreshDatabase;

    public function test_requests_index_displays_open_requests()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Role::firstOrCreate(['name' => 'client']);
        $user->assignRole('client');

        $category = Category::create(['name' => 'Plumbing', 'slug' => 'plumbing']);

        // Create a few open requests
        JobRequest::create([
            'client_id' => $user->id,
            'category_id' => $category->id,
            'details' => 'Fix my sink',
            'city' => 'kairouan',
            'status' => 'open',
            'photos_json' => []
        ]);

        JobRequest::create([
            'client_id' => $user->id,
            'category_id' => $category->id,
            'details' => 'Fix bathroom',
            'city' => 'sousse',
            'status' => 'open',
            'photos_json' => []
        ]);

        $this->actingAs($user);
        $response = $this->get(route('requests.index'));

        $response->assertOk();
        $response->assertSee('Fix my sink');
        $response->assertSee('Fix bathroom');
        $response->assertSee('kairouan');
    }

    public function test_request_show_displays_photos()
    {
        Storage::fake('public');

        $client = User::factory()->create(['email_verified_at' => now()]);
        Role::firstOrCreate(['name' => 'client']);
        $client->assignRole('client');

        $category = Category::create(['name' => 'Cleaning', 'slug' => 'cleaning']);

        $photo = UploadedFile::fake()->image('test.jpg');
        $path = $photo->store('requests/' . $client->id, 'public');

        $request = JobRequest::create([
            'client_id' => $client->id,
            'category_id' => $category->id,
            'details' => 'Clean my house',
            'city' => 'kairouan',
            'status' => 'open',
            'photos_json' => [$path]
        ]);

        $this->actingAs($client);
        $response = $this->get(route('requests.show', $request->id));

        $response->assertOk();
        $response->assertSee('Clean my house');
        $response->assertSee('storage/' . $path);
    }

    public function test_request_create_page_loads_with_categories()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Role::firstOrCreate(['name' => 'client']);
        $user->assignRole('client');

        Category::create(['name' => 'Gardening', 'slug' => 'gardening']);
        Category::create(['name' => 'Painting', 'slug' => 'painting']);

        $this->actingAs($user);
        $response = $this->get(route('requests.create'));

        $response->assertOk();
        $response->assertSee('Gardening');
        $response->assertSee('Painting');
        $response->assertSee('Create Service Request');
    }
}
