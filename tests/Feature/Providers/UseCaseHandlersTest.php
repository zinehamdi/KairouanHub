<?php

namespace Tests\Feature\Providers;

use Application\Providers\UseCases\CreateProviderProfileHandler;
use App\Models\User;
use Domain\Providers\Enums\ProviderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class UseCaseHandlersTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_handler_respects_auto_approve_flag(): void
    {
        $user = User::factory()->create();
        config(['appsettings.providers.auto_approve' => false]);
        $handler = new CreateProviderProfileHandler();
        $profile = $handler->handle([
            'user_id' => $user->id,
            'display_name' => 'Demo Provider',
            'city' => 'Kairouan'
        ]);
        $this->assertEquals(ProviderStatus::Pending->value, $profile->status);

        $this->assertDatabaseHas('provider_profiles',[ 'id' => $profile->id, 'status' => ProviderStatus::Pending->value ]);
    }

    public function test_create_handler_auto_approves_when_config_true(): void
    {
        $user = User::factory()->create();
        config(['appsettings.providers.auto_approve' => true]);
        $handler = new CreateProviderProfileHandler();
        $profile = $handler->handle([
            'user_id' => $user->id,
            'display_name' => 'Fast Provider',
            'city' => 'Tunis'
        ]);
        $this->assertEquals(ProviderStatus::Approved->value, $profile->status);
    }

    public function test_create_handler_prevents_duplicate_profile(): void
    {
        $user = User::factory()->create();
        config(['appsettings.providers.auto_approve' => true]);
        $handler = new CreateProviderProfileHandler();
        $handler->handle([
            'user_id' => $user->id,
            'display_name' => 'Primary',
            'city' => 'Sousse'
        ]);

        $this->expectException(InvalidArgumentException::class);
        $handler->handle([
            'user_id' => $user->id,
            'display_name' => 'Duplicate',
            'city' => 'Sfax'
        ]);
    }
}
