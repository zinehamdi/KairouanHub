<?php

namespace Tests\Feature\Requests;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\Offer;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function seedRoles(): void { \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'client']); \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'provider']); }

    public function test_owner_can_view_request_show(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $job = JobRequest::factory()->create(['client_id'=>$client->id,'category_id'=>$category->id,'city'=>'Kairouan']);
        $this->actingAs($client)->get(route('requests.show',$job->id))->assertOk();
    }

    public function test_provider_who_offered_can_view(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $job = JobRequest::factory()->create(['client_id'=>$client->id,'category_id'=>$category->id,'city'=>'Kairouan']);
        $pUser = User::factory()->create(); $pUser->assignRole('provider');
        $p = ProviderProfile::factory()->approved()->create(['user_id'=>$pUser->id,'city'=>'Kairouan']);
        Offer::create(['request_id'=>$job->id,'provider_id'=>$p->id,'status'=>'pending']);
        $this->actingAs($pUser)->get(route('requests.show',$job->id))->assertOk();
    }

    public function test_random_provider_cannot_view_if_not_city_match(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $job = JobRequest::factory()->create(['client_id'=>$client->id,'category_id'=>$category->id,'city'=>'Kairouan']);
        $pUser = User::factory()->create(); $pUser->assignRole('provider');
        ProviderProfile::factory()->approved()->create(['user_id'=>$pUser->id,'city'=>'Tunis']); // different city
        $this->actingAs($pUser)->get(route('requests.show',$job->id))->assertForbidden();
    }
}
