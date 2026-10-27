<?php

namespace Tests\Feature;

use App\Jobs\NotifyChannexProReservationEvent;
use App\Models\{ApartmentChannelPriceRule, Permission, Property, User, UserPermission};
use App\Services\ChannexPro\{AriExportService, ChannelPricing};
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Bus, DB, Schema};
use Mockery;

class ApartmentChannelPricingTest extends ChannexProReservationReceiverTest
{
    protected function setUp(): void
    {
        parent::setUp();
        require_once database_path('migrations/2026_10_26_000001_create_apartment_channel_price_rules.php');
        (new \CreateApartmentChannelPriceRules)->up();
        Schema::table('properties', function (Blueprint $table) { $table->string('name')->default('AVM'); });
        $pricing = Mockery::mock(ChannelPricing::class)->makePartial();
        $pricing->shouldReceive('channels')->andReturn([['code' => 'Expedia', 'title' => 'Expedia'], ['code' => 'BookingCom', 'title' => 'Booking.com']]);
        $this->app->instance(ChannelPricing::class, $pricing);
    }

    private function admin(string $code = '2'): void
    {
        $user = new User(['name' => 'Price admin']); $user->id = 1;
        $permission = new UserPermission; $permission->setRelation('permission', new Permission(['code' => $code]));
        $user->setRelation('users_permission', $permission); $this->actingAs($user);
    }

    private function priceRequest(array $rules = []): array
    {
        return ['channel' => 'Expedia', 'rules' => $rules ?: [58 => ['percent' => 10, 'amount' => 5]]];
    }

    public function test_apartment_channel_markup_is_saved_while_base_price_stays_unchanged(): void
    {
        $this->withoutExceptionHandling();
        $this->admin();
        $this->put('/admin/properties/20/channel-pricing', $this->priceRequest())->assertRedirect();
        $this->assertDatabaseHas('apartment_channel_price_rules', ['apartment_id' => 58, 'channel' => 'Expedia', 'percent' => 10, 'amount' => 5]);
        $this->assertSame(100.0, (float) DB::table('apartments')->where('id', 58)->value('price'));
        Bus::assertDispatched(NotifyChannexProReservationEvent::class, fn ($job) => $job->payload['event'] === 'ari.updated' && $job->payload['affected'][0]['property_id'] === '20');
    }

    public function test_invalid_markdowns_and_cross_property_ids_never_partially_save(): void
    {
        $this->admin();
        foreach ([[58 => ['percent' => -100, 'amount' => 0]], [58 => ['percent' => 0, 'amount' => -100]], [59 => ['percent' => 1, 'amount' => 0]]] as $rules) {
            $this->put('/admin/properties/20/channel-pricing', $this->priceRequest($rules))->assertSessionHasErrors();
            $this->assertSame(0, ApartmentChannelPriceRule::count());
        }
        Bus::assertNotDispatched(NotifyChannexProReservationEvent::class);
    }

    public function test_source_export_preserves_base_ari_and_sends_channel_adjustments_separately(): void
    {
        ApartmentChannelPriceRule::create(['apartment_id' => 58, 'channel' => 'Expedia', 'percent' => 10, 'amount' => -5, 'currency' => 'USD']);
        ApartmentChannelPriceRule::create(['apartment_id' => 59, 'channel' => 'Expedia', 'percent' => 90, 'amount' => 0, 'currency' => 'USD']);
        $property = Property::findOrFail(20);
        $rules = app(ChannelPricing::class)->export($property);
        $this->assertCount(1, $rules); $this->assertSame('58', $rules[0]['room_type_id']); $this->assertSame(-5.0, $rules[0]['amount']);
        $feed = app(AriExportService::class)->export($property, Carbon::parse('2026-12-01'), Carbon::parse('2026-12-02'));
        $this->assertSame(100.0, $feed['restrictions'][0]['rate']);
        $this->assertSame(1, $feed['availability'][0]['availability']);
    }

    public function test_pricing_form_renders_clear_preview_and_requires_apartment_permission(): void
    {
        $this->admin();
        $this->app->instance(\App\Http\ViewComposer\NavComposer::class, new class { public function compose($view) {} });
        $uri = $_SERVER['REQUEST_URI'] ?? null; $_SERVER['REQUEST_URI'] = '/admin/properties/20/channel-pricing';
        try {
            $this->get('/admin/properties/20/channel-pricing?channel=Expedia')->assertOk()->assertSee('ChannexPro adjustment')->assertSee('Save &amp; refresh ChannexPro', false);
        } finally { if ($uri === null) unset($_SERVER['REQUEST_URI']); else $_SERVER['REQUEST_URI'] = $uri; }
        $this->admin('3');
        $this->put('/admin/properties/20/channel-pricing', $this->priceRequest())->assertForbidden();
    }
}
