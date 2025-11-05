<?php

namespace Tests\Feature\Providers;

use App\Models\Category;
use App\Models\ProviderProfile;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderDirectoryFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_only_approved_by_default(): void
    {
        $approved = ProviderProfile::factory()->approved()->create(['display_name' => 'Approved One']);
        $pending = ProviderProfile::factory()->pending()->create(['display_name' => 'Pending Hidden']);

        $res = $this->get(route('providers.index'));
        $res->assertOk();
        $res->assertSee('Approved One');
        $res->assertDontSee('Pending Hidden');
    }

    public function test_search_filter_q(): void
    {
        ProviderProfile::factory()->approved()->create(['display_name' => 'Alpha Studio']);
        ProviderProfile::factory()->approved()->create(['display_name' => 'Beta Works']);
        $res = $this->get(route('providers.index', ['q' => 'Alpha']));
        $res->assertSee('Alpha Studio');
        $res->assertDontSee('Beta Works');
    }

    public function test_city_filter(): void
    {
        ProviderProfile::factory()->approved()->create(['display_name' => 'CityA', 'city' => 'Kairouan']);
        ProviderProfile::factory()->approved()->create(['display_name' => 'CityB', 'city' => 'Sousse']);
        $res = $this->get(route('providers.index', ['city' => 'Kairouan']));
        $res->assertSee('CityA');
        $res->assertDontSee('CityB');
    }

    public function test_badge_filter(): void
    {
        ProviderProfile::factory()->approved()->create(['display_name' => 'BronzeGuy','badge_level' => 'bronze']);
        ProviderProfile::factory()->approved()->create(['display_name' => 'GoldGal','badge_level' => 'gold']);
        $res = $this->get(route('providers.index', ['badge' => 'gold']));
        $res->assertSee('GoldGal');
        $res->assertDontSee('BronzeGuy');
    }

    public function test_min_rating_filter(): void
    {
        ProviderProfile::factory()->approved()->create(['display_name' => 'LowRated','avg_rating' => 2.5]);
        ProviderProfile::factory()->approved()->create(['display_name' => 'HighRated','avg_rating' => 4.7]);
        $res = $this->get(route('providers.index', ['rating' => 4]));
        $res->assertSee('HighRated');
        $res->assertDontSee('LowRated');
    }

    public function test_category_filter_via_service(): void
    {
        $category = Category::factory()->create();
        $service = Service::factory()->create(['category_id' => $category->id]);
        $p1 = ProviderProfile::factory()->approved()->create(['display_name' => 'HasService']);
        $p2 = ProviderProfile::factory()->approved()->create(['display_name' => 'NoService']);
        $p1->services()->attach([$service->id => ['price_min' => 10, 'price_max' => 20]]);

        $res = $this->get(route('providers.index', ['category' => $service->id]));
        $res->assertSee('HasService');
        $res->assertDontSee('NoService');
    }

    public function test_unapproved_profile_hidden_from_public_show(): void
    {
        $pending = ProviderProfile::factory()->pending()->create(['display_name' => 'Invisible Pending']);
        $res = $this->get(route('providers.show', $pending->user->id));
        $res->assertNotFound();
    }
}
