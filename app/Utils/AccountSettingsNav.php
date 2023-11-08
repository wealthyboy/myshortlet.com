<?php

namespace App\Utils;




class AccountSettingsNav
{

    public $data = array();

    public function nav()
    {

        return $nav =  [
            'Apartments' => [
                'icon' => 'material-icons text-main',
                'iconText' => 'shopping_bag',
                'link' => '/profile/apartments'
            ],
            'Bookings'  => [
                'icon' => 'material-icons text-main',
                'iconText' => 'settings',
                'link' => '/profile/bookings'
            ],
            'Profile' => [
                'icon' => 'material-icons',
                'iconText' => 'home',
                'link' => '/profile'
            ],

            'Change Password' => [
                'icon' => 'material-icons text-main',
                'iconText' => 'edit',
                'link' => '/change/password'
            ],





        ];

        return array_merge($nav, $this->data);
    }
}
