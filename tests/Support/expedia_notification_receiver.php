<?php
// Subprocess-only sandbox adapter. Never connects to the configured AVM database.
if (getenv('APP_ENV') !== 'testing' || getenv('EXPEDIA_NOTIFICATION_TEST_ENABLED') !== 'true') exit(78);
$root = dirname(__DIR__, 2);
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
config(['database.default' => 'notification_test', 'database.connections.notification_test' => [
    'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
    'services.channexpro.shared_token' => 'notification-sandbox-only',
    'services.channexpro.reservations_enabled' => true, 'services.channexpro.events_enabled' => false]);
// Keep optional, uncommitted hotel-collect work outside this notification-only runner.
if (class_exists(\App\Services\ChannexPro\HotelCollectPayments::class)) {
    $app->instance(\App\Services\ChannexPro\HotelCollectPayments::class,
        new class extends \App\Services\ChannexPro\HotelCollectPayments {
            public function sync(\App\Models\Property $property, \App\Models\UserReservation $stay, array $booking): void {}
        });
}
DB::purge('notification_test');
if (DB::connection()->getDatabaseName() !== ':memory:') exit(78);
Bus::fake(); Mail::fake();
\Illuminate\Support\Facades\Http::fake(function () { throw new RuntimeException('Sandbox forbids external HTTP'); });
        Schema::create('system_settings', function (Blueprint $t) { $t->id(); });
        Schema::create('properties', function (Blueprint $t) {
            $t->id(); $t->text('distribution_profile')->nullable(); $t->boolean('allow')->default(true); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('apartments', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->integer('quantity')->default(1); $t->string('name')->default('Apartment');
            $t->decimal('price', 16, 2)->default(100); $t->boolean('allow')->default(true); $t->softDeletes();
        });
        Schema::create('guest_users', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('last_name'); $t->string('email');
            $t->string('phone_number')->nullable(); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('user_reservations', function (Blueprint $t) {
            $t->id(); $t->integer('property_id'); $t->integer('guest_user_id')->nullable();
            foreach (['invoice', 'coming_from', 'payment_type', 'ota_name', 'currency', 'currency_code',
                'external_id', 'status', 'checkin', 'checkout', 'pricing_snapshot', 'channex_last_revision_id', 'channex_last_revision_at'] as $field) {
                $t->text($field)->nullable();
            }
            $t->decimal('total', 16, 2)->nullable(); $t->decimal('original_amount', 16, 2)->nullable();
            $t->boolean('is_cancelled')->default(false); $t->boolean('checked')->default(false); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('reservations', function (Blueprint $t) {
            $t->id(); $t->integer('user_reservation_id'); $t->integer('apartment_id'); $t->integer('property_id');
            $t->integer('quantity'); $t->decimal('price', 16, 2); $t->string('currency'); $t->string('currency_code');
            $t->decimal('rate', 16, 6); $t->text('pricing_snapshot'); $t->string('checkin'); $t->string('checkout');
            $t->integer('length_of_stay'); $t->boolean('is_blocked')->default(false); $t->timestamps(); $t->softDeletes();
        });
        Schema::create('apartment_daily_rates', function (Blueprint $t) {
            $t->id(); $t->integer('apartment_id'); $t->integer('channex_rate_plan_id')->nullable(); $t->date('date');
            $t->timestamps(); $t->softDeletes();
        });
        Schema::create('channex_rate_plans', function (Blueprint $t) {
            $t->id(); $t->integer('apartment_id'); $t->boolean('is_active')->default(true);
            $t->boolean('is_default')->default(true); $t->string('name'); $t->softDeletes();
        });
        require_once database_path('migrations/2026_10_23_150000_create_channexpro_booking_receipts_table.php');
        (new \CreateChannexproBookingReceiptsTable)->up();
        DB::table('properties')->insert([['id' => 20, 'allow' => true], ['id' => 21, 'allow' => true]]);
        DB::table('apartments')->insert([['id' => 58, 'property_id' => 20], ['id' => 59, 'property_id' => 21]]);

$input = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$results = [];
foreach ([$input, $input] as $payload) {
    $request = \Illuminate\Http\Request::create('/api/channexpro/reservations', 'POST', [], [], [],
        ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json',
         'HTTP_AUTHORIZATION' => 'Bearer notification-sandbox-only'], json_encode($payload));
    $response = $kernel->handle($request);
    if ($response->getStatusCode() !== 200) { fwrite(STDERR, 'Sandbox receiver HTTP '.$response->getStatusCode()); exit(1); }
    $results[] = json_decode($response->getContent(), true);
    $kernel->terminate($request, $response);
}
Mail::assertNothingSent(); Mail::assertNothingQueued();
echo json_encode(['response' => $results[0], 'replay_identical' => $results[0] === $results[1],
    'reservations' => DB::table('user_reservations')->count(), 'room_lines' => DB::table('reservations')->whereNull('deleted_at')->count(),
    'receipts' => DB::table('channexpro_booking_receipts')->count(),
    'payment_requests' => Schema::hasTable('ota_payment_requests') ? DB::table('ota_payment_requests')->count() : 0, 'emails' => 0, 'database' => ':memory:'], JSON_THROW_ON_ERROR);
