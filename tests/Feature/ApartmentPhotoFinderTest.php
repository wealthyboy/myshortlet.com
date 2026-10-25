<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Image;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use App\Services\PhotoFinder\ApartmentPhotoFinder;
use App\Services\PhotoFinder\VisualSignature;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApartmentPhotoFinderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'photo_test', 'database.connections.photo_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'uploads.disk' => 'photo-test', 'app.url' => 'https://avm.example']);
        DB::purge('photo_test'); $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Storage::fake('photo-test');
        Schema::create('system_settings', function (Blueprint $t) { $t->id(); });
        Schema::create('properties', function (Blueprint $t) { $t->id(); $t->string('name'); $t->softDeletes(); });
        Schema::create('apartments', function (Blueprint $t) { $t->id(); $t->integer('property_id'); $t->string('name'); $t->softDeletes(); });
        Schema::create('images', function (Blueprint $t) {
            $t->id(); $t->string('imageable_type'); $t->integer('imageable_id'); $t->string('image'); $t->text('caption')->nullable(); $t->timestamps(); $t->softDeletes();
        });
        require_once database_path('migrations/2026_10_25_190000_add_photo_finder_fields_to_images.php');
        (new \AddPhotoFinderFieldsToImages)->up();
        DB::table('properties')->insert([['id' => 1, 'name' => 'AVM'], ['id' => 2, 'name' => 'Second property']]);
        DB::table('apartments')->insert([['id' => 1, 'property_id' => 1, 'name' => 'Cannes'], ['id' => 2, 'property_id' => 2, 'name' => 'Mayfair']]);
    }

    private function admin(string $code = '2'): User
    {
        $user = new User(['name' => 'Photo admin']); $user->id = 1;
        $permission = new UserPermission; $permission->setRelation('permission', new Permission(['code' => $code]));
        $user->setRelation('users_permission', $permission); $this->actingAs($user);
        return $user;
    }

    private function photo(int $apartment = 1, string $type = Apartment::class): Image
    {
        return Image::create(['imageable_type' => $type, 'imageable_id' => $apartment, 'image' => 'https://untrusted.example/images/apartments/fixture-'.$apartment.'.png']);
    }

    private function bytes(): string
    {
        $image = imagecreatetruecolor(90, 70); imagefill($image, 0, 0, imagecolorallocate($image, 205, 150, 70));
        imagefilledrectangle($image, 10, 12, 40, 50, imagecolorallocate($image, 35, 65, 95));
        ob_start(); imagepng($image); $bytes = ob_get_clean(); imagedestroy($image); return $bytes;
    }

    public function test_anonymous_customers_and_staff_without_apartment_permission_cannot_search_or_tag(): void
    {
        $photo = $this->photo();
        $this->getJson('/admin/photo-finder/photos')->assertNotFound();
        $customer = new User; $customer->id = 9; $customer->setRelation('users_permission', null); $this->actingAs($customer);
        $this->postJson('/admin/photo-finder/search')->assertNotFound();
        $this->admin('3');
        $this->getJson('/admin/photo-finder/photos')->assertForbidden();
        $this->patchJson('/admin/photo-finder/photos/'.$photo->id.'/tag', ['room_tag' => 'bedroom'])->assertForbidden();
    }

    public function test_gallery_identifies_apartments_and_excludes_property_wide_or_deleted_images(): void
    {
        $this->admin(); $photo = $this->photo(); $this->photo(2); $this->photo(1, \App\Models\Property::class);
        $deleted = $this->photo(); $deleted->delete();
        $this->getJson('/admin/photo-finder/photos?property_id=1')->assertOk()->assertJsonPath('total', 1)
            ->assertJsonPath('photos.0.apartment_name', 'Cannes')->assertJsonPath('photos.0.property_name', 'AVM')
            ->assertJsonPath('photos.0.apartment_id', 1)->assertJsonMissing(['url' => $photo->image]);
        DB::table('apartments')->where('id', 1)->update(['deleted_at' => now()]);
        $this->getJson('/admin/photo-finder/photos?property_id=1')->assertOk()->assertJsonPath('total', 0);
    }

    public function test_room_tags_persist_filter_and_clear_without_reassigning_the_photo(): void
    {
        $this->admin(); $photo = $this->photo(); $foreign = $this->photo(1, \App\Models\Property::class);
        $url = '/admin/photo-finder/photos/'.$photo->id.'/tag';
        $this->patchJson($url, ['room_tag' => 'bedroom'])->assertOk()->assertJsonPath('room_tag', 'bedroom');
        $this->getJson('/admin/photo-finder/photos?room_tag=bedroom')->assertOk()->assertJsonPath('total', 1);
        $this->assertSame(1, (int) $photo->fresh()->imageable_id);
        $this->patchJson($url, ['room_tag' => '<script>'])->assertStatus(422);
        $this->patchJson('/admin/photo-finder/photos/'.$foreign->id.'/tag', ['room_tag' => 'bedroom'])->assertNotFound();
        $this->patchJson($url, ['room_tag' => null])->assertOk();
        $this->getJson('/admin/photo-finder/photos?room_tag=untagged')->assertOk()->assertJsonPath('total', 1);
    }

    public function test_preparation_uses_configured_storage_not_the_stored_url_and_search_keeps_no_reference_file(): void
    {
        $this->admin(); $photo = $this->photo(); $bytes = $this->bytes();
        Storage::disk('photo-test')->put('images/apartments/fixture-1.png', $bytes);
        $before = Storage::disk('photo-test')->allFiles();
        $this->postJson('/admin/photo-finder/prepare', ['after_id' => 0])->assertOk()->assertJsonPath('indexed', 1)->assertJsonPath('done', true);
        $this->assertNotNull($photo->fresh()->photo_signature);
        $this->postJson('/admin/photo-finder/prepare', ['after_id' => 0])->assertOk()->assertJsonPath('indexed', 0);
        $reference = UploadedFile::fake()->createWithContent('reference.png', $bytes);
        $this->post('/admin/photo-finder/search', ['photo' => $reference], ['Accept' => 'application/json'])->assertOk()
            ->assertJsonPath('indexed', 1)->assertJsonPath('photos.0.apartment_name', 'Cannes')
            ->assertJsonPath('photos.0.score', 100)->assertJsonPath('close_match', true);
        $this->assertSame($before, Storage::disk('photo-test')->allFiles());
        $this->assertSame($bytes, Storage::disk('photo-test')->get('images/apartments/fixture-1.png'));
        $this->assertSame('https://untrusted.example/images/apartments/fixture-1.png', $photo->fresh()->image);
    }

    public function test_changed_source_requires_reindex_and_unavailable_images_are_reported_safely(): void
    {
        $this->admin(); $photo = $this->photo();
        $this->postJson('/admin/photo-finder/prepare', ['after_id' => 0])->assertOk()->assertJsonPath('failed', 1)->assertJsonStructure(['reference']);
        $finder = app(ApartmentPhotoFinder::class);
        $photo->photo_signature = app(VisualSignature::class)->make($this->bytes());
        $photo->photo_signature_source = $finder->source($photo); $photo->save();
        $this->assertTrue($finder->indexed($photo));
        $photo->image = 'images/apartments/replaced.png'; $photo->save();
        $this->assertFalse($finder->indexed($photo->fresh()));
        $this->post('/admin/photo-finder/search', ['photo' => UploadedFile::fake()->createWithContent('reference.png', $this->bytes())], ['Accept' => 'application/json'])
            ->assertOk()->assertJsonPath('indexed', 0)->assertJsonPath('total', 1)->assertJsonPath('photos', []);
    }

    public function test_non_image_upload_is_rejected(): void
    {
        $this->admin();
        $this->post('/admin/photo-finder/search', ['photo' => UploadedFile::fake()->createWithContent('file.svg', '<svg/>')], ['Accept' => 'application/json'])->assertStatus(422);
    }

    public function test_preparing_many_batches_does_not_consume_the_separate_visual_search_quota(): void
    {
        $this->admin();
        for ($i = 0; $i < 18; $i++) { $this->postJson('/admin/photo-finder/prepare', ['after_id' => 0])->assertOk(); }
        $this->post('/admin/photo-finder/search', ['photo' => UploadedFile::fake()->createWithContent('reference.png', $this->bytes())], ['Accept' => 'application/json'])
            ->assertOk()->assertJsonPath('total', 0);
    }

    public function test_missing_large_original_can_use_its_existing_small_gallery_derivative(): void
    {
        $this->admin(); $photo = $this->photo();
        Storage::disk('photo-test')->put('images/apartments/m/fixture-1.png', $this->bytes());
        $this->postJson('/admin/photo-finder/prepare', ['after_id' => 0])->assertOk()->assertJsonPath('indexed', 1)->assertJsonPath('failed', 0);
        $this->assertNotNull($photo->fresh()->photo_indexed_at);
    }

    public function test_admin_screen_renders_selected_filters_and_the_real_search_controls(): void
    {
        $this->admin();
        $this->app->instance(\App\Http\ViewComposer\NavComposer::class, new class { public function compose($view) {} });
        $previousUri = $_SERVER['REQUEST_URI'] ?? null;
        $_SERVER['REQUEST_URI'] = '/admin/photo-finder';
        try {
            $response = $this->get('/admin/photo-finder?property_id=1&apartment_id=1&room_tag=bedroom')->assertOk()
                ->assertSee('Find the apartment behind the photo.')->assertSee('Prepare photo search')->assertSee('photo-finder.js');
            $dom = new \DOMDocument; @$dom->loadHTML($response->getContent()); $xpath = new \DOMXPath($dom);
            $this->assertSame(1, $xpath->query('//select[@id="pf-tag"]/option[@value="bedroom"][@selected]')->length);
            $this->assertSame(1, $xpath->query('//select[@id="pf-apartment"]/option[@value="1"][@selected]')->length);
            $this->assertSame(1, $xpath->query('//input[@id="pf-photo"][@type="file"]')->length);
            $this->assertStringNotContainsString('@selected', $response->getContent());
        } finally {
            if ($previousUri === null) { unset($_SERVER['REQUEST_URI']); } else { $_SERVER['REQUEST_URI'] = $previousUri; }
        }
    }
}
