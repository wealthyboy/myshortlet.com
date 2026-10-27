<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\Apartments\ApartmentsController;
use App\Models\Apartment;
use App\Models\User;
use App\Services\Channex\AriOutboxService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ApartmentAccessibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'accessibility_test', 'database.connections.accessibility_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ], 'services.channexpro.shared_token' => null]);
        DB::purge('accessibility_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Bus::fake();
        $this->app->instance(\App\Http\ViewComposer\NavComposer::class, new class {
            public function compose($view) {}
        });
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);
        Schema::create('system_settings', function (Blueprint $table) { $table->id(); });
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            foreach (['name', 'price', 'sale_price', 'slug', 'max_adults', 'quantity', 'image_link', 'video_link',
                'bedroom_1', 'bedroom_2', 'bedroom_3', 'bedroom_4', 'bedroom_5', 'bedroom_6', 'type', 'floor',
                'price_mode', 'apartment_id', 'allow', 'owner_email', 'wifi_password', 'wifi_ssid', 'teaser',
                'image', 'no_of_rooms', 'sale_price_expires', 'property_id', 'uuid', 'toilets'] as $field) {
                $table->text($field)->nullable();
            }
            $table->timestamps(); $table->softDeletes();
        });
        DB::table('apartments')->insert(['id' => 1, 'name' => 'Existing apartment']);
        require_once database_path('migrations/2026_10_27_153000_add_elevator_access_to_apartments_table.php');
        (new \AddElevatorAccessToApartmentsTable)->up();
        Schema::create('apartment_facility', function (Blueprint $table) {
            $table->integer('apartment_id'); $table->integer('facility_id');
        });
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); $table->integer('user_id'); $table->string('email'); $table->string('username');
            $table->string('action'); $table->timestamps(); $table->softDeletes();
        });
        $user = new User(['name' => 'Test admin', 'email' => 'admin@example.test']); $user->id = 1;
        $this->actingAs($user);
        $this->mock(AriOutboxService::class, function ($mock) {
            $mock->shouldReceive('queueBaseAriChange')->andReturnNull();
        });
    }

    private function controller(): ApartmentsController
    {
        // Exercise the real save actions without unrelated rate-plan creation/provider calls.
        return new class extends ApartmentsController {
            protected function syncChannexRatePlans(Apartment $apartment, Request $request) { return collect(); }
        };
    }

    private function input(array $extra = []): Request
    {
        return Request::create('/admin/apartments', 'POST', array_replace([
            'room_name' => 'Test apartment', 'room_price' => 100, 'room_quantity' => 1,
            'room_max_adults' => 7, 'room_number' => 3, 'room_toilets' => 3.5,
            'floor' => '1st floor', 'property_id' => 20, 'apartment_allow' => 1,
            'room_sale_price_expires' => '',
        ], $extra));
    }

    public function test_existing_apartments_remain_unspecified_and_boolean_values_serialize_correctly(): void
    {
        $this->assertNull(Apartment::findOrFail(1)->elevator_access);
        foreach ([true, false, null] as $value) {
            $apartment = Apartment::findOrFail(1);
            $apartment->elevator_access = $value; $apartment->save();
            $fresh = $apartment->fresh();
            $this->assertSame($value, $fresh->elevator_access);
            $this->assertSame($value, $fresh->setAppends([])->toArray()['elevator_access']);
        }
    }

    public function test_create_and_edit_save_yes_no_and_explicitly_clear_the_accessibility_field(): void
    {
        $controller = $this->controller();
        $controller->store($this->input(['elevator_access' => '1']));
        $id = Apartment::latest('id')->value('id');
        $this->assertTrue(Apartment::findOrFail($id)->elevator_access);
        $controller->update($this->input(['elevator_access' => '0']), $id);
        $this->assertFalse(Apartment::findOrFail($id)->elevator_access);
        $controller->update($this->input(), $id);
        $this->assertFalse(Apartment::findOrFail($id)->elevator_access, 'Older forms must preserve the saved value.');
        $controller->update($this->input(['elevator_access' => '']), $id);
        $this->assertNull(Apartment::findOrFail($id)->elevator_access);
        $controller->store($this->input());
        $this->assertNull(Apartment::latest('id')->first()->elevator_access);
    }

    public function test_invalid_accessibility_is_rejected_before_any_apartment_is_changed(): void
    {
        foreach (['store', 'update'] as $action) {
            try {
                $this->controller()->{$action}($this->input(['elevator_access' => 'sometimes']), 1);
                $this->fail('Invalid accessibility should not be saved.');
            } catch (ValidationException $exception) {
                $this->assertArrayHasKey('elevator_access', $exception->errors());
            }
        }
        $this->assertSame(1, Apartment::count());
        $this->assertSame('Existing apartment', Apartment::findOrFail(1)->name);
        Bus::assertNothingDispatched();
    }

    public function test_admin_select_restores_all_three_values_and_public_text_does_not_guess_unknown(): void
    {
        foreach ([true => '1', false => '0'] as $value => $expected) {
            $apartment = new Apartment(['elevator_access' => (bool) $value]);
            $html = view('admin.apartments._accessibility', compact('apartment'))->render();
            $dom = new \DOMDocument; @$dom->loadHTML($html); $xpath = new \DOMXPath($dom);
            $this->assertSame($expected, $xpath->query('//select[@name="elevator_access"]/option[@selected]')->item(0)->getAttribute('value'));
            $public = view('_partials.elevator_access', ['obj' => $apartment])->render();
            $this->assertStringContainsString($value ? 'Elevator access' : 'No elevator access', $public);
        }
        $unknown = new Apartment;
        $this->assertStringNotContainsString('apartment-elevator-access', view('_partials.elevator_access', ['obj' => $unknown])->render());
        $html = view('admin.apartments._accessibility', ['apartment' => $unknown])->render();
        $this->assertStringContainsString('value="" selected', $html);
        request()->setLaravelSession(app('session')->driver());
        session()->flashInput(['elevator_access' => '0']);
        $html = view('admin.apartments._accessibility', ['apartment' => new Apartment(['elevator_access' => true])])->render();
        $this->assertStringContainsString('value="0" selected', $html);
    }
}
