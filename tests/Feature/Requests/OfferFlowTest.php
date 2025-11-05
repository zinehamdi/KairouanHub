<?php

namespace Tests\Feature\Requests;

use App\Models\Category;
use App\Models\JobRequest;
use App\Models\Offer;
use App\Models\ProviderProfile;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewOfferNotification;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OfferFlowTest extends TestCase
{
    use RefreshDatabase;

    private function seedRoles(): void { \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'client']); \Spatie\Permission\Models\Role::firstOrCreate(['name'=>'provider']); }

    public function test_approved_provider_can_submit_offer(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id'=>$category->id]);
        $job = JobRequest::factory()->create([
            'client_id'=>$client->id,
            'category_id'=>$category->id,
            'service_id'=>$service->id,
            'city'=>'Kairouan', 'status'=>'open'
        ]);
        $providerUser = User::factory()->create(); $providerUser->assignRole('provider');
        $profile = ProviderProfile::factory()->approved()->create(['user_id'=>$providerUser->id,'city'=>'Kairouan']);
        Notification::fake();

        $resp = $this->actingAs($providerUser)->post(route('offers.store',$job->id), [
            'price' => 100,
            'eta_days' => 3,
            'note' => 'We can handle it'
        ]);
        $resp->assertRedirect();
        $this->assertDatabaseHas('offers',[ 'request_id'=>$job->id,'provider_id'=>$profile->id,'status'=>'pending']);
        
        // Assert notification sent to client
        Notification::assertSentTo($client, NewOfferNotification::class);
    }

    public function test_client_can_accept_one_offer_only(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id'=>$category->id]);
        $job = JobRequest::factory()->create(['client_id'=>$client->id,'category_id'=>$category->id,'service_id'=>$service->id,'city'=>'Kairouan','status'=>'open']);
        // two providers
        $p1User = User::factory()->create(); $p1User->assignRole('provider');
        $p1 = ProviderProfile::factory()->approved()->create(['user_id'=>$p1User->id,'city'=>'Kairouan']);
        $p2User = User::factory()->create(); $p2User->assignRole('provider');
        $p2 = ProviderProfile::factory()->approved()->create(['user_id'=>$p2User->id,'city'=>'Kairouan']);
        Offer::create(['request_id'=>$job->id,'provider_id'=>$p1->id,'price'=>90,'eta_days'=>2,'status'=>'pending']);
        $o2 = Offer::create(['request_id'=>$job->id,'provider_id'=>$p2->id,'price'=>120,'eta_days'=>4,'status'=>'pending']);
        Notification::fake();

        $resp = $this->actingAs($client)->post(route('offers.accept',$o2->id));
        $resp->assertRedirect();
        $this->assertDatabaseHas('offers',['id'=>$o2->id,'status'=>'accepted']);
        $this->assertDatabaseHas('job_requests',['id'=>$job->id,'status'=>'matched']);
        
        // Assert notification sent to accepted provider
        Notification::assertSentTo($p2User, OfferAcceptedNotification::class);
    }

    public function test_unauthorized_cannot_view_or_offer(): void
    {
        $this->seedRoles();
        $client = User::factory()->create(); $client->assignRole('client');
        $category = Category::factory()->create();
        $job = JobRequest::factory()->create(['client_id'=>$client->id,'category_id'=>$category->id,'city'=>'Kairouan','status'=>'open']);
        $otherClient = User::factory()->create(); $otherClient->assignRole('client');
        // random provider without profile
        $provUser = User::factory()->create(); $provUser->assignRole('provider');
        $this->actingAs($otherClient)->get(route('requests.show',$job->id))->assertForbidden();
        $this->actingAs($provUser)->post(route('offers.store',$job->id), [])->assertForbidden();
    }
}
