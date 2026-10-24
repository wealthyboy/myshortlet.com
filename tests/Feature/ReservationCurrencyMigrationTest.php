<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ReservationCurrencyMigrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // These tests must never migrate or recreate the project's configured
        // database. Use a separate, explicitly in-memory SQLite connection only.
        config([
            'database.default' => 'reservation_currency_test',
            'database.connections.reservation_currency_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::purge('reservation_currency_test');
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());

        require_once database_path('migrations/2026_10_15_230000_ensure_currency_column_on_reservations_table.php');
    }

    public function test_it_adds_currency_even_when_apartment_id_already_exists_without_changing_existing_rows(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('apartment_id')->nullable();
        });
        DB::table('reservations')->insert(['id' => 1, 'apartment_id' => 17]);

        (new \EnsureCurrencyColumnOnReservationsTable())->up();

        $this->assertTrue(Schema::hasColumn('reservations', 'currency'));
        $row = DB::table('reservations')->first();
        $this->assertSame(1, $row->id);
        $this->assertSame(17, $row->apartment_id);
        $this->assertNull($row->currency);
        DB::table('reservations')->where('id', 1)->update(['currency' => '₦']);
        $this->assertSame('₦', DB::table('reservations')->value('currency'));
    }

    public function test_an_existing_currency_column_and_its_values_are_preserved(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable();
        });
        DB::table('reservations')->insert(['currency' => '$']);

        $migration = new \EnsureCurrencyColumnOnReservationsTable();
        $migration->up();
        $migration->up();
        $migration->down();

        $this->assertTrue(Schema::hasColumn('reservations', 'currency'));
        $this->assertSame('$', DB::table('reservations')->value('currency'));
        $this->assertSame(1, DB::table('reservations')->count());
    }

    public function test_the_corrective_migration_is_repeatable_and_rollback_does_not_drop_saved_currency(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
        });

        $migration = new \EnsureCurrencyColumnOnReservationsTable();
        $migration->up();
        DB::table('reservations')->insert(['currency' => '£']);
        $migration->up();
        $migration->down();

        $this->assertSame('£', DB::table('reservations')->value('currency'));
        $this->assertSame(1, count(array_filter(Schema::getColumnListing('reservations'), function ($column) {
            return $column === 'currency';
        })));
    }
}
