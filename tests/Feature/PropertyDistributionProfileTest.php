<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\Properties\PropertiesController;
use App\Models\Property;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PropertyDistributionProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'property_profile_test',
            'database.connections.property_profile_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'services.channexpro.shared_token' => 'profile-test', 'app.url' => 'https://source.example']);
        DB::purge('property_profile_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Schema::create('system_settings', function (Blueprint $t) { $t->id(); });
        Schema::create('properties', function (Blueprint $t) {
            $t->id();
            foreach (['name', 'address', 'description', 'slug', 'token', 'image', 'type', 'mode', 'price', 'size',
                'check_in_time', 'check_out_time', 'cancellation_message', 'cancellation_fee', 'virtual_tour',
                'bedrooms', 'toilets', 'location_full_name', 'channex_group_id', 'channex_property_id'] as $column) {
                $t->text($column)->nullable();
            }
            foreach (['allow', 'is_refundable', 'featured', 'is_price_negotiable', 'is_shortlet'] as $column) {
                $t->boolean($column)->default(false);
            }
            $t->timestamps(); $t->softDeletes();
        });
        require_once database_path('migrations/2026_10_24_040000_add_distribution_profile_to_properties_table.php');
        (new \AddDistributionProfileToPropertiesTable)->up();
        Schema::create('apartments', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->string('name'); $t->decimal('price', 16, 2)->default(100);
            $t->integer('quantity')->default(1); $t->integer('max_adults')->default(2); $t->integer('max_children')->default(0);
            foreach (['slug', 'teaser', 'channex_room_type_id', 'channex_rate_plan_id'] as $column) { $t->text($column)->nullable(); }
            $t->boolean('allow')->default(true); $t->softDeletes();
        });
        Schema::create('locations', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('location_type'); $t->softDeletes();
        });
        Schema::create('location_property', function (Blueprint $t) { $t->integer('location_id'); $t->integer('property_id'); });
        foreach (['attribute', 'category'] as $relation) {
            Schema::create($relation.'_property', function (Blueprint $t) use ($relation) {
                $t->integer($relation.'_id'); $t->integer('property_id');
            });
        }
    }

    private function profile(): array
    {
        return ['email' => 'bookings@example.test', 'phone' => '+44 12345678', 'country_code' => 'gb',
            'state' => 'London', 'city' => 'London', 'zip_code' => '00123', 'website' => 'https://source.example/hotel',
            'timezone' => 'Europe/London', 'latitude' => 51.5, 'longitude' => -0.12,
            'important_information' => 'Please contact reception before arrival.'];
    }

    private function saveProperty(array $extra = [], ?int $id = null): Property
    {
        $request = Request::create('/admin/properties', 'POST', array_replace([
            'apartment_name' => 'Example Hotel', 'address' => '1 Example Street', 'description' => '<p>Hotel description</p>',
            'allow' => 1, 'type' => 'multiple', 'mode' => 'shortlet', 'attribute_id' => [], 'category_id' => [],
            'location_id' => [], 'property_extras' => [], 'property_extra_services' => [],
        ], $extra));
        return app(PropertiesController::class)->property($request, $id);
    }

    private function addRoom(Property $p): void
    {
        DB::table('apartments')->insert(['id' => 58, 'property_id' => $p->id, 'name' => 'Studio']);
    }

    public function test_shared_create_and_edit_save_path_persists_profile_and_legacy_saves_preserve_it(): void
    {
        $p = $this->saveProperty(['distribution_profile' => $this->profile()]);
        $this->assertSame('GB', $p->fresh()->distribution_profile['country_code']);
        $this->assertSame('00123', $p->fresh()->distribution_profile['zip_code']);
        $p = $this->saveProperty(['distribution_profile' => ['email' => 'updated@example.test']], $p->id);
        $this->assertSame('updated@example.test', $p->fresh()->distribution_profile['email']);
        $this->assertSame('00123', $p->fresh()->distribution_profile['zip_code']);
        $p = $this->saveProperty([], $p->id);
        $this->assertSame('updated@example.test', $p->fresh()->distribution_profile['email']);
        $this->assertSame(1, Property::count());
    }

    public function test_inventory_exports_saved_profile_with_existing_source_room_and_rate_ids(): void
    {
        $p = $this->saveProperty(['distribution_profile' => $this->profile()]); $this->addRoom($p);
        $this->getJson('/integration/channexpro/inventory', ['Authorization' => 'Bearer profile-test'])
            ->assertOk()->assertJsonPath('schema', 'channexpro.inventory.v1')
            ->assertJsonPath('properties.0.email', 'bookings@example.test')
            ->assertJsonPath('properties.0.country_code', 'GB')->assertJsonPath('properties.0.timezone', 'Europe/London')
            ->assertJsonPath('properties.0.domain', 'https://source.example/hotel')->assertJsonPath('properties.0.zip_code', '00123')
            ->assertJsonPath('properties.0.description', 'Hotel description')
            ->assertJsonPath('properties.0.address', '1 Example Street')->assertJsonPath('properties.0.latitude', 51.5)
            ->assertJsonPath('properties.0.room_types.0.id', '58')
            ->assertJsonPath('properties.0.room_types.0.rate_plans.0.id', 'standard:58')
            ->assertJsonPath('properties.0.room_types.0.currency', 'USD');
        $this->getJson('/integration/channexpro/inventory')->assertUnauthorized();
    }

    public function test_empty_optional_values_clear_and_unknown_keys_are_not_stored(): void
    {
        $p = $this->saveProperty(['distribution_profile' => $this->profile()]);
        $p = $this->saveProperty(['distribution_profile' => ['email' => null, 'website' => null, 'zip_code' => '0',
            'unexpected' => 'not allowed', 'country_code' => null, 'timezone' => null]], $p->id);
        $this->assertNull($p->fresh()->distribution_profile['email']);
        $this->assertSame('0', $p->fresh()->distribution_profile['zip_code']);
        $this->assertArrayNotHasKey('unexpected', $p->fresh()->distribution_profile);
        $this->addRoom($p);
        $data = $this->getJson('/integration/channexpro/inventory', ['Authorization' => 'Bearer profile-test'])->assertOk()->json('properties.0');
        $this->assertNull($data['domain']);
        $this->assertArrayNotHasKey('country_code', $data);
        $this->assertArrayNotHasKey('timezone', $data);
    }

    public function test_invalid_profile_is_rejected_before_property_save(): void
    {
        $p = $this->saveProperty(['distribution_profile' => $this->profile()]);
        foreach (['email' => 'bad', 'country_code' => 'NIGERIA', 'timezone' => 'Made/Up', 'latitude' => 91,
            'longitude' => -181, 'website' => 'javascript:alert(1)'] as $key => $value) {
            try {
                $this->saveProperty(['apartment_name' => 'Must not save', 'distribution_profile' => [$key => $value]], $p->id);
                $this->fail('Invalid profile accepted: '.$key);
            } catch (ValidationException $e) {
                $this->assertArrayHasKey('distribution_profile.'.$key, $e->errors());
            }
            $this->assertSame('Example Hotel', $p->fresh()->name);
        }
    }

    public function test_older_property_does_not_invent_country_or_timezone(): void
    {
        $p = $this->saveProperty(); $this->addRoom($p);
        $data = $this->getJson('/integration/channexpro/inventory', ['Authorization' => 'Bearer profile-test'])->assertOk()->json('properties.0');
        $this->assertArrayNotHasKey('country_code', $data);
        $this->assertArrayNotHasKey('timezone', $data);
    }

    public function test_form_renders_saved_values_escaped_and_is_included_in_both_wizards(): void
    {
        $p = $this->saveProperty(['distribution_profile' => array_replace($this->profile(), ['important_information' => '<script>bad()</script>'])]);
        // Exercise the actual Blade engine without unrelated site-wide nav
        // composers, which need production CMS tables.
        $html = app('view.engine.resolver')->resolve('blade')->get(
            resource_path('views/admin/properties/distribution_profile.blade.php'),
            ['property' => $p, 'errors' => new ViewErrorBag(), '__env' => app('view')]
        );
        $this->assertStringContainsString('value="bookings@example.test"', $html);
        $this->assertStringContainsString('value="00123"', $html);
        $this->assertStringContainsString('value="Europe/London" selected', $html);
        $this->assertStringNotContainsString('<script>bad()</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        foreach (['apartment_data', 'edit_shortlet'] as $view) {
            $this->assertStringContainsString("@include('admin.properties.distribution_profile')", file_get_contents(resource_path('views/admin/properties/'.$view.'.blade.php')));
        }
    }
}
