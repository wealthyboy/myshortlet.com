<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SystemSettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->updateOrInsert(
            ['id' => 1],
            [
                'store_name' => 'MyshortLet',
                'address' => 'Lekki',
                'store_email' => 'info@myshortlet.com',
                'store_phone' => '08169389886',
                'image' => null,
                'opening_times' => '8am - 6pm',
                'meta_title' => 'Myshortlet',
                'meta_description' => 'Rent luxury apartments',
                'meta_tag_keywords' => 'real estate, apartments, shortlet',
                'products_items_per_page' => 35,
                'alert_email' => 'admin@myshortlet.com',
                'order_status' => 'Pending',
                'invoice_prefix' => 'INV',
                's_h_o_l' => null,
                's_h_w_l' => null,
                'facebook_link' => null,
                'instagram_link' => null,
                'twitter_link' => null,
                'youtube_link' => null,
                'store_logo' => 'logo.png',
                'store_icon' => 'icon.ico',
                'products_items_size_h' => 32,
                'products_items_size_w' => 23,
                'payment_id' => null,
                'customer_currency_id' => null,
                'currency_id' => null,
                'location_aware' => true,
                'shipping_is_free' => false,
                'payment_gateway' => null,
                'pkey' => null,
                'type' => null,
                'allow_multi_currency' => false,
            ]
        );
    }
}
