<?php

namespace Database\Factories;

use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SystemSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SystemSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_name' => 'MyshortLet',
            'address' => 'Lekki',
            'store_email' => 'info@myshorlet.com',
            'store_phone' => '08169389886',
            'image' => null,
            'opening_times' => '8',
            'meta_title' => 'REal Estate',
            'meta_description' => 'Rent luxury apartments',
            'meta_tag_keywords' => 'Real Estate',
            'products_items_per_page' => '35',
            'alert_email' => 'jacob.atam@gmail.com',
            'order_status' => 'Pending',
            'invoice_prefix' => 'Inv',
            'store_logo' => 'logo.png',
            'store_icon' => 'icon.ico',
            'products_items_size_w' => 23,
            'products_items_size_h' =>32
        ];
    }
}
