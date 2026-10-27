<?php

namespace Tests\Feature;

use App\Models\Apartment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ApartmentAccessibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'accessibility_test', 'database.connections.accessibility_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]]);
        DB::purge('accessibility_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        $this->app->instance(\App\Http\ViewComposer\NavComposer::class, new class {
            public function compose($view) {}
        });
        Schema::create('system_settings', function (Blueprint $table) { $table->id(); });
        Schema::create('apartments', function (Blueprint $table) {
            $table->id(); $table->string('name');
            $table->boolean('elevator_access')->nullable(); // Historical, not authoritative.
            $table->timestamps(); $table->softDeletes();
        });
        Schema::create('attributes', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('type');
            $table->integer('parent_id')->nullable(); $table->softDeletes();
        });
        Schema::create('apartment_attribute', function (Blueprint $table) {
            $table->integer('apartment_id'); $table->integer('attribute_id');
        });
        DB::table('apartments')->insert([
            ['id' => 1, 'name' => 'Apartment with stairs', 'elevator_access' => true],
            ['id' => 2, 'name' => 'Apartment with elevator', 'elevator_access' => false],
            ['id' => 3, 'name' => 'No selected accessibility attribute', 'elevator_access' => true],
        ]);
        DB::table('attributes')->insert([
            ['id' => 10, 'name' => 'Accessibility', 'type' => 'apartment facilities', 'parent_id' => null],
            ['id' => 11, 'name' => 'Stairs (No Elevator)', 'type' => 'apartment facilities', 'parent_id' => 10],
            ['id' => 12, 'name' => 'Elevator Access', 'type' => 'apartment facilities', 'parent_id' => 10],
            ['id' => 13, 'name' => 'Wheelchair accessible', 'type' => 'apartment facilities', 'parent_id' => 10],
            ['id' => 20, 'name' => 'Other amenities', 'type' => 'apartment facilities', 'parent_id' => null],
            ['id' => 21, 'name' => 'Elevator Access', 'type' => 'apartment facilities', 'parent_id' => 20],
        ]);
        DB::table('apartment_attribute')->insert([
            ['apartment_id' => 1, 'attribute_id' => 11],
            ['apartment_id' => 2, 'attribute_id' => 12],
            ['apartment_id' => 3, 'attribute_id' => 13],
            ['apartment_id' => 3, 'attribute_id' => 21],
        ]);
    }

    private function apartments()
    {
        return Apartment::with('apartment_facilities.parent')->orderBy('id')->get();
    }

    public function test_each_card_uses_the_exact_selected_accessibility_attribute_from_its_own_modal(): void
    {
        $apartments = $this->apartments();
        $this->assertSame('Stairs (No Elevator)', $apartments[0]->accessibility_label);
        $this->assertSame('Elevator Access', $apartments[1]->accessibility_label);
        $this->assertNull($apartments[2]->accessibility_label);
        foreach ($apartments->take(2) as $apartment) {
            $this->assertSame($apartment->apartment_facilities->first()->name, $apartment->accessibility_label);
        }
    }

    public function test_serialization_ignores_the_old_standalone_column_and_needs_no_extra_queries(): void
    {
        $apartments = $this->apartments();
        DB::enableQueryLog(); DB::flushQueryLog();
        $apartments->each(function ($apartment) { $apartment->accessibility_label; });
        $this->assertSame([], DB::getQueryLog());
        $data = $apartments->map(function ($apartment) {
            return $apartment->setAppends(['accessibility_label'])->toArray();
        });
        $this->assertSame('Stairs (No Elevator)', $data[0]['accessibility_label']);
        $this->assertSame('Elevator Access', $data[1]['accessibility_label']);
        $this->assertNull($data[2]['accessibility_label']);
        $this->assertArrayNotHasKey('elevator_access', $data[0]);
        // Existing price initialization can read system_settings once; the new
        // accessibility field must never query attributes/pivots per card.
        $attributeQueries = collect(DB::getQueryLog())->filter(function ($query) {
            return stripos($query['query'], 'attributes') !== false
                || stripos($query['query'], 'apartment_attribute') !== false;
        });
        $this->assertCount(0, $attributeQueries);
    }

    public function test_changing_the_existing_attribute_updates_the_card_label_without_a_separate_setting(): void
    {
        $apartment = $this->apartments()->first();
        $apartment->apartment_facilities()->sync([12]);
        $apartment->load('apartment_facilities.parent');
        $this->assertSame('Elevator Access', $apartment->accessibility_label);
        $apartment->apartment_facilities()->sync([]);
        $apartment->load('apartment_facilities.parent');
        $this->assertNull($apartment->accessibility_label);
    }

    public function test_unloaded_or_deleted_attributes_do_not_invent_a_claim_or_trigger_lazy_queries(): void
    {
        $apartment = Apartment::findOrFail(1);
        DB::enableQueryLog(); DB::flushQueryLog();
        $this->assertNull($apartment->accessibility_label);
        $this->assertSame([], DB::getQueryLog());
        DB::table('attributes')->where('id', 11)->update(['deleted_at' => now()]);
        $apartment->load('apartment_facilities.parent');
        $this->assertNull($apartment->accessibility_label);
    }

    public function test_blade_card_displays_existing_text_and_admin_forms_do_not_add_duplicate_controls(): void
    {
        foreach ($this->apartments() as $apartment) {
            $html = view('_partials.elevator_access', ['obj' => $apartment])->render();
            if ($apartment->accessibility_label) {
                $this->assertStringContainsString($apartment->accessibility_label, $html);
            } else {
                $this->assertStringNotContainsString('apartment-elevator-access', $html);
            }
        }
        foreach (['shortlets', 'edit_shortlet'] as $template) {
            $this->assertStringNotContainsString('admin.apartments._accessibility', file_get_contents(resource_path('views/admin/apartments/'.$template.'.blade.php')));
        }
    }
}
